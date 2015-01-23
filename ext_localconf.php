<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Use dashboard instead of the default page module
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
// 	setup.override.startModule = moox_MooxCoreDashboard
//	mod.moox_MooxCoreDashboard.sideBarEnable = 0
// ');

if (FALSE === isset($GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'])) {
	\TYPO3\CMS\Core\Utility\GeneralUtility::sysLog('MooxCore requires an additional configuration file in typo3conf/AdditionalConfiguration.php - '
		. 'you can have MooxCore generate this file for you from the extension manager by running the MooxCore update script. A dummy '
		. 'has been created, but you will only be able to render content (not plugins!) until the file is created',
		'moox_core',
		\TYPO3\CMS\Core\Utility\GeneralUtility::SYSLOG_SEVERITY_WARNING
	);
	$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
		'mooxcore/Configuration/TypoScript/',
	);
}

$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['types'] = array(
	'header', 'text', 'image', 'textpic', 'bullets', 'uploads', 'table', 'media', 'mailform', 'search', 'menu', 'shortcut', 'div', 'html', 'default'
);

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\MooxCore\Provider\CoreContentProvider');

// Prepare a global variants registration array indexed by CType value.
// To add your own, do fx: $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['variants']['textpic'][] = 'myextensionkey';
$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['variants'] = array_combine(
	array_values($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['types']),
	array_fill(0, count($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['types']), array())
);

for ($i = 0; $i < count($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['types']); $i++) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FluidTYPO3.MooxCore',
		ucfirst($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['types'][$i]),
		array('CoreContent' => 'render,error'),
		array());
}

/***************
 * Use moox_cote PAGE & USER TSconfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/TypoScript/pageTSconfig.txt">');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/TypoScript/userTSconfig.txt">');

/***************
 * Use RealUrl Config from MOOX Core
 */
$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if($settings['UseRealUrlConfig'] == 1){
    @include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY,'Configuration/RealURL/Default.php'));    
}

if (TYPO3_MODE === 'BE') {

    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
    /**
     * Provides an example .htaccess file for Apache after extension is installed and shows a warning if TYPO3 is not running on Apache.
     */
    $signalSlotDispatcher->connect(
        'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
        'hasInstalledExtensions',
        'FluidTYPO3\\MooxCore\\Service\\InstallService',
        'generateApacheHtaccess'
    );
    /**
     * Provides an example AdditionalConfiguration.php file after extension is installed and shows a warning if TYPO3 is not running with moox_core additional configuration.
     */
    $signalSlotDispatcher->connect(
        'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
        'hasInstalledExtensions',
        'FluidTYPO3\\MooxCore\\Service\\InstallService',
        'createDefaultAdditionalConfiguration'
    );
    /**
     * Provides an example robots.txt file after extension is installed and shows a warning if TYPO3 is not running with moox_core robots.txt.
     */
    $signalSlotDispatcher->connect(
        'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
        'hasInstalledExtensions',
        'FluidTYPO3\\MooxCore\\Service\\InstallService',
        'createDefaultRobots'
    );
}

/***************
 * Backend Styling
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\View\\LogoView']['className'] = 'FluidTYPO3\\MooxCore\\Xclass\\Backend\\View\\LogoView';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['renderPreProcess'][] = 'FluidTYPO3\\MooxCore\\Hooks\\Backend\\RenderPreProcess->addStyles';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/template.php']['preHeaderRenderHook'][] = 'FluidTYPO3\\MooxCore\\Hooks\\Backend\\PreHeaderRender->addStyles';

/***************
 * Register hook for processing less files
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = 'FluidTYPO3\\MooxCore\\Hooks\\PageRendererRender\\PreProcessHook->execute';
