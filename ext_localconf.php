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

$GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['types'] = array(
	'header', 'text', 'image', 'textpic', 'bullets', 'uploads', 'table', 'media', 'mailform', 'search', 'menu', 'shortcut', 'div', 'html', 'default'
);

\FluidTYPO3\Flux\Core::registerConfigurationProvider('DCNGmbH\MooxCore\Provider\CoreContentProvider');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']['moox_core'] = 'DCNGmbH\MooxCore\Hooks\WizardItemsHookSubscriber';


// Prepare a global variants registration array indexed by CType value.
// To add your own, do fx: $GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['variants']['textpic'][] = 'myextensionkey';
$GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['variants'] = array_combine(
	array_values($GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['types']),
	array_fill(0, count($GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['types']), array())
);

$types = count($GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['types']);
for ($i = 0; $i < $types; $i++) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'DCNGmbH.MooxCore',
		ucfirst($GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['types'][$i]),
		array('CoreContent' => 'render,error'),
		array());
}
unset($types, $i);

// Include new content elements to modWizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:moox_core/Configuration/PageTS/modWizards.ts">');
// If the form extension is loaded, then include the mailform element to modWizards
if (TRUE === \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:moox_core/Configuration/PageTS/modWizardsMailform.ts">');
}


/***************
 * Use moox_core PAGE & USER TSconfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/PageTS/pageTSconfig.txt">');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/UserTS/userTSconfig.txt">');

/***************
 * Use RealUrl Config from MOOX Core
 */
$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if($settings['UseRealUrlConfig'] == 1){
    @include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY,'Configuration/RealURL/Default.php'));    
}

if (TYPO3_MODE === 'BE') {
	// enable SignalSlot
	/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
    /**
     * Provides an example .htaccess file for Apache after extension is installed and shows a warning if TYPO3 is not running on Apache.
     */
    $signalSlotDispatcher->connect(
        'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
        'hasInstalledExtensions',
        'DCNGmbH\\MooxCore\\Service\\InstallService',
        'generateApacheHtaccess'
    );
	/**
	 * Provides an example robots.txt file after extension is installed and shows a warning if TYPO3 is not running with moox_core robots.txt.
	 */
	$signalSlotDispatcher->connect(
			'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
			'hasInstalledExtensions',
			'DCNGmbH\\MooxCore\\Service\\InstallService',
			'createDefaultRobots'
	);
	/**
	 * Provides an example AdditionalConfiguration.php file after extension is installed and shows a warning if TYPO3 is not running with moox_core additional configuration.
	 */
	$signalSlotDispatcher->connect(
		'TYPO3\CMS\Extensionmanager\Utility\InstallUtility',
		'afterExtensionInstall',
		'DCNGmbH\MooxCore\Hooks\InstallSignalSlot',
		'installAdditionalConfiguration',
		FALSE
	);
}

/***************
 * Register hook for processing less files
 */
if (TYPO3_MODE === 'FE') {
	require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('moox_core') . '/Contrib/less.php/Less.php');

		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = 'DCNGmbH\\MooxCore\\Hooks\\PageRendererRender\\PreProcessHook->execute';
	
}
