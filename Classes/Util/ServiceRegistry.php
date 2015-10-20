<?php
namespace System25\T3stores\Util;

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


\tx_rnbase::load('tx_rnbase_util_Misc');

/**
 * Access a service instance
 */
class ServiceRegistry {

	/**
	 * Liefert den Store-Service
	 * @return \System25\T3stores\Service\Store
	 */
	public static function getStoreService() {
		return \tx_rnbase_util_Misc::getService('t3stores', 'store');
	}
	/**
	 * Liefert den Offer-Service
	 * @return \System25\T3stores\Service\Offer
	 */
	public static function getOfferService() {
		return \tx_rnbase_util_Misc::getService('t3stores', 'offer');
	}
}
