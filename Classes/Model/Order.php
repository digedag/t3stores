<?php
namespace System25\T3stores\Model;

use System25\T3stores\Model\Promotion;

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

\tx_rnbase::load('Tx_Rnbase_Domain_Model_Base');

class Order extends \Tx_Rnbase_Domain_Model_Base {
	private $positions = array();
	private $promotion = NULL;
	private $store = NULL;

	public function getTableName(){return 'tx_t3stores_order';}

	public function addPosition($position) {
		$this->positions[] = $position;
	}
	public function getPositions() {
		return $this->positions;
	}
	public function setPromotion(Promotion $promo) {
		$this->promotion = $promo;
	}
	/**
	 * @return Promotion
	 */
	public function getPromotion() {
		return $this->promotion;
	}

	/**
	 * @return Store
	 */
	public function getStore() {
		if($this->store === NULL) {
			$this->setStore(\tx_rnbase::makeInstance('System25\T3stores\Model\Store', $this->getProperty('store')));
		}
		return $this->store;
	}
	public function setStore($store) {
		$this->store = $store;
		$this->setProperty('store', is_object($store) ? $store->getUid() : '');
	}
}
