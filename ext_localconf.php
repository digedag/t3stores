<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

tx_rnbase::load('tx_rnbase_util_SearchBase');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'System25\T3stores\Hook\TceHook';

t3lib_extMgm::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\Store' /* sv key */,
	array(
		'title' => 'Store', 'description' => 'Handles stores', 'subtype' => 'store',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
//		'classFile' => t3lib_extMgm::extPath($_EXTKEY).'sv1/class.tx_t3sponsors_sv1_Sponsor.php',
		'className' => 'System25\T3stores\Service\Store',
	)
);
