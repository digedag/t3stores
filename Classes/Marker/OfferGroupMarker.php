<?php
namespace System25\T3stores\Marker;

use System25\T3stores\Model\OfferGroup;
use System25\T3stores\Util\ServiceRegistry;
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

class OfferGroupMarker extends \tx_rnbase_util_SimpleMarker {

	/**
	 * @param string $template das HTML-Template
	 * @param tx_rnbase_model_base $item
	 * @param tx_rnbase_util_FormatUtil $formatter der zu verwendente Formatter
	 * @param string $confId Pfad der TS-Config
	 * @param string $marker Name des Markers
	 * @return String das geparste Template
	 */
	protected function prepareTemplate($template, $item, $formatter, $confId, $marker) {
		if($this->containsMarker($template, $marker.'_OFFERS'))
			$template = $this->addOffers($template, $item, $formatter, $confId.'offer.', $marker.'_OFFER');

		return $template;
	}

	/**
	 * Hinzufügen der Angebote.
	 * @param string $template HTML-Template
	 * @param OfferGroup $item
	 * @param \tx_rnbase_util_FormatUtil $formatter
	 * @param string $confId Config-String
	 * @param string $markerPrefix
	 */
	protected function addOffers($template, $item, $formatter, $confId, $markerPrefix) {
 		$srv = ServiceRegistry::getOfferService();
		$fields = array();
		$fields['OFFER.OFFERGROUP'][OP_EQ_INT] = $item->getUid();
		$options = array();
		\tx_rnbase_util_SearchBase::setConfigFields($fields, $formatter->configurations, $confId.'fields.');
		\tx_rnbase_util_SearchBase::setConfigOptions($options, $formatter->configurations, $confId.'options.');
		$children = $srv->search($fields, $options);

		$listBuilder = \tx_rnbase::makeInstance('tx_rnbase_util_ListBuilder');
		$out = $listBuilder->render($children,
				false, $template, 'System25\T3stores\Marker\OfferMarker',
				$confId, $markerPrefix, $formatter);
		return $out;
	}

}
