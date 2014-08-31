<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

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

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\MooxCore\Provider\ContentProvider');

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
		array('CoreContent' => $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.MooxCore']['types'][$i]),
		array());
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']['moox_core'] = 'FluidTYPO3\MooxCore\Hooks\WizardItemsHookSubscriber';

