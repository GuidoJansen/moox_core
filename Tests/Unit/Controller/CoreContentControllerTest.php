<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\Controller;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\FluidcontentCore\Controller\CoreContentController;
use FluidTYPO3\FluidcontentCore\Provider\CoreContentProvider;
use TYPO3\CMS\Core\Tests\Unit\Resource\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class CoreContentControllerTest
 */
class CoreContentControllerTest extends BaseTestCase {

	/**
	 * @return void
	 */
	public function testInitializeProvider() {
		$instance = $this->getMock('FluidTYPO3\\FluidcontentCore\\Controller\\CoreContentController', array('dummy'));
		$instance->injectObjectManager(GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager'));
		$this->callInaccessibleMethod($instance, 'initializeProvider');
		$this->assertAttributeInstanceOf('FluidTYPO3\\FluidcontentCore\\Provider\\CoreContentProvider', 'provider', $instance);
	}

	/**
	 * @return void
	 */
	public function testInitializeViewVariables() {
		$instance = $this->getMock(
			'FluidTYPO3\\FluidcontentCore\\Controller\\CoreContentController',
			array('getRecord', 'initializeSettings', 'initializeViewObject')
		);
		$instance->expects($this->atLeastOnce())->method('getRecord')->willReturn(array('uid' => 0));
		$instance->expects($this->once())->method('initializeSettings');
		$instance->expects($this->once())->method('initializeViewObject');
		$service = $this->getMock('FluidTYPO3\\Flux\\Service\\FluxService', array('convertFlexFormContentToArray'));
		$service->expects($this->once())->method('convertFlexFormContentToArray')->willReturn(array());
		$instance->injectObjectManager(GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager'));
		$instance->injectConfigurationService($service);
		$instance->initializeView(new StandaloneView());
	}

	/**
	 * @dataProvider getNoopActionNames
	 * @param string $action
	 */
	public function testNoopAction($action) {
		$instance = new CoreContentController();
		$actionMethod = $action . 'Action';
		$result = $instance->$actionMethod();
		$this->assertNull($result);
	}

	/**
	 * @return array
	 */
	public function getNoopActionNames() {
		return array(
			array('default'),
			array('header'),
			array('text'),
			array('image'),
			array('bullets'),
			array('uploads'),
			array('table'),
			array('media'),
			array('shortcut'),
			array('div'),
			array('html')
		);
	}

	/**
	 * @dataProvider getMenuActionTestValues
	 * @param array $record
	 * @param array $expectsVariables
	 * @return void
	 */
	public function testMenuAction(array $record, array $expectsVariables) {
		$GLOBALS['TYPO3_DB'] = $this->getMock('TYPO3\\CMS\\Core\\Database\\DatabaseConnection', array('exec_SELECTgetRows'), array(), '', FALSE);
		$GLOBALS['TYPO3_DB']->expects($this->any())->method('exec_SELECTgetRows')->willReturn(array());
		$instance = $this->getMock(
			'FluidTYPO3\\FluidcontentCore\\Controller\\CoreContentController',
			array('getRecord', 'initializeViewVariables', 'initializeViewSettings', 'initializeViewObject', 'initializeSettings')
		);
		$instance->expects($this->any())->method('getRecord')->willReturn($record);
		$view = $this->getMock('TYPO3\\CMS\\Fluid\\View\\StandaloneView', array('assign'));
		foreach ($expectsVariables as $index => $expectedVariable) {
			$view->expects($this->at($index))->method('assign')->with($expectedVariable, $this->anything());
		}
		$instance->injectObjectManager(GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager'));
		$this->callInaccessibleMethod($instance, 'initializeProvider');
		$instance->initializeView($view);
		$result = $instance->menuAction();
		$this->assertNull($result);
	}

	/**
	 * @return array
	 */
	public function getMenuActionTestValues() {
		return array(
			array(array(), array()),
			array(array(CoreContentProvider::MENUTYPE_FIELDNAME => CoreContentProvider::MENU_CATEGORIZEDPAGES), array('pageUids')),
			array(array(CoreContentProvider::MENUTYPE_FIELDNAME => CoreContentProvider::MENU_CATEGORIZEDCONTENT), array('contentUids'))
		);
	}

}
