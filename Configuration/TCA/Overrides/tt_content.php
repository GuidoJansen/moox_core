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
	$GLOBALS['TCA']['tt_content']['types']['mailform'],
	$GLOBALS['TCA']['tt_content']['types']['search'],
	$GLOBALS['TCA']['tt_content']['columns']['text_properties'],
	$GLOBALS['TCA']['tt_content']['columns']['text_align'],
	$GLOBALS['TCA']['tt_content']['columns']['text_color'],
	$GLOBALS['TCA']['tt_content']['columns']['text_face'],
	$GLOBALS['TCA']['tt_content']['columns']['text_size'],
	$GLOBALS['TCA']['tt_content']['columns']['image_compression'],
	$GLOBALS['TCA']['tt_content']['columns']['image_effects'],
	$GLOBALS['TCA']['tt_content']['columns']['image_frames'],
	$GLOBALS['TCA']['tt_content']['columns']['image_zoom'],
	$GLOBALS['TCA']['tt_content']['columns']['imageborder'],
	$GLOBALS['TCA']['tt_content']['columns']['linkToTop'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_title'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_bypass'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_bypass_text'],
	$GLOBALS['TCA']['tt_content']['columns']['table_bgColor'],
	$GLOBALS['TCA']['tt_content']['columns']['table_border'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellspacing'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellpadding'],
	$GLOBALS['TCA']['tt_content']['columns']['category_field'],
	$GLOBALS['TCA']['tt_content']['palettes']['imageblock'],
	$GLOBALS['TCA']['tt_content']['palettes']['imagelinks'],
	$GLOBALS['TCA']['tt_content']['palettes']['image_accessibility'],
	//$GLOBALS['TCA']['tt_content']['palettes']['image_settings'],
	$GLOBALS['TCA']['tt_content']['palettes']['table']
);