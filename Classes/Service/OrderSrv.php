<?php
namespace System25\T3stores\Service;

use System25\T3stores\Model\OrderPosition;
use System25\T3stores\Model\Promotion;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015-2016 Rene Nitzsche (rene@system25.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

\tx_rnbase::load('tx_rnbase_util_DB');
\tx_rnbase::load('tx_rnbase_sv1_Base');
\tx_rnbase::load('tx_rnbase_util_Logger');

class OrderSrv extends \tx_rnbase_sv1_Base {
	/**
	 *
	 * @param \System25\T3stores\Model\Order $order
	 * @param \System25\T3stores\Model\Promotion $promotion
	 * @param \tx_rnbase_configurations $configurations
	 * @param string $confId
	 */
	public function sendConfirmationMail(array $toAddress, \System25\T3stores\Model\Order $order, $promotion, $configurations, $confId, $saveToOrder) {
		\tx_rnbase::load('tx_rnbase_util_Templates');
		$fileName = $configurations->get($confId.'template');
		$subpart = $configurations->get($confId.'subpart');
		$template = \tx_rnbase_util_Templates::getSubpartFromFile($fileName, $subpart);
		$template = trim($template);

		$marker = \tx_rnbase::makeInstance('System25\T3stores\Marker\OrderMarker');
		$mailtext = $marker->parseTemplate($template, $order, $configurations->getFormatter(), $confId.'order.', 'ORDER');
		$marker = \tx_rnbase::makeInstance('System25\T3stores\Marker\PromotionMarker');
		$mailtext = $marker->parseTemplate($mailtext, $promotion, $configurations->getFormatter(), $confId.'promotion.', 'PROMOTION');

		$emailFrom = $configurations->get($confId.'emailFrom');
		$emailFromName = $configurations->get($confId.'emailFromName');

		$parts = explode(LF, $mailtext, 2);		// First line is subject
		$subject=trim($parts[0]);
		$mailtext=trim($parts[1]);
		/* @var $mail \Tx_Rnbase_Utility_Mail */
		$mail = \tx_rnbase::makeInstance('Tx_Rnbase_Utility_Mail');
		$mail->setSubject($subject);
		$mail->setFrom($emailFrom, $emailFromName);

		list($address, $name) = each($toAddress);
		$mail->addTo($address, $name);
		if($emailReply = $configurations->get($confId.'emailReply'))
			$mail->setReplyTo($emailReply);

		if($configurations->getBool($confId.'isHtmlMail')) {
			$mail->setHtmlPart($mailtext);
		}
		else
			$mail->setTextPart($mailtext);
		$mail->send();
		\tx_rnbase_util_Logger::info('Order mail send for promotion '.($order->getPromotion() ? $order->getPromotion()->getName() : '-' ), 't3stores',
				array(
					'to' => $toAddress,
					'order'=>$order->getUid(),
					'promotion'=> $order->getProperty('promotion'),
				));
		if($saveToOrder) {
			$this->handleUpdate($order, ['mailtext' => $mailtext]);
		}
	}
	/**
	 * Create a hash to secure access to this order
	 * @param \System25\T3stores\Model\Order $order
	 * @return string
	 */
	public function generateOrderKey(\System25\T3stores\Model\Order $order) {
		$key = $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'];
		$params = array();
		$params[] = $order->getCrdate();
		$params[] = $order->getUid();
		return \tx_rnbase_util_Misc::createHash($params, $key, TRUE);
	}
	/**
	 * Persist new order in database
	 * @param \System25\T3stores\Model\Order $order
	 * @param Promotion $promotion
	 * @return model
	 */
	public function createOrder(\System25\T3stores\Model\Order $order, $promotion) {
		$data = array();
		$data['pid'] = $promotion->getPid();
		$cols = array_keys(\tx_rnbase_util_TCA::getTcaColumns('tx_t3stores_order'));
		foreach ($cols As $colName) {
			if($order->hasProperty($colName)) {
				$data[$colName] = $order->getProperty($colName);
			}
		}
		$newOrder = $this->handleCreation($data);
		// Now the positions
		foreach($order->getPositions() As $position) {
			try{
				// Die Menge von der Verfügbarkeit abziehen
				$this->updateAvailability($position);
				$newPositionUid = $this->createPosition($position, $newOrder->getUid(), $promotion->getPid());
				$newOrder->addPosition(new OrderPosition($newPositionUid));
			}
			catch(\Exception $e) {
				\tx_rnbase_util_Logger::error('Position failed for order'.$order->getUid(), 't3stores',
						array('to' => $order->getCustomeremail(), 'position' => $position->getProperty()));
			}
		}
		$newOrder->setPromotion($promotion);
		return $newOrder;
	}
	/**
	 *
	 * @param \System25\T3stores\Model\OrderPosition $position
	 * @throws \Exception
	 */
	protected function updateAvailability($position) {
		$offer = $position->getOffer();
		if($offer->isUnitItem() && $offer->getAvailable() > 0) {
			// Ein int
			$amount = (int) $position->getAmount();

			$db = \Tx_Rnbase_Database_Connection::getInstance();
			$db->doUpdate('tx_t3stores_offer', 'uid='.$offer->getUid(),
					array('available' => 'available - '.$amount),
					array() , 'available');
			$rows = $db->doSelect('available', 'tx_t3stores_offer', array('where'=> 'uid='.$offer->getUid()));
			$avail = $rows[0]['available'];
			if($avail < 0) {
				// Überverkauf!! Zur Sicherheit auf 0
				$db->doUpdate('tx_t3stores_offer', 'uid='.$offer->getUid(), array('available' => 0));
				throw new \Exception('Item is sold out ('.$avail.')!');
			}
			$offer->setProperty('available', $avail);
		}
	}

	/**
	 * Create a new position
	 *
	 * @param OrderPosition $position
	 * @param int	$orderUid
	 * @return int	UID of just created record
	 */
	protected function createPosition(OrderPosition $position, $orderUid, $pid) {
		$data = array();
		$table = 'tx_t3stores_orderposition';
		$data['crdate'] = $data['tstamp'] = time();
		$data['orderuid'] = $orderUid;
		$data['pid'] = $pid;

		$cols = array_keys(\tx_rnbase_util_TCA::getTcaColumns('tx_t3stores_orderposition'));
		foreach ($cols As $colName) {
			if($position->hasProperty($colName)) {
				$data[$colName] = $position->getProperty($colName);
			}
		}

		\tx_rnbase::load('tx_rnbase_util_DB');
		$newUid = \tx_rnbase_util_DB::doInsert($table,$data);

		return $newUid;
	}

	public function getSearchClass() {
		return 'System25\T3stores\Search\Order';
	}

	public function searchOrderPosition($fields, $options) {
		\tx_rnbase::load('tx_rnbase_util_SearchBase');
		$searcher = \tx_rnbase_util_SearchBase::getInstance('System25\T3stores\Search\OrderPosition');
		return $searcher->search($fields, $options);
	}

}
