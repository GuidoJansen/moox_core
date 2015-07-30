<?php
namespace DCNGmbH\MooxCore\Hooks;

use TYPO3\CMS\Backend\Controller\ContentElement\NewContentElementController;
use TYPO3\CMS\Backend\Wizard\NewContentElementWizardHookInterface;
/**
 * WizardItems Hook Subscriber
 */
class WizardItemsHookSubscriber extends \FluidTYPO3\Fluidcontent\Hooks\WizardItemsHookSubscriber implements NewContentElementWizardHookInterface {
    /**
     * @param array $items
     * @param NewContentElementController $parentObject
     * @return void
     */
    public function manipulateWizardItems(&$items, &$parentObject) {
        parent::manipulateWizardItems($items, $parentObject);
    }
}