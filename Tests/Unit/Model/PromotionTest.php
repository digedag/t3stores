<?php
namespace System25\T3stores\Tests\Unit\Model;

use System25\T3stores\Model\Promotion;
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


/**
 *
 */
class PromotionTest extends \Tx_Phpunit_TestCase {

	/**
	 * @group unit
	 */
	public function testPickupDays() {
		if (!\tx_rnbase_util_TYPO3::isTYPO60OrHigher()) {
			$this->markTestSkipped('Runs only in TYPO3 6.0 and higher');
		}

		$record = array(
				'uid'=>3,
				'name'=>'Promotion',
				'discount'=>0.0,
				'pickupdates' => '30.03.2015 | 26.03.2015 23:59
31.03.2015 | 27.03.2015 23:59
01.04.2015 | 30.03.2015 23:59
'
		);

		$model = new Promotion($record);
		$today = new \DateTime('25.03.2015');
		$this->assertEquals(
			3, count($model->getPickupDays($today)),
			'Wrong number of pickup dates'
		);

		$today = new \DateTime('27.03.2015 18:00');
		$this->assertEquals(
				2, count($model->getPickupDays($today)),
				'Wrong number of pickup dates'
		);

		$today = new \DateTime('30.03.2015 18:00');
		$this->assertEquals(
				1, count($model->getPickupDays($today)),
				'Wrong number of pickup dates'
		);

		$today = new \DateTime('31.03.2015 00:00');
		$this->assertEquals(
				0, count($model->getPickupDays($today)),
				'Wrong number of pickup dates'
		);

	}
}