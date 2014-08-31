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
	'config' => array(
		'type' => 'user',
		'userFunc' => 'FluidTYPO3\MooxCore\UserFunction\ProviderField->createVariantsField',
	)
);
$GLOBALS['TCA']['tt_content']['columns']['content_version'] = array(
	'label' => 'LLL:EXT:moox_core/Resources/Private/Language/locallang.xlf:tt_content.content_version',
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
	$GLOBALS['TCA']['tt_content']['palettes']['imageblock'],
	$GLOBALS['TCA']['tt_content']['palettes']['table'],
	$GLOBALS['TCA']['tt_content']['columns']['table_bgColor'],
	$GLOBALS['TCA']['tt_content']['columns']['table_border'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellspacing'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellpadding']
);

\FluidTYPO3\Flux\Core::registerProviderExtensionKey('FluidTYPO3.MooxCore', 'Page');
\FluidTYPO3\Flux\Core::registerProviderExtensionKey('FluidTYPO3.MooxCore', 'Content');
