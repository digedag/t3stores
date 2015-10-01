<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

tx_rnbase::load('tx_rnbase_util_TYPO3');
tx_rnbase::load('tx_rnbase_util_Extensions');

////////////////////////////////
// Register plugin
////////////////////////////////
// Hide some fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_t3stores']='layout,select_key,pages';

// Show tt_content-field pi_flexform
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_t3stores']='pi_flexform';

// Add flexform and plugin
tx_rnbase_util_Extensions::addPiFlexFormValue('tx_t3stores','FILE:EXT:'.$_EXTKEY.'/Configuration/Flexform/flexform_main.xml');
tx_rnbase_util_Extensions::addPlugin(Array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_db.php:plugin.t3stores.label','tx_t3stores'));

// Add static TS-config
tx_rnbase_util_Extensions::addStaticFile($_EXTKEY,'Configuration/Typoscript/Base/', 'T3 Stores');
