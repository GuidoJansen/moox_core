<?php
namespace FluidTYPO3\MooxCore\Hooks\Backend;

/**
 * @author Jakub Czyz <jc@dcn.de>
 */
class RenderPreProcess {

    /**
     * @param array $params
     * @param \TYPO3\CMS\Backend\Controller\BackendController $backendController
     */
    public function addStyles(&$params, &$backendController){
        $backendCssFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('moox_core') . 'Resources/Public/Stylesheets/backend.css';
        $backendController->addCssFile('moox_core',$backendCssFile);
    }

}