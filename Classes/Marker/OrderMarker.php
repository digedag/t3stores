<?php
namespace System25\T3stores\Marker;

use System25\T3stores\Util\ServiceRegistry;
use System25\T3stores\Model\Order;
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

\tx_rnbase::load('tx_rnbase_util_SimpleMarker');

class OrderMarker extends \tx_rnbase_util_SimpleMarker {

	/**
	 * @param string $template das HTML-Template
	 * @param tx_rnbase_model_base $item
	 * @param tx_rnbase_util_FormatUtil $formatter der zu verwendente Formatter
	 * @param string $confId Pfad der TS-Config
	 * @param string $marker Name des Markers
	 * @return String das geparste Template
	 */
	protected function prepareTemplate($template, $item, $formatter, $confId, $marker) {
 		if($this->containsMarker($template, $marker.'_POSITIONS'))
 			$template = $this->addPositions($template, $item, $formatter, $confId.'position.', $marker.'_POSITION');
 		if($this->containsMarker($template, $marker.'_PROMOTION_'))
 			$template = $this->addPromotion($template, $item, $formatter, $confId.'promotion.', $marker.'_PROMOTION');
 		if($this->containsMarker($template, $marker.'_STORE_'))
 			$template = $this->addStore($template, $item, $formatter, $confId.'store.', $marker.'_STORE');
 		return $template;
	}

	protected function addStore($template, $item, $formatter, $confId, $markerPrefix) {
		$marker = \tx_rnbase::makeInstance('tx_rnbase_util_SimpleMarker');
		$child = $item->getStore();
		return $marker->parseTemplate($template, $child, $formatter, $confId, $markerPrefix);
	}
	protected function addPromotion($template, $item, $formatter, $confId, $markerPrefix) {
		$marker = \tx_rnbase::makeInstance('System25\T3stores\Marker\PromotionMarker');
		$child = $item->getPromotion();
		return $marker->parseTemplate($template, $child, $formatter, $confId, $markerPrefix);
	}
	/**
	 * Hinzufügen der Positionen.
	 * @param string $template HTML-Template
	 * @param Order $item
	 * @param \tx_rnbase_util_FormatUtil $formatter
	 * @param string $confId Config-String
	 * @param string $markerPrefix
	 */
	protected function addPositions($template, $item, $formatter, $confId, $markerPrefix) {
		$positions = $item->getPositions();
		if(empty($positions)) {
			$srv = ServiceRegistry::getOrderService();
			$fields = array();
			$fields['ORDERPOSITION.ORDERUID'][OP_EQ_INT] = $item->getUid();
			$options = array();
			\tx_rnbase_util_SearchBase::setConfigFields($fields, $formatter->getConfigurations(), $confId.'fields.');
			\tx_rnbase_util_SearchBase::setConfigOptions($options, $formatter->getConfigurations(), $confId.'options.');
			$positions = $srv->searchOrderPosition($fields, $options);
		}

		$listBuilder = \tx_rnbase::makeInstance('tx_rnbase_util_ListBuilder');
		$out = $listBuilder->render($positions,
				false, $template, 'System25\T3stores\Marker\OrderPositionMarker',
				$confId, $markerPrefix, $formatter);
		return $out;
	}
	protected function prepareItem(
			\Tx_Rnbase_Domain_Model_DataInterface $item,
			\tx_rnbase_configurations $configurations,
			$confId
	) {
		if ($item->isEmpty()) {
			return;
		}
		parent::prepareItem($item, $configurations, $confId);
		$item->setProperty('positionpricestr', $item->getProperty('positionprice') /100);
		$item->setProperty('totalpricestr', $item->getProperty('totalprice') /100);
		$item->setProperty('discountvalue', $item->getProperty('totalprice') - $item->getProperty('positionprice'));
		$item->setProperty('discountvaluestr', $item->getProperty('discountvalue') /100);
	}

}
