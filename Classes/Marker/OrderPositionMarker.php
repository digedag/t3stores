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

class OrderPositionMarker extends \tx_rnbase_util_SimpleMarker {

	/**
	 * @param string $template das HTML-Template
	 * @param tx_rnbase_model_base $item
	 * @param tx_rnbase_util_FormatUtil $formatter der zu verwendente Formatter
	 * @param string $confId Pfad der TS-Config
	 * @param string $marker Name des Markers
	 * @return String das geparste Template
	 */
	protected function prepareTemplate($template, $item, $formatter, $confId, $marker) {
 		if($this->containsMarker($template, $marker.'_OFFER_'))
 			$template = $this->addOffer($template, $item, $formatter, $confId.'offer.', $marker.'_OFFER');

		return $template;
	}

	protected function addOffer($template, $item, $formatter, $confId, $markerPrefix) {
		$marker = \tx_rnbase::makeInstance('\System25\T3stores\Marker\OfferMarker');
		$child = $item->getOffer();
		return $marker->parseTemplate($template, $child, $formatter, $confId, $markerPrefix);
	}

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
		$item->record['totalstr'] = $item->record['total'] /100;
	}

}
