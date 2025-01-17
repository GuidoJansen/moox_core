<?php
namespace DCNGmbH\MooxCore\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
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
 ***************************************************************/

use FluidTYPO3\Fluidcontent\Controller\AbstractContentController;

/**
 * Content Controller
 *
 * Controller which is used to render individual elements from
 * the moox_core collection.
 *
 * @package MooxCore
 * @subpackage Controller
 * @route off
 */
class ContentController extends AbstractContentController {
    
        /**
	 * @return void
	 */
	protected function initializeOverriddenSettings() {
		$record = $this->getRecord();
		$useTypoScriptOptionFromForm = $this->provider->getForm($record)->getOption('useTypoScript');
		if (NULL !== $useTypoScriptOptionFromForm) {
			$this->settings['useTypoScript'] = (boolean)$useTypoScriptOptionFromForm;
		}
		parent::initializeOverriddenSettings();
	}

	/**
	 * @return string
	 */
	public function accordionAction() {

	}

	/**
	 * @return string
	 */
	public function alertAction() {

	}

	/**
	 * @return string
	 */
	public function carouselAction() {

	}

	/**
	 * @return string
	 */
	public function rowAction() {

	}

	/**
	 * @return string
	 */
	public function jumbotronAction() {

	}

	/**
	 * @return string
	 */
	public function navigationListAction() {

	}

	/**
	 * @return string
	 */
	public function pageHeaderAction() {

	}

	/**
	 * @return string
	 */
	public function tabsAction() {

	}

	/**
	 * @return string
	 */
	public function wellAction() {

	}
        
        /**
	 * @return string
	 */
	public function progressBarAction() {

	}

	/**
	 * @return string
	 */
	public function modalLightAction() {

	}

	/**
	 * @return string
	 */
	public function buttonAction() {

	}

	/**
	 * @return string
	 */
	public function embedVideoAction() {

	}

	/**
	 * @return string
	 */
	public function simpleResponsiveImageAction() {

	}

	/**
	 * @return string
	 */
	public function threeColumnAction() {

	}

	/**
	 * @return string
	 */
	public function twoColumnAction() {

	}
        
        /**
	 * @return string
	 */
	public function fourColumnAction() {

	}
        
        /**
	 * @return string
	 */
        public function imageGalleryAction() {
    
        }

}