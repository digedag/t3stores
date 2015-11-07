<?php
namespace System25\T3stores\Service;

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

\tx_rnbase::load('tx_rnbase_util_DB');
\tx_rnbase::load('tx_rnbase_sv1_Base');

class Order extends \tx_rnbase_sv1_Base {
	public function createOrder(\System25\T3stores\Model\Order $order) {
		$data = array();
		$cols = array_keys(\tx_rnbase_util_TCA::getTcaColumns('tx_t3stores_order'));
		foreach ($cols As $colName) {
			if(array_key_exists($colName, $order->record)) {
				$data[$colName] = $order->record[$colName];
			}
		}
		$newOrder = $this->handleCreation($data);
		// Now the positions
		foreach($order->getPositions() As $position) {
			$newPositionUid = $this->createPosition($position, $newOrder->getUid());
			$newOrder->addPosition(new OrderPosition($newPositionUid));
		}
		return $newOrder;
	}

	/**
	 * Create a new position
	 *
	 * @param OrderPosition $position
	 * @param int	$orderUid
	 * @return int	UID of just created record
	 */
	protected function createPosition(OrderPosition $position, $orderUid) {
		$data = array();
		$table = 'tx_t3stores_orderposition';
		$data['crdate'] = $data['tstamp'] = time();
		$data['orderuid'] = $orderUid;

		$cols = array_keys(\tx_rnbase_util_TCA::getTcaColumns('tx_t3stores_orderposition'));
		foreach ($cols As $colName) {
			if(array_key_exists($colName, $position->record)) {
				$data[$colName] = $position->record[$colName];
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
