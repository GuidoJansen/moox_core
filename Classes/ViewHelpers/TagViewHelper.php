<?php
namespace FluidTYPO3\MooxCore\ViewHelpers;
/*****************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * ### Tag building ViewHelper
 *
 * Creates one HTML tag of any type, with various properties
 * like class and ID applied only if arguments are not empty,
 * rather than apply them always - empty or not - if provided.
 *
 * @package Vhs
 * @subpackage ViewHelpers
 */
class TagViewHelper extends AbstractTagBasedViewHelper {

	/**
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerArgument('name', 'string', 'Tag name', TRUE);
	}

	/**
	 * @return string
	 */
	public function render() {
		$this->arguments['class'] = trim($this->arguments['class']);
		$content = $this->renderChildren();
		if ('none' === $this->arguments['name'] || TRUE === empty($this->arguments['name'])) {
			// skip building a tag if special keyword "none" is used, or tag name is empty
			return $content;
		}
		// process a few key variables to support values coming from TCEforms storage:
		if (FALSE === empty($this->arguments['class'])) {
			$this->arguments['class'] = str_replace(',', ' ', $this->arguments['class']);
		}
		$this->tag->reset();
		$this->tag->setTagName($this->arguments['name']);
		$this->applyAttributes($this->arguments['additionalAttributes']);
		unset($this->arguments['name'], $this->arguments['additionalAttributes']);
		$this->applyAttributes($this->arguments);
		$this->tag->setContent($content);
		return $this->tag->render();
	}

	/**
	 * @param array $attributes
	 * @return void
	 */
	protected function applyAttributes($attributes) {
		if (NULL === $attributes) {
			return;
		}
		foreach ($attributes as $attributeName => $attributeValue) {
			if ('none' !== $attributeValue && (FALSE === empty($attributeValue) || 0 === $attributeValue || '0' === $attributeValue)) {
				$this->tag->addAttribute($attributeName, $attributeValue);
			}
		}
	}

}