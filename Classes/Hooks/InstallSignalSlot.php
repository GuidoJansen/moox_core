<?php
namespace DCNGmbH\MooxCore\Hooks;

use DCNGmbH\MooxCore\Service\UpdateService;
use TYPO3\CMS\Core\SingletonInterface;
/**
 * InstallSignalSlot
 */
class InstallSignalSlot implements SingletonInterface {
    /**
     * Install AddionalConfiguration
     */
    public function installAddionalConfiguration() {
        $updateService = new UpdateService();
        $updateService->main();
    }
}