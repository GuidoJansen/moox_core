<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Claus Due <claus@namelesscoder.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Updater Script for fluidcontent_core
 *
 * @package FluidcontentCore
 */
class ext_update {

	/**
	 * @var string
	 */
	protected $targetConfigurationFile = 'typo3conf/AdditionalConfiguration.php';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->targetConfigurationFile = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->targetConfigurationFile);
	}

	/**
	 * @return boolean
	 */
	public function access() {
		return (FALSE === file_exists($this->targetConfigurationFile) && TRUE === \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('fluidcontent_core'));
	}

	/**
	 * @return string
	 */
	public function main() {
		$sourceFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('moox_core', 'Build/AdditionalConfiguration.php');
		copy($sourceFile, $this->targetConfigurationFile);
		return 'Deployed "' . $sourceFile . '" to "' . $this->targetConfigurationFile . '"';
	}

}
