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

class Promotion extends \tx_rnbase_model_base {

	public function getTableName(){return 'tx_t3stores_promotion';}

	/**
	 * Der Shop wird geschlossen, wenn keine Vorbestellung mehr möglich ist
	 * @return boolean
	 */
	public function isOpen($today = null) {
		$days = $this->getDays($today);
		return !empty($days);
	}
	/**
	 * Liefert die möglichen Abholtage.
	 * Key des Arrays ist die "UID" des Termins.
	 * @return multitype:multitype:\tx_rnbase_model_base
	 */
	public function getPickupDays($today = null) {
		$allDays = $this->getAllPickupDays();
		$days = array();
		$today = $today !== NULL && $today instanceof \DateTime ? $today : new \DateTime();
		$today = $today->format('U');
		foreach ($allDays As $day) {
			$deadline = $day->deadline;
			if($deadline->format('U') > $today) {
				$days[$day->getUid()] = $day;
			}
		}
		return $days;
	}
	private function getAllPickupDays() {
		$days = array();
		$lines = \tx_rnbase_util_Strings::trimExplode("\n", $this->record['pickupdates']);
		foreach ($lines As $idx => $line) {
			if(trim($line) == '') continue;
			$dateArr = \tx_rnbase_util_Strings::trimExplode("|", $line);
			$date1 = $dateArr[0];
			$date2 = isset($dateArr[1]) ? $dateArr[1] : $date1;
			$date1 = new \DateTime($date1);
			$date2 = new \DateTime($date2);
			$model = \tx_rnbase::makeInstance('tx_rnbase_model_base', array(
					'uid' => ++$idx,
					'day' => $date1->format('U'),
					'deadline' => $date2->format('U'),
			));
			$model->day = $date1;
			$model->deadline = $date2;
			$days[] = $model;
		}
		return $days;
	}

}
