<?php
tx_rnbase::load('tx_rnbase_util_TSFAL');

$wecmap = array();
$wecmap['wec_map']['isMappable'] = 1;
$wecmap['wec_map']['addressFields'] = array(
		'street' => 'address',
		'city' => 'city',
		'zip' => 'zip',
		'country' => 'countrycode',
);

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store',
		'label' => 'name',
		'label_alt' => 'city',
		'label_alt_force' => 1,
//		'label_userFunc' => 'EXT:templavoila/Classes/Service/UserFunc/Label.php:&Extension\Templavoila\Service\UserFunc\Label->getLabel',
		'searchFields' => 'uid,name,address,city,zip,contactperson',
		'tstamp' => 'tstamp',
		'EXT' => $wecmap,
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
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_name',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'address' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_address',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'zip' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_zip',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'city' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_city',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'countrycode' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_countrycode',
					'config' => Array (
						'type' => 'input',
						'size' => '10',
						'max' => '20',
						'eval' => 'trim',
					)
				),
				'lng' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_lng',
					'config' => Array (
						'type' => 'input',
						'size' => '20',
						'max' => '50',
						'eval' => 'trim',
					)
				),
				'lat' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_lat',
					'config' => Array (
						'type' => 'input',
						'size' => '20',
						'max' => '50',
						'eval' => 'trim',
					)
				),
				'phone' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_phone',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'contactperson' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_contactperson',
						'config' => Array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'hasreport' => array (
						'exclude' => 1,
						'label'   => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_hasreport',
						'config'  => array (
								'type'    => 'check',
								'default' => '0'
						)
				),
				'openingtime' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_openingtime',
						'config' => Array (
								'type' => 'text',
								'cols' => '30',
								'rows' => '5',
						)
				),
				'description' => Array (
						'exclude' => 1,
						'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store_description',
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
				