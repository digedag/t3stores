<?php
tx_rnbase::load('tx_rnbase_util_TSFAL');

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion',
		'label' => 'name',
		'searchFields' => 'uid,name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
// 		'sortby' => 'sorting',
 		'default_sortby' => 'ORDER BY startdate desc',
		'delete' => 'deleted',
		'dividers2tabs' => TRUE,
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'iconfile' => tx_rnbase_util_Extensions::extRelPath('t3stores') . 'Resources/Public/Icon/icon_stores.png',
//		'shadowColumnsForNewPlaceholders' => 'scope,title',
	),
	'interface' => array(
			'showRecordFieldList' => 'hidden,name',
			'maxDBListItems' => 10,
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
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion_name',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
			)
		),
		'discount' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion_discount',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'eval' => 'int',
			)
		),
		'pickupdates' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion_pickupdates',
				'config' => Array (
						'type' => 'text',
						'cols' => '40',
						'rows' => '6',
				)
		),
		'startdate' => Array (
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion_startdate',
			'config' => Array (
				'type' => 'input',
				'size' => '13',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
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

		'stores' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_promotion_stores',
			'config' => Array (
				'type' => 'select',
				'size' => 15,
				'autoSizeMax' => 50,
				'minitems' => 0,
				'maxitems' => 100,
				'foreign_table' => 'tx_t3stores_store',
				'foreign_table_where' => 'ORDER BY city',
				'MM' => 'tx_t3stores_stores_mm',
				'MM_foreign_select' => 1,
				'MM_opposite_field' => 'items',
				'MM_match_fields' => Array (
					'tablenames' => 'tx_t3stores_promotion',
				),
				'wizards' => Array(
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'edit2.gif',
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
				)
			),
		),

	),
	'types' => array(
			'0' => array('showitem' => 'hidden;;1;;1-1-1,name, discount, pickupdates, startdate, stores,--div--;LLL:EXT:cms/locallang_tca.xlf:fe_users.tabs.access, starttime, endtime')
	)
);
