<?php
namespace System25\T3stores\Service;

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

\tx_rnbase::load('tx_rnbase_util_DB');
\tx_rnbase::load('tx_rnbase_sv1_Base');

class OfferSrv extends \tx_rnbase_sv1_Base {
	/**
	 * Search database for stores
	 *
	 * @param array $fields
	 * @param array $options
	 * @return array[System25\T3stores\Model\Store]
	 */
// 	public function search($fields, $options) {
// 		\tx_rnbase::load('tx_rnbase_util_SearchBase');
// 		$searcher = \tx_rnbase_util_SearchBase::getInstance('System25\T3stores\Search\Offer');
// 		return $searcher->search($fields, $options);
// 	}
	public function getSearchClass() {
		return 'System25\T3stores\Search\Offer';
	}

	public function searchOfferGroup($fields, $options) {
		\tx_rnbase::load('tx_rnbase_util_SearchBase');
		$searcher = \tx_rnbase_util_SearchBase::getInstance('System25\T3stores\Search\OfferGroup');
		return $searcher->search($fields, $options);
	}
	public function searchPromotion($fields, $options) {
		\tx_rnbase::load('tx_rnbase_util_SearchBase');
		$searcher = \tx_rnbase_util_SearchBase::getInstance('System25\T3stores\Search\Promotion');
		return $searcher->search($fields, $options);
	}
}
