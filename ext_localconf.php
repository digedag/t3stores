<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

tx_rnbase::load('tx_rnbase_util_SearchBase');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'System25\T3stores\Hook\TceHook';

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\Product' /* sv key */,
	array(
		'title' => 'Store', 'description' => 'Handles products', 'subtype' => 'product',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\Product',
	)
);

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\Store' /* sv key */,
	array(
		'title' => 'Store', 'description' => 'Handles stores', 'subtype' => 'store',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\Store',
	)
);


tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\Offer' /* sv key */,
	array(
		'title' => 'Offer', 'description' => 'Handles offers', 'subtype' => 'offer',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\Offer',
	)
);

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\Order' /* sv key */,
	array(
		'title' => 'Order', 'description' => 'Handles orders', 'subtype' => 'order',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\Order',
	)
);
