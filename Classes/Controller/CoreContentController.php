<?php
namespace DCNGmbH\MooxCore\Controller;
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
use FluidTYPO3\Flux\Controller\AbstractFluxController;
use FluidTYPO3\Flux\Utility\RecursiveArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Class CoreContentController
 */
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
		$this->provider = $this->objectManager->get('DCNGmbH\MooxCore\Provider\CoreContentProvider');
	}

	/**
	 * @return void
	 */
	protected function initializeViewVariables() {
		$row = $this->getRecord();
		$flexFormData = $this->configurationService->convertFlexFormContentToArray($row['pi_flexform']);
		$this->settings = RecursiveArrayUtility::merge($this->settings, $flexFormData, FALSE, FALSE);
		$form = $this->provider->getForm($row);
		$generalSettings = $this->configurationService->convertFlexFormContentToArray($row['pi_flexform'], $form);
		$contentSettings = $this->configurationService->convertFlexFormContentToArray($row['content_options'], $form);
		$this->settings = RecursiveArrayUtility::merge($this->settings, $generalSettings, FALSE, FALSE);
		if (FALSE === isset($this->settings['content'])) {
			$this->settings['content'] = $contentSettings;
		} else {
			$this->settings['content'] = RecursiveArrayUtility::merge($this->settings['content'], $contentSettings);
		}
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
		$record = $this->getRecord();
		$type = $record[CoreContentProvider::MENUTYPE_FIELDNAME];
		switch ($type) {
			case CoreContentProvider::MENU_CATEGORIZEDPAGES:
				$selected = $record['selected_categories'];
				$bindings = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid_foreign',
					'sys_category_record_mm',
					"fieldname = 'categories' AND tablenames = 'pages' AND uid_local IN (" . $selected . ')',
					'uid_foreign',
					'sorting ASC'
				);
				$pageUids = array_map('array_pop', $bindings);
				$this->view->assign('pageUids', $pageUids);
				break;
			case CoreContentProvider::MENU_CATEGORIZEDCONTENT:
				$selected = $record['selected_categories'];
				$bindings = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid_foreign',
					'sys_category_record_mm',
					"fieldname = 'categories' AND tablenames = 'tt_content' AND uid_local IN (" . $selected . ')',
					'uid_foreign',
					'sorting ASC'
				);
				$contentUids = array_map('array_pop', $bindings);
				$this->view->assign('contentUids', $contentUids);
				break;
			case CoreContentProvider::MENU_RELATEDPAGES:
				$whereKeywords = $this->getWhereQueryForKeywords($record);
				$selectedUids = TRUE === empty($record['pages']) ? $record['uid'] : $record['pages'];
				$where = $whereKeywords . ' AND uid NOT IN (' . $selectedUids . ')';
				$bindings = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid',
					'pages',
					$where,
					'',
					'sorting ASC'
				);
				$pageUids = array_map('array_pop', $bindings);
				$this->view->assign('pageUids', $pageUids);
				break;
			default:
		}
	}

	/**
	 * @return void
	 */
	public function shortcutAction() {
		$record = $this->getRecord();
		$contentUids = array_map(function($index) {
			if (0 !== strpos($index, 'tt_content_') && FALSE === MathUtility::canBeInterpretedAsInteger($index)) {
				return FALSE;
			}
			return str_replace('tt_content_', '', $index);
		}, GeneralUtility::trimExplode(',', $record['records']));

		$this->view->assign('contentUids', implode(',', array_filter($contentUids)));
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

	/**
	 * @param $record
	 * @return string
	 */
	protected function getWhereQueryForKeywords($record) {
		$selectedUids = $record['pages'];
		if (TRUE == empty($selectedUids)) {
			$selectedUids = $record['pid'];
		}
		$keywordsRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'keywords',
			'pages',
			'uid IN (' . $selectedUids . ')',
			'',
			'sorting ASC'
		);

		$keywords = implode(',', array_map('array_pop', $keywordsRows));
		$keywordsArray = array_unique(explode(',', $keywords));
		$keyWordsWhereArr = array();
		foreach ($keywordsArray as $word) {
			$word = trim($word);
			if ($word) {
				$keyWordsWhereArr[] = 'keywords LIKE \'%' . $GLOBALS['TYPO3_DB']->quoteStr($word, 'pages') . '%\'';
			}
		}
		$where = empty($keyWordsWhereArr) ? '' : '(' . implode(' OR ', $keyWordsWhereArr) . ')';
		return $where;
	}

}