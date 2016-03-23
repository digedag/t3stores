<?php
namespace System25\T3stores\Marker;

use System25\T3stores\Model\OfferGroup;
use System25\T3stores\Model\Offer;
use System25\T3stores\Util\ServiceRegistry;
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

\tx_rnbase::load('tx_rnbase_util_SimpleMarker');
\tx_rnbase::load('tx_rnbase_model_base');

class OfferMarker extends \tx_rnbase_util_SimpleMarker {

	protected function prepareItem(
			\tx_rnbase_model_base $item,
			\tx_rnbase_configurations $configurations,
			$confId
	) {
		if (empty($item->record)) {
			return;
		}
		parent::prepareItem($item, $configurations, $confId);
		$item->record['pricestr'] = $item->record['price'] /100;
	}
	/**
	 * @param string $template das HTML-Template
	 * @param tx_rnbase_model_base $item
	 * @param tx_rnbase_util_FormatUtil $formatter der zu verwendente Formatter
	 * @param string $confId Pfad der TS-Config
	 * @param string $marker Name des Markers
	 * @return String das geparste Template
	 */
	public function prepareTemplate($template, $item, $formatter, $confId, $marker) {
		if($this->containsMarker($template, $marker.'_PRODUCT'))
			$template = $this->addProduct($template, $item, $formatter, $confId.'product.', $marker.'_PRODUCT');

		return $template;
	}
	protected function addProduct($template, $item, $formatter, $confId, $markerPrefix) {
		$child = $item->getProduct();
		$marker = \tx_rnbase::makeInstance('System25\T3stores\Marker\ProductMarker');
		return $marker->parseTemplate($template, $child, $formatter, $confId, $markerPrefix);
	}

	protected function prepareSubparts(array &$wrappedSubpartArray, array &$subpartArray,
		$template, $item, $formatter, $confId, $marker) {
		$unit = $item->getUnit();
		if(Offer::UNIT_ITEM == $unit) {
			$wrappedSubpartArray['###ITEM_OFFER_UNIT_ITEM###'] = array('', '');
			$subpartArray['###ITEM_OFFER_UNIT_WEIGHT###'] = '';
		}
		else {
			$wrappedSubpartArray['###ITEM_OFFER_UNIT_WEIGHT###'] = array('', '');
			$subpartArray['###ITEM_OFFER_UNIT_ITEM###'] = '';
		}
	}
}
