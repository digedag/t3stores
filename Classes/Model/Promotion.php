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

\tx_rnbase::load('Tx_Rnbase_Domain_Model_Base');
\tx_rnbase::load('Tx_Rnbase_Utility_Strings');
\tx_rnbase::load('tx_rnbase_util_Spyc');


class Promotion extends \Tx_Rnbase_Domain_Model_Base {

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
	public function isPickupDayModeDynamic() {
		if(!$this->hasProperty('pickupdatesdynamic')) {
			$this->setProperty('pickupdatesdynamic',
				\Tx_Rnbase_Utility_Strings::isFirstPartOfStr($this->getProperty('pickupdates'), '---'));
		}
		return $this->getProperty('pickupdatesdynamic');
	}
	private function getAllPickupDays() {
		$days = array();
		if($this->isPickupDayModeDynamic()) {
			return $this->evaluateDynamicDates($this->getProperty('pickupdates'));
		}
		$lines = \Tx_Rnbase_Utility_Strings::trimExplode("\n", $this->getProperty('pickupdates'));
		foreach ($lines As $idx => $line) {
			if(trim($line) == '') continue;
			$dateArr = \Tx_Rnbase_Utility_Strings::trimExplode("|", $line);
			$date1 = $dateArr[0];
			$date2 = isset($dateArr[1]) ? $dateArr[1] : $date1;
			$pickupDay = new \DateTime($date1);
			$deadline = new \DateTime($date2);
			$model = \tx_rnbase::makeInstance('Tx_Rnbase_Domain_Model_Data', array(
					'uid' => ++$idx,
					'day' => $pickupDay->format('U'),
					'deadline' => $deadline->format('U'),
			));
			$model->day = $pickupDay;
			$model->deadline = $deadline;
			$days[] = $model;
		}
		return $days;
	}
	private function findFirstDay($data) {
		$now = new \DateTime();
		// Gibt es eine Anweisung für diesen Tag
		$dayname = strtolower($now->format('l'));
		$skipDays = 0;
		if(isset($data['startdate'][$dayname]['time'])) {
			$borderTime = $data['startdate'][$dayname]['time'];
			$skipDays = isset($data['startdate'][$dayname]['skipdays']) ?
				$data['startdate'][$dayname]['skipdays'] : $skipDays;
		}
		else {
			$borderTime = isset($data['startdate']['today']['time']) ?
				$data['startdate']['today']['time'] : '';
		}
		$skipDays = $skipDays + 1;
		$borderTime = new \DateTime($borderTime);
		// Alle Datumsangaben für die Auswahl auf 12:00 Uhr setzen
		$startDate = new \DateTime('12:00');
		if($borderTime < $now) {
			$startDate = new \DateTime('+'.$skipDays.' day 12:00');
		}
		return $startDate;
	}

	private function evaluateDynamicDates($datesYml) {
    	$spyc = new \tx_rnbase_util_Spyc();
		$data = $spyc->load($datesYml);
		$endDate = new \DateTime($data['enddate'].' 12:00');
		// nur der erste Tag hat eine echte Deadline
		$startDate = $this->findFirstDay($data);

		$interval = \DateInterval::createFromDateString('1 day');
		$period = new \DatePeriod($startDate, $interval, $endDate);
		$days = array();
		foreach ( $period as $pickupDay ) {
			// erstmal alle erlauben
			$deadline = new \DateTime('+1 day');
//			echo $dt->format( "l Y-m-d H:i:s\n" );
			if(isset($data['special'][$pickupDay->format('d.m.Y')])) {
				$deadline = new \DateTime($data['special'][$pickupDay->format('d.m.Y')]);
			}
			$model = \tx_rnbase::makeInstance('Tx_Rnbase_Domain_Model_Data', array(
					'uid' => $pickupDay->format('U'),
					'day' => $pickupDay->format('U'),
					'deadline' => $deadline->format('U'),
			));
			$model->day = $pickupDay;
			$model->deadline = $deadline;
			$days[] = $model;
		}

		return $days;
	}
}
