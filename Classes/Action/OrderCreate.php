<?php
namespace System25\T3stores\Action;

use System25\T3stores\Util\ServiceRegistry;
use System25\T3stores\Model\Order;
use System25\T3stores\Model\OrderPosition;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Rene Nitzsche (rene@system25.de)
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

\tx_rnbase::load('tx_rnbase_action_BaseIOC');
\tx_rnbase::load('tx_rnbase_filter_BaseFilter');
\tx_rnbase::load('tx_rnbase_view_List');
\tx_rnbase::load('tx_rnbase_util_Dates');


class OrderCreate extends \tx_rnbase_action_BaseIOC {
	protected function handleRequest(&$parameters, &$configurations, &$viewdata) {
		$configurations->convertToUserInt();

		$order = $this->buildOrder($parameters);
		$viewdata->offsetSet('order', $order);

		if($parameters->get('finish')) {
			$this->handleCreate($order, $parameters, $configurations);
		}

		$data = array();
		$link = $this->createLink($configurations, $this->getConfId().'form.actionURI', array('action' => '\System25\T3stores\Action\OrderCreate'));
		$data['ACTION_PID'] = $link->destination;
		$data['ACTION_URI'] = $link->makeUrl(false);
		$data['ACTION_CTRL'] = '\System25\T3stores\Action\OrderCreate';
		$viewdata->offsetSet(\tx_rnbase_view_List::VIEWDATA_MARKER, $data);

		$viewdata->offsetSet('stores', $this->loadStores());
		return null;
	}

	/**
	 * Called on final step. Save order to database.
	 * @param Order $order
	 * @param \tx_rnbase_parameters $parameters
	 * @param \tx_rnbase_configurations $configurations
	 */
	protected function handleCreate($order, $parameters, $configurations) {
		// Die restliche Daten sammeln
		$orderData = $parameters->get('order');
		$order->record = array_merge($order->record, $orderData);
		// Pickupdate
		$promotion = $order->getPromotion();
		$days = $promotion->getPickupDays();
		if(!empty($days) && array_key_exists($order->record['pickup'], $days )) {
			$day = $days[$order->record['pickup']];
			$order->record['pickup'] = \tx_rnbase_util_Dates::date_tstamp2mysql($day->record['day']);
		}
		$orderSrv = ServiceRegistry::getOrderService();
		$newOrder = $orderSrv->createOrder($order, $promotion);
		// Mail verschicken
		if($configurations->getBool($this->getConfId().'sendMail2Customer')) {
			$orderSrv->sendConfirmationMail($order, $promotion, $configurations, $this->getConfId().'sendMail2Customer.', true);
		}
		if($configurations->getBool($this->getConfId().'sendMail2Store')) {
			$orderSrv->sendConfirmationMail($order, $promotion, $configurations, $this->getConfId().'sendMail2Store.', false);
		}

		// Redirect
		$link = $this->createLink($configurations, $this->getConfId().'redirectURI', array('action' => '\System25\T3stores\Action\OrderShow', 'uid'=>$newOrder->getUid()));
		$link->redirect();
		exit();
	}
	protected function loadStores() {
		return ServiceRegistry::getStoreService()->search(array(), array());
	}
	protected function buildOrder($parameters) {
		$order = new Order();
 		$srv = ServiceRegistry::getOfferService();
		$offers = $parameters->getCleaned('offer');
		$total = 0;
		$promotion = null;
		foreach ($offers As $uid => $offerArr) {
			// offer laden
			if(empty($offerArr['amount']))
				continue;
			$offer = $srv->get($uid);
			if($promotion === NULL) {
				$fields = array();
				$fields['OFFERGROUP.UID'][OP_EQ_INT] = $offer->record['offergroup'];
				$promotion = reset($srv->searchPromotion($fields, array()));
			}
			$orderPosition = new OrderPosition();
			$orderPosition->setOffer($offer);
			$orderPosition->record['title'] = $offer->getName();
			$orderPosition->record['amount'] = $this->parseFloat($offerArr['amount']);
			$orderPosition->record['price'] = $offer->getPrice();
			$orderPosition->record['total'] = round($offer->getPrice() * $orderPosition->getAmount());
			$order->addPosition($orderPosition);
			$total += $orderPosition->getTotal();
		}
		if($promotion === NULL) {
			throw new \Exception('Promotion not found');
		}
		$order->setPromotion($promotion);
		$order->record['promotion'] = $promotion->getUid();
		$order->record['positionprice'] = $total;
		$discount = $promotion->getDiscount();
		$order->record['totalprice'] = round($total - ($total * $discount/100));
		return $order;
	}
	private function parseFloat($amount) {
		$amount = str_replace(',', '.', $amount);
		return floatval($amount);
	}

	public function getTemplateName() { return 'ordercreate';}
	public function getViewClassName() { return 'System25\T3stores\View\OrderCreate';}

}
