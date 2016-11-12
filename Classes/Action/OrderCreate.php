<?php
namespace System25\T3stores\Action;

use System25\T3stores\Util\ServiceRegistry;
use System25\T3stores\Model\Order;
use System25\T3stores\Model\OrderPosition;
use System25\T3stores\Util\Errors;
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

\tx_rnbase::load('tx_rnbase_action_BaseIOC');
\tx_rnbase::load('tx_rnbase_filter_BaseFilter');
\tx_rnbase::load('tx_rnbase_view_List');
\tx_rnbase::load('tx_rnbase_util_Dates');


class OrderCreate extends \tx_rnbase_action_BaseIOC {
	protected function handleRequest(&$parameters, &$configurations, &$viewdata) {
		$configurations->convertToUserInt();

		// es gibt zwei Modi:
		// 1. Promotion wird direkt in OrderCreate konfiguriert
		if($promotionId = $configurations->getInt($this->getConfId().'promotionId')) {
			$promotion = ServiceRegistry::getPromotionService()->get($promotionId);
			$viewdata->offsetSet('promotion', $promotion);
			$order = $this->buildFullOrderForm($promotion, $parameters);
		}
		else {
			// 2. Zugriff über OfferGroupList
			$order = $this->buildOrder($parameters);
		}

		$viewdata->offsetSet('order', $order);

		if($parameters->get('finish')) {
			$this->handleCreate($order, $parameters, $configurations);
		}

		$data = array();
		$link = $this->createLink($configurations, $this->getConfId().'form.actionURI', array('action' => 'System25\T3stores\Action\OrderCreate'));
		$data['ACTION_PID'] = $link->destination;
		$data['ACTION_URI'] = $link->makeUrl(false);
		$data['ACTION_CTRL'] = 'System25\T3stores\Action\OrderCreate';
		$viewdata->offsetSet(\tx_rnbase_view_List::VIEWDATA_MARKER, $data);

		$viewdata->offsetSet('stores', $this->loadStores($order->getPromotion()));
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
		$order->setProperty(array_merge($order->getProperty(), $orderData));
		// Pickupdate
		$promotion = $order->getPromotion();
		$days = $promotion->getPickupDays();
		if(preg_match('/\d{1,2}\.\d{1,2}\.\d{4}/', $order->getProperty('pickup'))) {
			// Datum direkt übergeben
			$date = new \DateTime($order->getProperty('pickup') . ' 12:00');
			$order->setProperty('pickup', $date->format('U'));
		}
		if(!empty($days) && array_key_exists($order->getProperty('pickup'), $days )) {
			$day = $days[$order->getProperty('pickup')];
			$order->setProperty('pickup', \tx_rnbase_util_Dates::date_tstamp2mysql($day->getProperty('day')));
		}
		else
			$order->setProperty('pickup', '');

		// Daten prüfen, wirft ggf eine Exception
		$this->validateOrder($order);
		// jetzt die Order speichern
		$orderSrv = ServiceRegistry::getOrderService();
		$newOrder = $orderSrv->createOrder($order, $promotion);
		// Mail verschicken
		if($configurations->getBool($this->getConfId().'sendMail2Customer')) {
			$mailOptions = [
					'saveToOrder' => true,
			];
			$orderSrv->sendConfirmationMail(array($order->getCustomeremail() => $order->getCustomername()),
					$newOrder, $promotion, $configurations, $this->getConfId().'sendMail2Customer.', $mailOptions);
		}
		if($configurations->getBool($this->getConfId().'sendMail2Store')) {
			$emailTo = $configurations->get($this->getConfId().'sendMail2Store.emailTo');

			if($configurations->getBool($this->getConfId().'sendMail2Store.useStoreMail', false)) {
				if($store = $order->getStore()) {
					$emailTo = $store->getEmail() ? $store->getEmail() : $emailTo;
				}
			}
			$emailToName = $configurations->get($this->getConfId().'sendMail2Store.emailToName');
			$mailOptions = [
					'saveToOrder' => false,
					'replyTo' => array($order->getCustomeremail() => $order->getCustomername()),
			];
			$orderSrv->sendConfirmationMail(array($emailTo => $emailToName),
					$newOrder, $promotion, $configurations, $this->getConfId().'sendMail2Store.', $mailOptions);
		}
		// Redirect
		$link = $this->createLink($configurations, $this->getConfId().'redirectURI', array(
				'action' => 'System25\T3stores\Action\OrderShow',
				'uid'=>$newOrder->getUid(),
				'key'=>$orderSrv->generateOrderKey($newOrder),
		));
		$link->redirect();
		exit();
	}
	/**
	 *
	 * @param Order $order
	 */
	protected function validateOrder($order) {
		// Abholdatum
		if(!$order->getProperty('pickup')) {
			throw new \Exception('No pickup date found', Errors::CODE_NO_PICKUPDATE_FOUND);
		}
		// Filiale
		if(!$order->getProperty('store')) {
			// Handelt es sich um eine Aktion mit nur einer Filiale?
			$stores = $this->loadStores($order->getPromotion());
			if(count($stores) == 1) {
				$order->setStore(reset($stores));
			}
			else
				throw new \Exception('No store found', Errors::CODE_NO_STORE_FOUND);
		}
		$this->assertPositions(empty($order->getPositions()) ? 0 : count($order->getPositions()));
	}

