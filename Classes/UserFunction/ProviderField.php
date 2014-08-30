<?php
namespace FluidTYPO3\MooxCore\UserFunction;
/*****************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
 *  (c) 2014 DCN GmbH <moox@dcn.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 *****************************************************************/

use FluidTYPO3\MooxCore\Provider\ContentProvider;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Variants Field TCA user function
 * @package FluidcontentCore
 */
class ProviderField {

	/**
	 * @var ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var ContentProvider
	 */
	protected $provider;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$this->provider = $this->objectManager->get('FluidTYPO3\MooxCore\Provider\ContentProvider');
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public function createVariantsField(array $parameters) {
		$extensionKeys = $this->provider->getVariantExtensionKeysForContentType($parameters['row']['CType']);
		return $this->renderSelectField($parameters, array_combine($extensionKeys, $extensionKeys), $parameters['row']['content_variant']);
	}

	/**
	 * @param array $parameters
	 * @param array $options
	 * @param mixed $selectedValue
	 * @return string
	 */
	protected function renderSelectField($parameters, $options, $selectedValue) {
		$hasSelectedValue = (TRUE === empty($selectedValue) || TRUE === in_array($selectedValue, $options));
		$selected = (TRUE === empty($selectedValue) ? ' selected="selected"' : NULL);
		$html = array(
			'<select class="select" name="' . $parameters['itemFormElName'] . '" onchange="' . $parameters['fieldChangeFunc']['TBE_EDITOR_fieldChanged'] . ';' . $parameters['fieldChangeFunc']['alert'] . '">',
			'<option' . $selected . ' value="">' . LocalizationUtility::translate('tt_content.nativeLabel', 'MooxCore') . '</option>'
		);
		foreach ($options as $value => $label) {
			$selected = $value === $selectedValue ? ' selected="selected"' : NULL;
			$html[] = '<option' . $selected . ' value="' . $value . '">' . $label . '</option>';
		}
		if (FALSE === $hasSelectedValue) {
			$html[] = '<option selected="selected">INVALID: ' . $selectedValue . '</option>';
		}
		$html[] = '</select>';
		return implode(LF, $html);
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public function createVersionsField(array $parameters) {
		$versions = $this->provider->getVariantVersions($parameters['row']['CType'], $parameters['row']['content_variant']);
		return $this->renderSelectField($parameters, array_combine($versions, $versions), $parameters['row']['content_version']);
	}

	/**
	 * @return string
	 */
	protected function getNoneFoundLabel() {
		return LocalizationUtility::translate('tt_content.noneFoundLabel', 'MooxCore');
	}

}
