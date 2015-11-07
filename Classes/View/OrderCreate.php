<?php
namespace System25\T3stores\View;

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

\tx_rnbase::load('tx_rnbase_view_Base');
\tx_rnbase::load('tx_rnbase_util_Templates');
\tx_rnbase::load('tx_rnbase_view_List');

class OrderCreate extends \tx_rnbase_view_Base {
	function createOutput($template, &$viewData, &$configurations, &$formatter) {

		$markerData = $viewData->offsetGet(\tx_rnbase_view_List::VIEWDATA_MARKER);
		$confId = $this->getController()->getConfId();

		$order = $viewData->offsetGet('order');
		$marker = \tx_rnbase::makeInstance('System25\T3stores\Marker\OrderMarker');

		$template = $marker->parseTemplate($template, $order, $formatter, $confId.'order.', 'ORDER');

		$marker = \tx_rnbase::makeInstance('System25\T3stores\Marker\PromotionMarker');
		$template = $marker->parseTemplate($template, $order->getPromotion(), $formatter, $confId.'promotion.', 'PROMOTION');

		$stores = $viewData->offsetGet('stores');
		$listBuilder = \tx_rnbase::makeInstance('tx_rnbase_util_ListBuilder');
		$itemPath = 'store';
		$template = $listBuilder->render($stores, $viewData, $template, 'tx_rnbase_util_SimpleMarker',
				$confId.$itemPath.'.', strtoupper($itemPath), $formatter
		);

		$markerArray = $formatter->getItemMarkerArrayWrapped($markerData, $confId.'markers.');
		$subpartArray = array();

		$template = \tx_rnbase_util_Templates::substituteMarkerArrayCached($template, $markerArray, $subpartArray); //, $wrappedSubpartArray);

		return $template;
	}
	function getMainSubpart(&$viewData) {
		return '###ORDERCREATE###';
	}
}
