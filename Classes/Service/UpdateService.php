<?php
namespace DCNGmbH\MooxCore\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * UpdateService for moox_core
 *
 * @package MooxCore
 */
class UpdateService {

    /**
     * @var string
     */
    protected $sourceConfigurationLines = array(
        '$GLOBALS[\'TYPO3_CONF_VARS\'][\'FE\'][\'contentRenderingTemplates\'] = array(\'mooxcore/Configuration/TypoScript/\');',
        '$GLOBALS[\'TYPO3_CONF_VARS\'][\'FE\'][\'activateContentAdapter\'] = 0;'
    );

    /**
     * @var string
     */
    protected $targetConfigurationFile = 'typo3conf/AdditionalConfiguration.php';

    /**
     * Constructor
     */
    public function __construct() {
        $this->targetConfigurationFile = GeneralUtility::getFileAbsFileName($this->targetConfigurationFile);
    }

    /**
     * @return array
     */
    protected function getCurrentConfigurationLines() {
        if (FALSE === file_exists($this->targetConfigurationFile)) {
            // We return not a completely empty array but an array containing the
            // expected opening PHP tag; to make sure it ends up in the output.
            return array('<?php');
        }
        $lines = explode(PHP_EOL, trim(file_get_contents($this->targetConfigurationFile)));
        if (0 === count($lines) || '<?php' !== $lines[0]) {
            array_unshift($lines, '<?php');
        }
        return $lines;
    }

    /**
     * Returns TRUE if either of the expected configuration lines
     * do not currently exist. If both exist, returns FALSE
     * meaning "no need to run the script"
     *
     * NOTE: Is required by the extension manager, do not remove or make protected
     * @api
     * @return boolean
     */
    public function access() {
        $currentConfiguration = $this->getCurrentConfigurationLines();
        foreach ($this->sourceConfigurationLines as $expectedConfigurationLine) {
            if (FALSE === in_array($expectedConfigurationLine, $currentConfiguration)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * NOTE: Is required by the extension manager, do not remove or make protected
     * @api
     * @return string
     */
    public function main() {
        $this->installAdditionalConfiguration();
        return 'Additional configuration lines added to AdditionalConfiguration.php';
    }

    /**
     * Install expected lines missing from AdditionalConfiguration file
     *
     * @return void
     */
    protected function installAdditionalConfiguration() {
        $currentConfigurationLines = $this->getCurrentConfigurationLines();
        // remove trailing empty spaces and closing PHP tag to ensure predictable appending:
        for ($i = count($currentConfigurationLines) - 1; $i--; $i >= 0) {
            $line = trim($currentConfigurationLines[$i]);
            if (TRUE === empty($line) || '?>' === $line) {
                unset($currentConfigurationLines[$i]);
            }
        }
        // add expected lines if they are not found:
        foreach ($this->sourceConfigurationLines as $expectedConfigurationLine) {
            if (FALSE === in_array($expectedConfigurationLine, $currentConfigurationLines)) {
                $currentConfigurationLines[] = $expectedConfigurationLine;
            }
        }
        $this->writeAdditionalConfigurationFile($currentConfigurationLines);
    }

    /**
     * Wrapping method to write array to file
     *
     * @param array $lines
     * @return void
     */
    protected function writeAdditionalConfigurationFile(array $lines) {
        $content = implode(PHP_EOL, $lines) . PHP_EOL;
        file_put_contents($this->targetConfigurationFile, $content);
    }

}