	/**
	 * Returns the available stores
	 * can be configured by categories in plugin
	 * or by store relation in promotion record
	 * @param Promotion $promotion
	 */
	protected function loadStores($promotion) {
		// Die Stores in der Promotion haben Vorrang
		$stores = ServiceRegistry::getStoreService()->searchByPromotion($promotion);
		if($stores) {
			return $stores;
		}

		// Jetzt im Plugin suchen
		$fields = $options = array();

		\tx_rnbase_util_SearchBase::setConfigFields($fields, $this->getConfigurations(), $this->getConfId().'form.stores.filter.fields.');
		\tx_rnbase_util_SearchBase::setConfigOptions($options, $this->getConfigurations(), $this->getConfId().'form.stores.filter.options.');

		$stores = ServiceRegistry::getStoreService()->search($fields, $options);
		return $stores;
	}
	/**
	 *
	 * @param Promotion $promotion
	 * @param \tx_rnbase_parameters $parameters
	 */
	protected function buildFullOrderForm($promotion, $parameters) {
 		$offerSrv = ServiceRegistry::getOfferService();
		$order = new Order();
		$order->setPromotion($promotion);
		$offers = $parameters->get('offer');
		if(!empty($offers)) {
			$total = 0;
			$positionCnt = 0;
			foreach ($offers As $uid => $offerArr) {
				// offer laden
				if(empty($offerArr['amount']))
					continue;
					$offer = $offerSrv->get($uid);
					// Verfügbarkeit prüfen
					$amount = $this->validateAmount($offerArr['amount'], $offer);
					if($amount <= 0)
						continue;

					$positionCnt += 1;
					$orderPosition = $this->createPosition($offer, $amount);
					$order->addPosition($orderPosition);
					$total += $orderPosition->getTotal();
			}
			$this->assertPositions($positionCnt);
			$order->setProperty('positionprice', $total);
			$discount = $promotion->getDiscount();
			$order->setProperty('totalprice', round($total - ($total * $discount/100)));
		}

		$order->setPromotion($promotion);
		$order->setProperty('promotion', $promotion->getUid());

		return $order;
	}
	protected function assertPositions($positionCnt) {
		if($this->getConfigurations()->getBool($this->getConfId().'form.validate.positions', false, true) && $positionCnt == 0) {
			throw new \Exception('No positions found.', Errors::CODE_NO_POSITIONS_FOUND);
		}
	}
	protected function buildOrder($parameters) {
		$order = new Order();
 		$srv = ServiceRegistry::getOfferService();
		$offers = $parameters->get('offer');
		if(!is_array($offers) || empty($offers)) {
			throw new \Exception('No offers found', Errors::CODE_INVALID_REQUEST);
		}
		$total = 0;
		$promotion = null;
		$positionCnt = 0;
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
			// Verfügbarkeit prüfen
			$amount = $this->validateAmount($offerArr['amount'], $offer);
			if($amount <= 0)
				continue;

			$positionCnt += 1;
			$orderPosition = $this->createPosition($offer, $amount);
			$order->addPosition($orderPosition);
			$total += $orderPosition->getTotal();
		}
		if($positionCnt == 0) {
			throw new \Exception('No positions found.', Errors::CODE_NO_POSITIONS_FOUND);
		}
		if($promotion === NULL) {
			throw new \Exception('Promotion not found', Errors::CODE_PROMOTION_NOT_FOUND);
		}
		$order->setPromotion($promotion);
		$order->setProperty('promotion', $promotion->getUid());
		$order->setProperty('positionprice', $total);
		$discount = $promotion->getDiscount();
		$order->setProperty('totalprice', round($total - ($total * $discount/100)));
		return $order;
	}
	protected function createPosition($offer, $amount) {
		$orderPosition = new OrderPosition();
		$orderPosition->setOffer($offer);
		$orderPosition->setProperty('title', $offer->getName());
		// Die Menge ggf. anpassen
		$orderPosition->setProperty('amount', $amount);
		$orderPosition->setProperty('pricelabel', $offer->getPricelabel());
		$orderPosition->setProperty('price', $offer->getPrice());
		$orderPosition->setProperty('unit', $offer->getUnit());
		$orderPosition->setProperty('total', round($offer->getPrice() * $orderPosition->getAmount()));
		return $orderPosition;
	}

	/**
	 *
	 * @param number $amount
	 * @param \System25\T3stores\Model\Offer $offer
	 * @return number
	 */
	private function validateAmount($amount, $offer) {
		if($offer->isUnitItem()) {
			// Ein int
			$amount = (int) $amount;
			$avail = $offer->getAvailable();
			if($avail >= 0) { // bei negativem Amount ist unbegrenzte Bestellung möglich
				$amount = $amount < $avail ? $amount : $avail;
			}
		}
		else {
			$amount = $this->parseFloat($amount);
		}

		return $amount;
	}
	private function parseFloat($amount) {
		$amount = str_replace(',', '.', $amount);
		return floatval($amount);
	}

	public function getTemplateName() { return 'ordercreate';}
	public function getViewClassName() { return 'System25\T3stores\View\OrderCreate';}

}
