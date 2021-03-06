<?php

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order',
		'label' => 'customername',
		'searchFields' => 'uid,customername,customeraddress,customerzip,customercity,customerphone,customeremail',
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
			'showRecordFieldList' => 'hidden,title',
			'maxDBListItems' => 5,
	),
	'columns' => array(
		'promotion' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_t3stores_promotion',
				'foreign_table_where' => 'ORDER BY tx_t3stores_promotion.name',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'customername' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customername',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'customeraddress' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customeraddress',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'customerzip' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customerzip',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'customercity' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customercity',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'customerphone' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customerphone',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'customeremail' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customeremail',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'customernote' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_customernote',
				'config' => Array (
					'type' => 'text',
					'cols' => '40',
					'rows' => '15',
					'eval' => 'trim',
				)
		),
		'positionprice' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_positionprice',
				'config' => Array (
						'type' => 'input',
						'size' => '8',
						'eval' => 'int',
				)
		),
		'totalprice' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_totalprice',
				'config' => Array (
						'type' => 'input',
						'size' => '8',
						'eval' => 'int',
				)
		),
		'pickup' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_pickup',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'store' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_store',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array(' ', '0'),
				),
				'foreign_table' => 'tx_t3stores_store',
				'foreign_table_where' => 'ORDER BY tx_t3stores_store.city',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'mailtext' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_mailtext',
			'config' => Array (
				'type' => 'text',
				'cols' => '40',
				'rows' => '15',
				'eval' => 'trim',
			)
		),
		'positions' => Array(
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_positions',
				'config' => Array(
						'type' => 'inline',
						'foreign_table' => 'tx_t3stores_orderposition',
						'foreign_field' => 'orderuid',
						'foreign_sortby' => 'uid',
						'maxitems' => 100,
						'appearance' => Array(
								'collapseAll' => 1,
								'expandSingle' => 1,
						),
				),
		),
	),
	'types' => array(
			'0' => array('showitem' => 'promotion,customername,customeraddress,customerzip,customerzip,customercity,customerphone,
			customeremail,store,pickup,positionprice,totalprice,customernote,mailtext,
			--div--;LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_order_tabpositions,positions')
	)
);
