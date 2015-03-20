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
	protected static $variants = array();

	/**
	 * @var array
	 */
	protected static $versions = array();

	/**
	 * @return array
	 */
	public function getDefaults() {
		$typoScript = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$defaults = (array) $typoScript['plugin.']['tx_mooxcore.']['settings.']['defaults.'];
		$defaults = GeneralUtility::removeDotsFromTS($defaults);
		return $defaults;
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
		$variants = $this->getAllRegisteredVariants();
		if (FALSE === isset($variants[$contentType])) {
			return array();
		}
		if (TRUE === isset(self::$variants[$contentType])) {
			return self::$variants[$contentType];
		}
		self::$variants[$contentType] = array();
		foreach ($variants[$contentType] as $variantExtensionKey) {
			$icon = NULL;
			if (TRUE === is_array($variantExtensionKey) && 3 === count($variantExtensionKey)) {
				list ($variantExtensionKey, $labelReference, $icon) = $variantExtensionKey;
			} elseif (TRUE === is_array($variantExtensionKey) && 2 === count($variantExtensionKey)) {
				list ($variantExtensionKey, $labelReference) = $variantExtensionKey;
			} else {
				$actualKey = ExtensionNamingUtility::getExtensionKey($variantExtensionKey);
				$labelReference = 'moox_core.variantLabel';
			}
			$templatePathAndFilename = $this->resolveTemplateFileForVariant(
				$variantExtensionKey, $contentType, $variantExtensionKey
			);
			if (TRUE === file_exists(PathUtility::translatePath($templatePathAndFilename))) {
				array_push(self::$variants[$contentType], array($variantExtensionKey, $labelReference, $icon));
			}
		}
		return self::$variants[$contentType];
	}

	/**
	 * @param string $contentType
	 * @param string $variant
	 * @return array
	 */
	public function getVariantVersions($contentType, $variant) {
		if (TRUE === isset(self::$versions[$contentType][$variant])) {
			return self::$versions[$contentType][$variant];
		}
		if (FALSE === isset(self::$versions[$contentType])) {
			self::$versions[$contentType] = array();
		}
		$paths = $this->getViewConfigurationForExtensionName($variant);
		$versionsDirectory = rtrim($paths['templateRootPath'], '/') . '/CoreContent/' . ucfirst($contentType) . '/';
		$versionsDirectory = PathUtility::translatePath($versionsDirectory);
		if (FALSE === is_dir($versionsDirectory)) {
			self::$versions[$contentType][$variant] = array();
		} else {
			$files = glob($versionsDirectory . '*.html');
			foreach ($files as &$file) {
				$file = basename($file, '.html');
			}
			self::$versions[$contentType][$variant] = $files;
		}
		return self::$versions[$contentType][$variant];
	}

	/**
	 * @param string $extensionKey
	 * @param string $contentType
	 * @param string $variant
	 * @param string $version
	 * @return string
	 */
	public function resolveTemplateFileForVariant($extensionKey, $contentType, $variant = NULL, $version = NULL) {
		if (FALSE === empty($variant)) {
			$extensionKey = $variant;
		}
		$paths = $this->getViewConfigurationForExtensionName($extensionKey);
		$controllerName = 'CoreContent';
		$controllerAction = $contentType;
		$format = 'html';
		if (FALSE === empty($version)) {
			$controllerAction .= '/' . $version;
		}

		$templatePathAndFilename = ResolveUtility::resolveTemplatePathAndFilenameByPathAndControllerNameAndActionAndFormat(
			$paths, $controllerName, $controllerAction, $format
		);
		return $templatePathAndFilename;
	}

}