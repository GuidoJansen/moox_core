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
				'icon'   => 'EXT:'.$_EXTKEY.'/Resources/Public/Icons/module-mooxcore-white.svg',
				'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Module.xlf:moox_main_module_tab',
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
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module-mooxcore.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/Module.xlf:moox_dashboard_module_tab',
		)
    );	
}
