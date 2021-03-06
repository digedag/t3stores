<?php
namespace System25\T3stores\Model;

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

\tx_rnbase::load('tx_rnbase_model_base');

class Offer extends \tx_rnbase_model_base {
	const UNIT_WEIGHT = 0;
	const UNIT_ITEM = 1;
	const OFFERTYPE_SIMPLE = 0;
	const OFFERTYPE_PRODUCT = 1;
	private $product = NULL;

	public function getTableName(){return 'tx_t3stores_offer';}

	function init($rowOrUid = NULL) {
		parent::init($rowOrUid);
		if($this->isTypeProduct()) {
			// Werte vom Produkt übernehmen
			$child = $this->getProduct();
			$this->setProperty('name', $child->getName());
			$this->setProperty('hint', $child->getShortname());
			if(!$this->getProperty('weight')) {
			    $this->setProperty('weight', $child->getWeight());
			}
		}

		// Bei Unit == ITEM den Basispreis pro kg umrechnen
		if($this->isUnitItem() && ($this->record['weight'] > 0)) {
			$this->record['price'] = $this->record['price'] * ($this->record['weight'] / 1000);
		}

	}

	public function isTypeProduct() {
	    return $this->getProperty('offertype') == self::OFFERTYPE_PRODUCT;
	}
	public function isUnitItem() {
		return $this->getProperty('unit') == self::UNIT_ITEM;
	}

	protected function getProduct() {
		if($this->product === NULL) {
			$this->setProduct(\tx_rnbase::makeInstance('System25\T3stores\Model\Product', $this->getProperty('product')));
		}
		return $this->product;
	}
	protected function setProduct($product) {
		$this->product = $product;
	}
}
