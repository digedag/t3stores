<?php
tx_rnbase::load('tx_rnbase_util_TSFAL');

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xlf:tx_t3stores_store',
		'label' => 'title',
//		'label_userFunc' => 'EXT:templavoila/Classes/Service/UserFunc/Label.php:&Extension\Templavoila\Service\UserFunc\Label->getLabel',
		'searchFields' => 'uid,name,address,city,zip,contactperson',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY name',
		'delete' => 'deleted',
		'dividers2tabs' => TRUE,
		'enablecolumns' => array (
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
				'hidden' => array (
						'exclude' => 1,
						'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
						'config'  => array (
								'type'    => 'check',
								'default' => '0'
						)
				),
				'name' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_name',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'address' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_address',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'zip' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_zip',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'city' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_city',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'countrycode' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_countrycode',
					'config' => Array (
						'type' => 'input',
						'size' => '10',
						'max' => '20',
						'eval' => 'trim',
					)
				),
				'lng' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_lng',
					'config' => Array (
						'type' => 'input',
						'size' => '20',
						'max' => '50',
						'eval' => 'trim',
					)
				),
				'lat' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_lat',
					'config' => Array (
						'type' => 'input',
						'size' => '20',
						'max' => '50',
						'eval' => 'trim',
					)
				),
				'phone' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_phone',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'contactperson' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_contactperson',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'hasreport' => array (
						'exclude' => 1,
						'label'   => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_hasreport',
						'config'  => array (
								'type'    => 'check',
								'default' => '0'
						)
				),
				'openingtime' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_openingtime',
						'config' => Array (
								'type' => 'text',
								'cols' => '30',
								'rows' => '5',
						)
				),
				'description' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_stores_description',
						'config' => Array (
								'type' => 'text',
								'cols' => '30',
								'rows' => '5',
						)
				),
				'pictures' => tx_rnbase_util_TSFAL::getMediaTCA('pictures'),
	),
	'types' => array(
			'0' => array('showitem' => 'hidden;;1;;1-1-1,name,description;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/rte/],hasreport,pictures,
			--div--;LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_tabcontact,contactperson,phone,address,zip,city,countrycode,lng,lat,openingtime;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/rte/]
			')
	)
);
				