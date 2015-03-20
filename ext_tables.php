<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MOOX Core');
if ('BE' === TYPO3_MODE) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'constants', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:moox_core/Configuration/TypoScript/constants.txt">');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:moox_core/Configuration/TypoScript/setup.txt">');
}

\FluidTYPO3\Flux\Core::registerConfigurationProvider('DCNGmbH\MooxCore\Provider\CoreContentProvider');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['moox_core']['setup'] = unserialize($_EXTCONF);

if (FALSE === (boolean) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['moox_core']['setup']['disablePageTemplates']) {
	\FluidTYPO3\Flux\Core::registerProviderExtensionKey('DCNGmbH.MooxCore', 'Page');
}
if (FALSE === (boolean) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['moox_core']['setup']['disableContentTemplates']) {
	\FluidTYPO3\Flux\Core::registerProviderExtensionKey('DCNGmbH.MooxCore', 'Content');
}


// Add fields for individual id / class for content elements
$tempColumns = Array (
	'tx_mooxcore_hide_desktop' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_desktop',		
		'config' => Array (
			'type' => 'check',
		)
	),
	'tx_mooxcore_hide_laptop' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_laptop',		
		'config' => Array (
			'type' => 'check',
		)
	),
	'tx_mooxcore_hide_tablet' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_tablet',		
		'config' => Array (
			'type' => 'check',
		)
	),
	'tx_mooxcore_hide_phone' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_phone',		
		'config' => Array (
			'type' => 'check',
		)
	),
	'tx_mooxcore_hide_print' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_print',		
		'config' => Array (
			'type' => 'check',
		)
	),
	'tx_mooxcore_hide_barrierfree' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_barrierfree',		
		'config' => Array (
			'type' => 'check',
		)
	),
	'tx_mooxcore_hide_oldbrowser' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_hide_oldbrowser',		
		'config' => Array (
			'type' => 'check',
		)
	),
);
//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);

// create palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', ',--div--;LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_extended_visibility,tx_mooxcore_hide_desktop,tx_mooxcore_hide_laptop,tx_mooxcore_hide_tablet,tx_mooxcore_hide_phone,tx_mooxcore_hide_print,tx_mooxcore_hide_barrierfree,tx_mooxcore_hide_oldbrowser', '', '');

/* ===========================================================================
 	Register BE-Module for Administration
=========================================================================== */

if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	
    /***************
     * Register Main Module
     */
	$mainModuleName = "moox";
	if (!isset($TBE_MODULES[$mainModuleName])) {
        $temp_TBE_MODULES = array();
        foreach ($TBE_MODULES as $key => $val) {
            if ($key == 'web') {
                $temp_TBE_MODULES[$key] = $val;
                $temp_TBE_MODULES[$mainModuleName] = '';
            } else {
                $temp_TBE_MODULES[$key] = $val;
            }
        }
        $TBE_MODULES = $temp_TBE_MODULES;		
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
			'DCNGmbH.'.$_EXTKEY,
			$mainModuleName,
			'',
			'',
			array(),
			array(
				'access' => 'user,group',
				'icon'   => 'EXT:'.$_EXTKEY.'/ext_icon32.png',
				'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/MainModule.xlf',
			)
		);
    }	
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'DCNGmbH.'.$_EXTKEY,
        $mainModuleName,
        'dashboard',
        'top',
        array(
			'Administration' => 'dashboard',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/ext_icon32.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/DashboardModule.xlf',
		)
    );	
}

/***************
 * Backend Styling
 */
if (TYPO3_MODE == 'BE') {
    $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
    if(!isset($settings['Logo'])){
        $settings['Logo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Backend/typo3-topbar@2x.png';
    }
    if(!isset($settings['LoginLogo'])){
        $settings['LoginLogo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Backend/typo3logo-white-greyback.gif';
    }
    $GLOBALS['TBE_STYLES']['logo'] = $settings['Logo'];
    $GLOBALS['TBE_STYLES']['logo_login'] = $settings['LoginLogo'];
    $GLOBALS['TBE_STYLES']['htmlTemplates']['EXT:backend/Resources/Private/Templates/login.html'] = 'EXT:moox_core/Resources/Private/Templates/Backend/Login.html';
    unset($settings);
}