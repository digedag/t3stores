<?php
namespace System25\T3stores\Action;

use System25\T3stores\Util\ServiceRegistry;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Rene Nitzsche (rene@system25.de)
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

class JobList extends \tx_rnbase_action_BaseIOC {
	protected function handleRequest(&$parameters, &$configurations, &$viewdata) {
 		$srv = ServiceRegistry::getJobService();

 		$filter = \tx_rnbase_filter_BaseFilter::createFilter($parameters, $configurations, $viewdata, $this->getConfId(). 'item.filter.');
 		$fields = array();
		$options = array();
		$filter->init($fields, $options);

		$items = $srv->search($fields, $options);
		$viewdata->offsetSet('items', $items);
		return null;
	}

	public function getTemplateName() { return 'joblist';}
	public function getViewClassName() { return 'tx_rnbase_view_List';}
}
