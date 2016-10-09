<?php
tx_rnbase::load('tx_rnbase_util_TSFAL');

return array(
	'ctrl' => array(
		'title' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_product',
		'label' => 'name',
		'searchFields' => 'uid,name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
// 		'sortby' => 'sorting',
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
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_product_name',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'shortname' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_product_shortname',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'trim',
				)
		),
		'description' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_product_description',
			'config' => Array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
		'weight' => Array (
				'exclude' => 1,
				'label' => 'LLL:EXT:t3stores/Resources/Private/Language/locallang_db.xml:tx_t3stores_product_weight',
				'config' => Array (
						'type' => 'input',
						'size' => '30',
						'eval' => 'int',
				)
		),
		'categories' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_category.categories',
			'config' => Array (
				'type' => 'select',
				'size' => 10,
				'autoSizeMax' => 50,
				'foreign_table' => 'sys_category',
				'foreign_table_where' => 'AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.sorting ASC',
				'MM' => 'sys_category_record_mm',
				'MM_match_fields' => Array(
						'fieldname' => 'categories',
						'tablenames' => 'tx_t3stores_product',
				),
				'MM_opposite_field' => 'items',
				'renderMode' => 'tree',
				'treeConfig' => Array(
						'appearance' => Array(
								'expandAll' => 0,
								'maxLevels' => 99,
								'showHeader' => 1,
						),
						'parentField' => 'parent',
				),
				'minitems' => 0,
				'maxitems' => 999,
			)
		),
		'images' => tx_rnbase_util_TSFAL::getMediaTCA('images', array()),
	),
	'types' => array(
			'0' => array('showitem' => 'hidden;;1;;1-1-1,name,shortname,weight,description;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_cfcleague/rte/], categories, images')
	)
);
