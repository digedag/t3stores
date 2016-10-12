<?php
namespace System25\T3stores\Filter;

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

\tx_rnbase::load('tx_rnbase_util_BaseMarker');
\tx_rnbase::load('tx_rnbase_filter_BaseFilter');

class Store extends \tx_rnbase_filter_BaseFilter {
	private $searchLocation;
	private $geoCode;

	/**
	 * Abgeleitete Filter können diese Methode überschreiben und zusätzliche Filter setzen
	 *
	 * @param array $fields
	 * @param array $options
	 * @param tx_rnbase_IParameters $parameters
	 * @param tx_rnbase_configurations $configurations
	 * @param string $confId
	 */
	protected function initFilter(&$fields, &$options, &$parameters, &$configurations, $confId) {
		$configurations->convertToUserInt();
		$this->searchLocation = $parameters->getCleaned('location');
		if($this->searchLocation) {
			/* @var $geoCoder \tx_rnbase_maps_google_Util */
			$geoCoder = \tx_rnbase::makeInstance('tx_rnbase_maps_google_Util');
			// TODO: change to lookupGeoCodeCached
			$this->geoCode = $geoCoder->lookupGeoCode($this->searchLocation);
		}
		if($this->geoCode) {
			//$options['debug'] = 1;
			$options['forcewrapper'] = 1;
			$lat = $this->geoCode['lat'];
			$long = $this->geoCode['lng'];
			$options['what'] = 'STORE.*,((ACOS(SIN('.$lat.' * PI() / 180)
					* SIN(`lat` * PI() / 180) + COS('.$lat.' * PI() / 180)
					* COS(`lat` * PI() / 180) * COS(('.$long.' - `lng`) * PI() / 180))
					* 180 / PI()) * 60 * 1.1515 * 1.60934) AS `distance`';
			$options['orderby'][SEARCH_FIELD_CUSTOM] = 'distance asc';
		}
		return TRUE;
	}
	/* (non-PHPdoc)
	 * @see tx_rnbase_filter_BaseFilter::hideResult()
	 */
	public function hideResult() {
		if(!$this->getConfigurations()->getBool($this->getConfId().'hideResultInitial'))
			return FALSE;
		$params = $this->getParameters()->getAll();
		return $params ? FALSE : TRUE;
	}

	function parseTemplate($template, &$formatter, $confId, $marker = 'FILTER') {
		if(!\tx_rnbase_util_BaseMarker::containsMarker($template, 'SEARCHFORM'))
			return $template;
		$fileName = $formatter->getConfigurations()->get($confId.'template');
		$subpart = $formatter->getConfigurations()->get($confId.'subpart');
		$searchTemplate = '';
		try {
			$searchTemplate = \tx_rnbase_util_Templates::getSubpartFromFile($fileName, $subpart);
			$markerArray = array();
			$link = $this->createPageUri($formatter->getConfigurations(), $confId.'form.');
			$markerArray['###ACTION_URI###'] = $link->makeUrl(false);
			$markerArray['###ACTION_PID###'] = $link->destination;
			$markerArray['###SEARCH_LOCATION###'] = htmlspecialchars( $this->searchLocation);
			$searchTemplate = \tx_rnbase_util_Templates::substituteMarkerArrayCached($searchTemplate, $markerArray);
		}
		catch(Exception $e) {
			$searchTemplate = $e->getMessage();
		}
		$markerArray = array(
				'###SEARCHFORM###' => $searchTemplate,
		);
		$template = \tx_rnbase_util_Templates::substituteMarkerArrayCached($template, $markerArray);
		return $template;
	}
	/**
	 *
	 * @param tx_rnbase_configurations $configurations
	 */
	protected function createPageUri($configurations, $confId, $params = array()) {
		$link = $configurations->createLink();
		$link->initByTS($configurations, $confId.'formUrl.', $params);
		if($configurations->get($confId.'formUrl.noCache'))
			$link->noCache();
		return $link;
	}
}
