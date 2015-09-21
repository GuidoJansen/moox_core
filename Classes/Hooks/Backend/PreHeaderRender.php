<?php
namespace DCNGmbH\MooxCore\Hooks\Backend;

/**
 * @author Jakub Czyz <jc@dcn.de>
 */
class PreHeaderRender {

    /**
     * @param array $params
     * @param \TYPO3\CMS\Backend\Template\DocumentTemplate $documentTemplate
     */
    public function addStyles(&$params, &$documentTemplate){
        $backendCssFile = '/typo3conf/ext/moox_core/Resources/Public/Stylesheets/backend.css';
        $params['pageRenderer']->addCssFile($backendCssFile,'stylesheet');
    }

}
