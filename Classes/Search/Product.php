<?php
namespace System25\T3stores\Search;

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

\tx_rnbase::load('tx_rnbase_util_SearchBase');
\tx_rnbase::load('tx_rnbase_util_Misc');

class Product extends \tx_rnbase_util_SearchBase {
	protected function getTableMappings() {
		$tableMapping = array();
		$tableMapping['PRODUCT'] = 'tx_t3stores_product';
		$tableMapping['CATMM'] = 'sys_category_record_mm';
		// Hook to append other tables
		\tx_rnbase_util_Misc::callHook('t3stores','search_Product_getTableMapping_hook',
			array('tableMapping' => &$tableMapping), $this);
		return $tableMapping;
	}

	protected function getBaseTable() {
		return 'tx_t3stores_product';
	}
	protected function getBaseTableAlias() {return 'PRODUCT';}
	public function getWrapperClass() {
		return '\System25\T3stores\Model\Product';
	}

	protected function getJoins($tableAliases) {
		$join = '';
		if(isset($tableAliases['CATMM'])) {
			$join .= ' JOIN sys_category_record_mm CATMM ON CATMM.uid_foreign = PRODUCT.uid ';
		}
		// Hook to append other tables
		\tx_rnbase_util_Misc::callHook('t3stores','search_Product_getJoins_hook',
			array('join' => &$join, 'tableAliases' => $tableAliases), $this);
		return $join;
	}
	protected function useAlias() {
		return TRUE;
	}
}
