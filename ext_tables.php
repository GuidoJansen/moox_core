<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['label'] = NULL;
$GLOBALS['TCA']['tt_content']['columns']['content_options'] = array(
	'label' => NULL,
	'config' => array(
		'type' => 'flex'
	)
);
$GLOBALS['TCA']['tt_content']['columns']['content_variant'] = array(
	'label' => 'LLL:EXT:moox_core/Resources/Private/Language/locallang.xlf:tt_content.content_variant',
	'exclude' => 1,
	'config' => array(
		'type' => 'user',
		'userFunc' => 'FluidTYPO3\MooxCore\UserFunction\ProviderField->createVariantsField',
	)
);
$GLOBALS['TCA']['tt_content']['columns']['content_version'] = array(
	'label' => 'LLL:EXT:moox_core/Resources/Private/Language/locallang.xlf:tt_content.content_version',
	'exclude' => 1,
	'config' => array(
		'type' => 'user',
		'userFunc' => 'FluidTYPO3\MooxCore\UserFunction\ProviderField->createVersionsField',
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MOOX Core');
if ('BE' === TYPO3_MODE) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'constants', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:moox_core/Configuration/TypoScript/constants.txt">');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:moox_core/Configuration/TypoScript/setup.txt">');
}

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\MooxCore\Provider\ContentProvider');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'general', 'content_variant, content_version', 'after:CType');

$GLOBALS['TCA']['tt_content']['palettes']['frames']['showitem'] = 'content_options';
$GLOBALS['TCA']['tt_content']['palettes']['header']['showitem'] = 'header';
$GLOBALS['TCA']['tt_content']['palettes']['headers']['showitem'] = 'header';
$GLOBALS['TCA']['tt_content']['columns']['header']['label'] = NULL;
$GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] .= ',content_variant,content_version';

/* Media tab disabled */ 
$GLOBALS['TCA']['tt_content']['types']['media']['showitem'] = '--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.behaviour,bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext.ALT.media_formlabel;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories, ,--div--;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tabs.relation, tx_flux_parent, tx_flux_column, tx_flux_children;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tx_flux_children, , --div--;LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_extended_visibility, tx_mooxcore_hide_desktop, tx_mooxcore_hide_laptop, tx_mooxcore_hide_tablet, tx_mooxcore_hide_phone, tx_mooxcore_hide_print, tx_mooxcore_hide_barrierfree, tx_mooxcore_hide_oldbrowser';

unset(
	$GLOBALS['TCA']['tt_content']['types']['swfobject'],
	$GLOBALS['TCA']['tt_content']['types']['qtobject'],
	$GLOBALS['TCA']['tt_content']['types']['multimedia'],
	$GLOBALS['TCA']['tt_content']['columns']['text_properties'],
	$GLOBALS['TCA']['tt_content']['columns']['text_align'],
	$GLOBALS['TCA']['tt_content']['columns']['text_color'],
	$GLOBALS['TCA']['tt_content']['columns']['text_face'],
	$GLOBALS['TCA']['tt_content']['columns']['text_size'],
	$GLOBALS['TCA']['tt_content']['columns']['image_compression'],
	$GLOBALS['TCA']['tt_content']['columns']['image_effects'],
	$GLOBALS['TCA']['tt_content']['columns']['image_frames'],
	$GLOBALS['TCA']['tt_content']['columns']['imageborder'],
	$GLOBALS['TCA']['tt_content']['columns']['linkToTop'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_title'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_bypass'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_bypass_text'],
	$GLOBALS['TCA']['tt_content']['palettes']['imageblock'],
	$GLOBALS['TCA']['tt_content']['palettes']['table'],
	$GLOBALS['TCA']['tt_content']['columns']['table_bgColor'],
	$GLOBALS['TCA']['tt_content']['columns']['table_border'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellspacing'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellpadding']
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['moox_core']['setup'] = unserialize($_EXTCONF);

if (FALSE === (boolean) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['moox_core']['setup']['disablePageTemplates']) {
	\FluidTYPO3\Flux\Core::registerProviderExtensionKey('FluidTYPO3.MooxCore', 'Page');
}
if (FALSE === (boolean) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['moox_core']['setup']['disableContentTemplates']) {
	\FluidTYPO3\Flux\Core::registerProviderExtensionKey('FluidTYPO3.MooxCore', 'Content');
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
\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);

// create palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', ',--div--;LLL:EXT:moox_core/locallang_db.xml:tt_content.tx_mooxcore_extended_visibility,tx_mooxcore_hide_desktop,tx_mooxcore_hide_laptop,tx_mooxcore_hide_tablet,tx_mooxcore_hide_phone,tx_mooxcore_hide_print,tx_mooxcore_hide_barrierfree,tx_mooxcore_hide_oldbrowser', '', '');

/* ===========================================================================
 	Register BE-Module for Administration
=========================================================================== */

if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	
    $mainModuleName = 'moox';

    /***************
     * Register Main Module
     */
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
    }
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $_EXTKEY,
        $mainModuleName,
        '',
        '',
        array()
    );
    $TBE_MODULES['_configuration'][$mainModuleName]['access'] = 'user,group';
    $TBE_MODULES['_configuration'][$mainModuleName]['icon'] = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/moox_core_module.gif';
    $TBE_MODULES['_configuration'][$mainModuleName]['labels'] = 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/MainModule.xlf';
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'FluidTYPO3.MooxCore',
        $mainModuleName,
        'dashboard',
        'top',
        array(
		'Administration' => 'dashboard',
	),
	array(
        'access' => 'user,group',
        'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
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
        $settings['Logo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Backend/TopBarLogo@2x.png';
    }
    if(!isset($settings['LoginLogo'])){
        $settings['LoginLogo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Backend/LoginLogo.png';
    }
    $GLOBALS['TBE_STYLES']['logo'] = $settings['Logo'];
    $GLOBALS['TBE_STYLES']['logo_login'] = $settings['LoginLogo'];
    $GLOBALS['TBE_STYLES']['htmlTemplates']['EXT:backend/Resources/Private/Templates/login.html'] = 'EXT:moox_core/Resources/Private/Templates/Backend/Login.html';
    unset($settings);
}