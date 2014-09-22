<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "moox_core".
 *
 * Auto generated 11-12-2013 01:44
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MOOX Bootstrap Responsive',
	'description' => 'Makes TYPO3 fully responsive using Bootstrap, HTML5 Boilerplate, jQuery and Superfish. Extended by MOOX Design Templates, MOOX News and other MOOX Extensions. Best way to use the MOOX Core Extension is to install a Template, as moox_core will be autoinstalled by dependencies.',
	'category' => 'misc',
	'shy' => 0,
	'version' => '0.9.7',
	'dependencies' => 'cms,extbase,fluid,flux,vhs,fluidcontent,fluidpages,realurl',
	'conflicts' => 'css_styled_content',
	'priority' => 'top',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'MOOX Team',
	'author_email' => 'moox@dcn.de',
	'author_company' => 'DCN GmbH',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-6.2.99',
                        'extbase' => '6.2.0-6.2.99',
			'fluid' => '6.2.0-6.2.99',
			'flux' => '7.1.0-7.1.99',
			'vhs' => '2.0.0-2.0.99',
                        'fluidcontent' => '4.1.0-4.1.99',
			'fluidpages' => '3.1.0-3.1.99',
                        'realurl' => '1.12.8-1.12.99',
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
