<?php

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_orderposition',
		'label' => 'title',
		'searchFields' => 'uid,title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
// 		'sortby' => 'sorting',
 		'default_sortby' => 'ORDER BY uid desc',
		'delete' => 'deleted',
		'dividers2tabs' => TRUE,
		'enablecolumns' => array (
		),
		'iconfile' => tx_rnbase_util_Extensions::extRelPath('t3stores') . 'Resources/Public/Icon/icon_stores.png',
//		'shadowColumnsForNewPlaceholders' => 'scope,title',
	),
	'interface' => array(
			'showRecordFieldList' => 'title, price, amount',
			'maxDBListItems' => 5,
	),
	'columns' => array(
		'title' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_orderposition_title',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'price' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_orderposition_price',
				'config' => Array (
						'type' => 'input',
						'size' => '8',
						'eval' => 'int',
				)
		),
		'amount' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_orderposition_amount',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'unit' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_unit',
				'config' => Array (
						'type' => 'select',
						'items' => Array(
								Array('LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_unit_weight',0),
								Array('LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_unit_item',1)
						),
						'size' => 1,
						'minitems' => 0,
						'maxitems' => 1,
				)
		),
		'total' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_orderposition_total',
				'config' => Array (
						'type' => 'input',
						'size' => '8',
						'eval' => 'int',
				)
		),
	),
	'types' => array(
			'0' => array('showitem' => 'title,price,amount,unit,total')
	)
);
