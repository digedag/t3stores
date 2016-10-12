<?php
namespace System25\T3stores\Service;

use System25\T3stores\Model\Promotion;
use System25\T3stores\Model\Store;

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

\tx_rnbase::load('tx_rnbase_util_DB');

class StoreSrv extends \TYPO3\CMS\Core\Service\AbstractService {
	/**
	 *
	 * @param Promotion $promotion
	 * @return [Store]
	 */
	public function searchByPromotion($promotion) {
		$fields = $options = array();
		$fields['STOREMM.UID_FOREIGN'][OP_EQ_INT] = $promotion->getUid();
		return $this->search($fields, $options);
	}
	/**
	 * Search database for stores
	 *
	 * @param array $fields
	 * @param array $options
	 * @return array[System25\T3stores\Model\Store]
	 */
	public function search($fields, $options) {
		\tx_rnbase::load('tx_rnbase_util_SearchBase');
		$searcher = \tx_rnbase_util_SearchBase::getInstance('System25\T3stores\Search\Store');
		return $searcher->search($fields, $options);
	}

}
