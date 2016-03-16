<?php
namespace System25\T3stores\Action;

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

\tx_rnbase::load('tx_rnbase_action_BaseIOC');
\tx_rnbase::load('tx_rnbase_filter_BaseFilter');
\tx_rnbase::load('tx_rnbase_view_List');

class OfferGroupList extends \tx_rnbase_action_BaseIOC {
	protected function handleRequest(&$parameters, &$configurations, &$viewdata) {
 		$srv = ServiceRegistry::getOfferService();

 		$filter = \tx_rnbase_filter_BaseFilter::createFilter($parameters, $configurations, $viewdata, $this->getConfId(). 'item.filter.');
 		$fields = array();
		$options = array();
		if($uid = $parameters->getInt('promotion')) {
			$fields['OFFERGROUP.PROMOTION'][OP_EQ_INT] = $uid;
		}

		$filter->init($fields, $options);
		$items = $srv->searchOfferGroup($fields, $options);
		$viewdata->offsetSet('items', $items);
		$data = array();
		$link = $this->createLink($configurations, $this->getConfId().'form.actionURI', array('action' => 'System25\T3stores\Action\OrderCreate'));
		$data['ACTION_PID'] = $link->destination;
		$data['ACTION_URI'] = $link->makeUrl(false);
		$data['ACTION_CTRL'] = 'System25\T3stores\Action\OrderCreate';
		$viewdata->offsetSet(\tx_rnbase_view_List::VIEWDATA_MARKER, $data);
		return null;
	}

	public function getTemplateName() { return 'offergrouplist';}
	public function getViewClassName() { return 'tx_rnbase_view_List';} // 'System25\T3stores\View\StoreList'

}
