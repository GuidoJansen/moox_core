<?php
namespace DCNGmbH\MooxCore\Service;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\Service\FluxService;
use FluidTYPO3\Flux\Utility\ExtensionNamingUtility;
use FluidTYPO3\Flux\Utility\PathUtility;
use FluidTYPO3\Flux\Utility\ResolveUtility;
use FluidTYPO3\Flux\View\TemplatePaths;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Class ConfigurationService
 */
class ConfigurationService extends FluxService implements SingletonInterface {

	/**
	 * @var array
	 */
	protected $variants = array();

	/**
	 * @var array
	 */
	protected $versions = array();

	/**
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->initializeDefaults();
		$this->initializeVariants();
	}

	/**
	 * @return void
	 */
	protected function initializeDefaults() {
		$typoScript = $this->getAllTypoScript();
		$this->defaults = (array) $typoScript['plugin']['tx_mooxcore']['settings']['defaults'];
	}

	/**
	 * @return void
	 */
	protected function initializeVariants() {
		$variants = (array) $this->getAllRegisteredVariants();
		foreach ($variants as $contentType => $registeredVariantExtensions) {
			if (TRUE === empty($registeredVariantExtensions)) {
				continue;
			}
			$this->variants[$contentType] = array();
			foreach ($registeredVariantExtensions as $extensionKeyOrArray) {
				$icon = NULL;
				if (TRUE === is_array($extensionKeyOrArray) && 3 === count($extensionKeyOrArray)) {
					list ($extensionKey, $labelReference, $icon) = $extensionKeyOrArray;
				} elseif (TRUE === is_array($extensionKeyOrArray) && 2 === count($extensionKeyOrArray)) {
					list ($extensionKey, $labelReference) = $extensionKeyOrArray;
				} else {
					$extensionKey = ExtensionNamingUtility::getExtensionKey($extensionKeyOrArray);
					$labelReference = 'moox_core.variantLabel';
				}
				$templatePathAndFilename = $this->resolveTemplateFileForVariant($extensionKey, $contentType, $extensionKeyOrArray);
				$controllerName = 'CoreContent/' . ucfirst($contentType);
				$paths = $this->getViewConfigurationForExtensionName($extensionKey);
				$templatePaths = new TemplatePaths($paths);
				$files = $templatePaths->resolveAvailableTemplateFiles($controllerName);
				foreach ($files as $file) {
					$versions[] = basename($file, '.' . TemplatePaths::DEFAULT_FORMAT);
				}
				$versions = array_unique($versions);
				$this->versions[$contentType] = array($extensionKey => $versions);
				$this->variants[$contentType][] = array($extensionKey, $labelReference, $icon);
			}
		}
	}

	/**
	 * @return array
	 */
	public function getDefaults() {
		return $this->defaults;
	}

	/**
	 * @return array
	 */
	public function getAllRegisteredVariants() {
		return (array) $GLOBALS['TYPO3_CONF_VARS']['DCNGmbH.MooxCore']['variants'];
	}

	/**
	 * @param string $contentType
	 * @return array
	 */
	public function getVariantExtensionKeysForContentType($contentType) {
		if (TRUE === isset($this->variants[$contentType])) {
			return $this->variants[$contentType];
		}
		return array();
	}

	/**
	 * @param string $contentType
	 * @param string $variant
	 * @return array
	 */
	public function getVariantVersions($contentType, $variant) {
		if (TRUE === isset($this->versions[$contentType][$variant])) {
			return $this->versions[$contentType][$variant];
		}
		return array();
	}

	/**
	 * @param string $extensionKey
	 * @param string $contentType
	 * @param string $variant
	 * @param string $version
	 * @return string
	 */
	public function resolveTemplateFileForVariant($extensionKey, $contentType, $variant = NULL, $version = NULL) {
		$paths = $this->getViewConfigurationForExtensionName(FALSE === empty($variant) ? $variant : $extensionKey);
		$templatePaths = new TemplatePaths($paths);
                $controllerName = 'CoreContent';
		$controllerAction = FALSE === empty($version) ? $contentType . '/' . $version : $contentType;
		return $templatePaths->resolveTemplateFileForControllerAndActionAndFormat($controllerName, $controllerAction);
	}

}