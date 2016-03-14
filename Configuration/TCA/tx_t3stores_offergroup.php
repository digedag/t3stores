<?php
tx_rnbase::load('tx_rnbase_util_TSFAL');

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offergroup',
		'label' => 'name',
		'searchFields' => 'uid,name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
 		'sortby' => 'sorting',
// 		'default_sortby' => 'ORDER BY name',
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
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offergroup_name',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'promotion' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_t3stores_promotion',
				'foreign_table_where' => 'ORDER BY tx_t3stores_promotion.name',
				'size' => 1,
				'items' => Array(
					Array('',0),
				),
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'description' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offergroup_description',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'offers' => Array(
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offergroup_offers',
				'config' => Array(
						'type' => 'inline',
						'foreign_table' => 'tx_t3stores_offer',
						'foreign_field' => 'offergroup',
						'foreign_sortby' => 'sorting',
						'maxitems' => 100,
						'appearance' => Array(
								'collapseAll' => 1,
								'expandSingle' => 1,
						),
				),
		),
	),
	'types' => array(
			'0' => array('showitem' => 'hidden;;1;;1-1-1,name,promotion,description,
			--div--;LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_offergroup_taboffers,offers
			')
	)
);
