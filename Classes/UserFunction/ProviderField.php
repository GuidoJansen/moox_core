<?php
namespace DCNGmbH\MooxCore\UserFunction;
/*****************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Claus Due <claus@namelesscoder.net>
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

use DCNGmbH\MooxCore\Provider\CoreContentProvider;
use DCNGmbH\MooxCore\Service\ConfigurationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Variants Field TCA user function
 */
class ProviderField {

	/**
	 * @var ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var ConfigurationService
	 */
	protected $configurationService;

	/**
	 * @param ObjectManagerInterface $objectManager
	 * @reutrn void
	 */
	public function injectObjectManager(ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param ConfigurationService $configurationService
	 * @return void
	 */
	public function injectConfigurationService(ConfigurationService $configurationService) {
		$this->configurationService = $configurationService;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->injectObjectManager(GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager'));
		$this->injectConfigurationService($this->objectManager->get('DCNGmbH\MooxCore\Service\ConfigurationService'));
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public function createVariantsField(array $parameters) {
		$extensionKeys = $this->configurationService->getVariantExtensionKeysForContentType($parameters['row']['CType']);
		$defaults = $this->configurationService->getDefaults();
		$preSelected = $parameters['row']['content_variant'];
		if (CoreContentProvider::MODE_PRESELECT === $defaults['mode'] && TRUE === empty($preSelected)) {
			$preSelected = $defaults['variant'];
		}
		if (TRUE === is_array($extensionKeys) && 0 < count($extensionKeys)) {
			$options = $this->renderOptions($extensionKeys);
		} else {
			$options = array();
		}
		return $this->renderSelectField($parameters, $options, $preSelected);
	}
	
	/**
	 * @param array $variants
	 * @return array
	 */
	protected function renderOptions(array $variants) {
		$options = array();
		foreach ($variants as $variantSetup) {
			list ($extensionKey, $labelReference, $icon) = $variantSetup;
			$translatedLabel = LocalizationUtility::translate($labelReference, $extensionKey);
			if (NULL === $translatedLabel) {
				$translatedLabel = $extensionKey;
			}
			if (NULL !== $icon) {
				$translatedLabel = '<img src="' . $icon . '" alt="' . $extensionKey . '" /> ' . $translatedLabel;
			}
			$options[$extensionKey] = $translatedLabel;
		}
		return $options;
	}

	/**
	 * @param array $parameters
	 * @param array $options
	 * @param mixed $selectedValue
	 * @return string
	 */
	protected function renderSelectField($parameters, $options, $selectedValue) {
		$hasSelectedValue = (TRUE === empty($selectedValue) || TRUE === array_key_exists($selectedValue, $options));
		$selected = (TRUE === empty($selectedValue) ? ' selected="selected"' : NULL);
		$html = array(
			'<div class="form-control-wrap"><select class="select form-control" name="' . $parameters['itemFormElName'] . '" onchange="' . $parameters['fieldChangeFunc']['TBE_EDITOR_fieldChanged'] . ';' . $parameters['fieldChangeFunc']['alert'] . '">',
			'<option' . $selected . ' value="">' . LocalizationUtility::translate('tt_content.nativeLabel', 'MooxCore') . '</option>'
		);
		foreach ($options as $value => $label) {
			$selected = $value === $selectedValue ? ' selected="selected"' : NULL;
			$html[] = '<option' . $selected . ' value="' . $value . '">' . $label . '</option>';
		}
		if (FALSE === $hasSelectedValue) {
			$html[] = '<option selected="selected">INVALID: ' . $selectedValue . '</option>';
		}
		$html[] = '</select></div>';
		return implode(LF, $html);
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public function createVersionsField(array $parameters) {
		$defaults = $this->configurationService->getDefaults();
		$preSelectedVariant = $parameters['row']['content_variant'];
		$preSelectedVersion = $parameters['row']['content_version'];
		if (CoreContentProvider::MODE_PRESELECT === $defaults['mode']) {
			if (TRUE === empty($preSelectedVariant)) {
				$preSelectedVariant = $defaults['variant'];
			}
			if (TRUE === empty($preSelectedVersion)) {
				$preSelectedVersion = $defaults['version'];
			}
		}

		$versions = $this->configurationService->getVariantVersions($parameters['row']['CType'], $preSelectedVariant);
		if (TRUE === is_array($versions) && 0 < count($versions)) {
			$options = array_combine($versions, $versions);
		} else {
			$options = array();
		}
		return $this->renderSelectField($parameters, $options, $preSelectedVersion);
	}

}