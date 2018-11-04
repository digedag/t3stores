<?php
namespace System25\T3stores\Hook;

/***************************************************************
*  Copyright notice
*
*  (c) 2015 Rene Nitzsche <rene@system25.de>
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


class TceHook {

	/**
	 * Dieser Hook wird vor der Darstellung eines TCE-Formulars aufgerufen.
	 * Werte aus der Datenbank können vor deren Darstellung manipuliert werden.
	 */
// 	public function getMainFields_preProcess($table, &$row, $tceform) {
// 	}
	/**
	 * Wir müssen dafür sorgen, daß die neuen IDs der Teams im Wettbewerb und Spielen
	 * verwendet werden.
	 */
// 	public function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, &$tcemain)  {
// 	}

	/**
	 * Nachbearbeitungen, unmittelbar BEVOR die Daten gespeichert werden. Das POST bezieht sich
	 * auf die Arbeit der TCE und nicht auf die Speicherung in der DB.
	 *
	 * @param string $status new oder update
	 * @param string $table Name der Tabelle
	 * @param int $id UID des Datensatzes
	 * @param array $fieldArray Felder des Datensatzes, die sich ändern
	 * @param tce_main $tcemain
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$tce) {
		if($table == 'tx_t3stores_store') {
			$addressFields = array('address', 'zip', 'city', 'countrycode');
			$address = array();
			$changed = FALSE;
			foreach ($addressFields AS $field){
				if(array_key_exists($field, $fieldArray)) {
					$address[$field] = $fieldArray[$field];
					$changed = TRUE;
				}
			}
			if($changed) {
				// Adresse auffüllen
				if(count($address) < 4) {
					// Record laden
					$row = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($table, $id);
					if($row) {
						foreach ($addressFields As $field) {
							if(!array_key_exists($field, $address)) {
								$address[$field] = $row[$field];
							}
						}
					}
				}
				$address = implode(',', $address);

				$geoCoder = \tx_rnbase::makeInstance('tx_rnbase_maps_google_Util');
				try {
				    $geo = $geoCoder->lookupGeoCode($address);
				}
				catch (\Exception $e) {
				    \tx_rnbase::load('tx_rnbase_util_Logger');
				    \tx_rnbase_util_Logger::warn('Error on Google address lookup ', 't3stores', array('address' => $address, 'exception' => $e->getMessage()));
				}
				$fieldArray['lat'] = $geo['lat'];
				$fieldArray['lng'] = $geo['lng'];
			}
		}
	}
}
