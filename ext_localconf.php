<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

tx_rnbase::load('tx_rnbase_util_SearchBase');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'System25\T3stores\Hook\TceHook';

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\PromotionSrv' /* sv key */,
	array(
		'title' => 'Promotion', 'description' => 'Handles promotion', 'subtype' => 'promotion',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\PromotionSrv',
	)
);

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\ProductSrv' /* sv key */,
	array(
		'title' => 'Product', 'description' => 'Handles products', 'subtype' => 'product',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\ProductSrv',
	)
);

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\JobSrv' /* sv key */,
	array(
		'title' => 'Job', 'description' => 'Handles jobs', 'subtype' => 'job',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\JobSrv',
	)
);

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\StoreSrv' /* sv key */,
	array(
		'title' => 'Store', 'description' => 'Handles stores', 'subtype' => 'store',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\StoreSrv',
	)
);


tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\OfferSrv' /* sv key */,
	array(
		'title' => 'Offer', 'description' => 'Handles offers', 'subtype' => 'offer',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\OfferSrv',
	)
);

tx_rnbase_util_Extensions::addService($_EXTKEY,  't3stores' /* sv type */,  'System25\T3stores\Service\OrderSrv' /* sv key */,
	array(
		'title' => 'Order', 'description' => 'Handles orders', 'subtype' => 'order',
		'available' => TRUE, 'priority' => 50, 'quality' => 50,
		'os' => '', 'exec' => '',
		'className' => 'System25\T3stores\Service\OrderSrv',
	)
);
