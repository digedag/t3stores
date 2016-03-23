<?php
tx_rnbase::load('tx_rnbase_util_TSFAL');

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer',
		'label' => 'name',
		'label_alt' => 'product',
		'searchFields' => 'uid,name,hint',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
// 		'sortby' => 'sorting',
// 		'default_sortby' => 'ORDER BY name',
		'type' => 'offertype',
		'delete' => 'deleted',
		'dividers2tabs' => TRUE,
		'enablecolumns' => array (
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'disabled' => 'hidden',
		),
		'iconfile' => tx_rnbase_util_Extensions::extRelPath('t3stores') . 'Resources/Public/Icon/icon_stores.png',
//		'shadowColumnsForNewPlaceholders' => 'scope,title',
	),
	'interface' => array(
			'showRecordFieldList' => 'hidden,name',
			'maxDBListItems' => 60,
	),
	'columns' => array(
		'starttime' => Array (
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
			'config' => Array (
				'type' => 'input',
				'size' => '13',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'endtime' => Array (
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
			'config' => Array (
				'type' => 'input',
				'size' => '13',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0',
				'range' => Array (
					'upper' => mktime(0,0,0,12,31,2030),
					'lower' => mktime(0,0,0,date('m')-1,date('d'),date('Y'))
				)
			)
		),
		'hidden' => array (
				'exclude' => 1,
				'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
				'config'  => array (
						'type'    => 'check',
						'default' => '0'
				)
		),
		'offertype' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_type',
				'config' => Array (
						'type' => 'select',
						'items' => Array(
								Array('LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_type_simple',0),
								Array('LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_type_product',1)
						),
						'size' => 1,
						'minitems' => 0,
						'maxitems' => 1,
				)
		),
		'name' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_name',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'offergroup' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offergroup',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_t3stores_offergroup',
				'foreign_table_where' => 'AND tx_t3stores_offergroup.pid=###CURRENT_PID### ORDER BY tx_t3stores_offergroup.name',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'product' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_product',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_t3stores_product',
				'foreign_table_where' => 'AND tx_t3stores_product.pid=###CURRENT_PID### ORDER BY tx_t3stores_product.name',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
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
		'weight' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_weight',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'int',
				)
		),
		'hint' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_hint',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'teaser' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_teaser',
				'config' => Array (
						'type' => 'text',
						'cols' => '30',
						'rows' => '4',
						'eval' => 'trim',
				)
		),
		'price' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_price',
				'config' => Array (
						'type' => 'input',
						'size' => '8',
						'eval' => 'int',
				)
		),
		'pricelabel' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_pricelabel',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'images' => tx_rnbase_util_TSFAL::getMediaTCA('images', array()),
		'available' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offer_available',
				'config' => Array (
						'type' => 'input',
						'size' => '8',
						'eval' => 'int',
				)
		),
	),
	'types' => array(
			'0' => array('showitem' => 'hidden;;1;;1-1-1,offertype,name,hint,offergroup,teaser,unit,price,pricelabel,weight,available,images,--div--;LLL:EXT:cms/locallang_tca.xlf:fe_users.tabs.access, starttime, endtime,'),
			'1' => array('showitem' => 'hidden;;1;;1-1-1,offertype,offergroup,product,unit,price,pricelabel,weight,available,--div--;LLL:EXT:cms/locallang_tca.xlf:fe_users.tabs.access, starttime, endtime,'),
	)
);
