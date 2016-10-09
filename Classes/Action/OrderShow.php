<?php
namespace System25\T3stores\Action;

use System25\T3stores\Util\ServiceRegistry;
use System25\T3stores\Model\Order;
use System25\T3stores\Model\OrderPosition;
use System25\T3stores\Util\Errors;
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


class OrderShow extends \tx_rnbase_action_BaseIOC {
	protected function handleRequest(&$parameters, &$configurations, &$viewdata) {

		$key = $parameters->get('key');
		$itemId = $parameters->getInt('uid');
		/* @var $item \System25\T3stores\Model\Order */
		$item = \tx_rnbase::makeInstance('System25\T3stores\Model\Order', $itemId);
		if(!$item->isValid() || !$key) {
			throw new \Exception('Access denied', Errors::CODE_ORDER_INVALID);
		}

		$validKey = ServiceRegistry::getOrderService()->generateOrderKey($item);
		if($key != $validKey) {
			throw new \Exception('Access denied', Errors::CODE_ORDER_KEY_INVALID);
		}

		$viewdata->offsetSet('order', $item);
		return null;
	}


	public function getTemplateName() { return 'ordershow';}
	public function getViewClassName() { return 'System25\T3stores\View\OrderShow';}

}
