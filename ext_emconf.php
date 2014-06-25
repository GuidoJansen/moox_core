<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "fluidcontent_core".
 *
 * Auto generated 11-12-2013 01:44
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MOOX Core',
	'description' => 'MOOX Core TYPO3 Bootstrap package',
	'category' => 'misc',
	'shy' => 0,
	'version' => '0.0.1',
	'dependencies' => 'cms,flux,vhs,fluidcontent,fluidpages',
	'conflicts' => 'css_styled_content',
	'priority' => 'top',
	'loadOrder' => '',
	'module' => '',
	'state' => 'experimental',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'DCN GmbH',
	'author_email' => 'info@dcn.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.1.0-6.2.99',
			'cms' => '',
			'flux' => '7.0.0-7.1.99',
			'vhs' => '1.8.0-1.9.99',
		),
		'conflicts' => array(
			'css_styled_content' => ''
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:0:{}',
	'suggests' => array(
	),
);
