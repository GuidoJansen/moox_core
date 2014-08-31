<?php
namespace FluidTYPO3\MooxCore\Controller;
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

use FluidTYPO3\Flux\Controller\AbstractFluxController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CoreContentController extends AbstractFluxController {

	/**
	 * @var string
	 */
	protected $fluxRecordField = 'content_options';

	/**
	 * @var string
	 */
	protected $fluxTableName = 'tt_content';

	/**
	 * @return void
	 */
	protected function initializeProvider() {
		$this->provider = $this->objectManager->get('FluidTYPO3\MooxCore\Provider\ContentProvider');
	}

	/**
	 * @return void
	 */
	protected function initializeViewVariables() {
		$row = $this->getRecord();
		$flexFormData = $this->configurationService->convertFlexFormContentToArray($row['pi_flexform']);
		$this->settings = GeneralUtility::array_merge_recursive_overrule($this->settings, $flexFormData, FALSE, FALSE);
		parent::initializeViewVariables();
	}

	/**
	 * @return void
	 */
	public function defaultAction() {

	}

	/**
	 * @return void
	 */
	public function headerAction() {

	}

	/**
	 * @return void
	 */
	public function textAction() {

	}

	/**
	 * @return void
	 */
	public function textpicAction() {

	}

	/**
	 * @return void
	 */
	public function imageAction() {

	}

	/**
	 * @return void
	 */
	public function bulletsAction() {

	}

	/**
	 * @return void
	 */
	public function uploadsAction() {

	}

	/**
	 * @return void
	 */
	public function tableAction() {

	}

	/**
	 * @return void
	 */
	public function mediaAction() {

	}

	/**
	 * @return void
	 */
	public function menuAction() {

	}

	/**
	 * @return void
	 */
	public function shortcutAction() {

	}

	/**
	 * @return void
	 */
	public function divAction() {

	}

	/**
	 * @return void
	 */
	public function htmlAction() {

	}

}