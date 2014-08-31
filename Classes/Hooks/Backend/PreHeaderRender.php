<?php
namespace FluidTYPO3\MooxCore\Hooks\Backend;

/**
 * @author Jakub Czyz <jc@dcn.de>
 */
class PreHeaderRender {

    /**
     * @param array $params
     * @param \TYPO3\CMS\Backend\Template\DocumentTemplate $documentTemplate
     */
    public function addStyles(&$params, &$documentTemplate){
        $backendCssFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('moox_core') . 'Resources/Public/Stylesheets/backend.css';
        $params['pageRenderer']->addCssFile('moox_core',$backendCssFile);
    }

}