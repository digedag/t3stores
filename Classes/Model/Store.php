<?php
namespace System25\T3stores\Model;

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

\tx_rnbase::load('tx_rnbase_model_base');
\tx_rnbase::load('tx_rnbase_maps_ILocation');

class Store extends \tx_rnbase_model_base implements \tx_rnbase_maps_ILocation {

	public function getTableName(){return 'tx_t3stores_store';}

	/**
	 * Whether or not the single view is enabled
	 *
	 * @return boolean
	 */
	public function hasReport() {
		return intval($this->getProperty('hasreport')) > 0;
	}
	/* (non-PHPdoc)
	 * @see tx_rnbase_maps_ILocation::getCity()
	 */
	public function getCity() {
		return $this->getProperty('city');
	}

	/* (non-PHPdoc)
	 * @see tx_rnbase_maps_ILocation::getStreet()
	 */
	public function getStreet() {
		return $this->getProperty('address');
	}

	/* (non-PHPdoc)
	 * @see \tx_rnbase_maps_ILocation::getZip()
	 */
	public function getZip() {
		return $this->getProperty('zip');
	}
	public function getEmail() {
		return $this->getProperty('email');
	}

	/* (non-PHPdoc)
	 * @see \tx_rnbase_maps_ILocation::getCountryCode()
	 */
	public function getCountryCode() {
		return $this->getProperty('countrycode');
	}
	public function getLatitude() {
		return $this->getProperty('lat');
	}
	public function getLongitude() {
		return $this->getProperty('lng');
	}
}
