<?php
namespace FluidTYPO3\MooxCore\Service;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
class InstallService {
    
    protected $extKey = 'moox_core';
    /**
     * @param string $extension
     */
    public function generateApacheHtaccess($extension = NULL){
        if($extension == $this->extKey){
            if(substr($_SERVER['SERVER_SOFTWARE'], 0, 6) === 'Apache'){
                $this->createDefaultHtaccessFile();
            }else{
                /**
                 * Add Flashmessage that the system it not running on an apache webserver and the url rewritings must be handled manually
                 */
                $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                   'The Bootstrap Package uses RealUrl to generate SEO friendly URLs by default, please take care of the URLs rewriting settings for your environment yourself.<br>'
                    . 'You can also deactivate RealUrl by changing your TypoScript setup to "<strong>config.tx_realurl_enable = 0</strong>".',
                   'TYPO3 is not running on an Apache-Webserver',
                   FlashMessage::WARNING,
                   TRUE
                );
                FlashMessageQueue::addMessage($message);
                return;
            }
        }
    }
    /**
	 * Creates .htaccess file inside the root directory
	 *
	 * @param string $htaccessFile Path of .htaccess file
	 * @return void
	 */
    public function createDefaultHtaccessFile(){
        $htaccessFile = GeneralUtility::getFileAbsFileName(".htaccess");
                
        if(file_exists($htaccessFile)){
            
            /**
             * Add Flashmessage that there is already an .htaccess file and we are not going to override this.
             */
            $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'There is already an Apache .htaccess file in the root directory, please make sure that the url rewritings are set properly.<br>'
                . 'An example configuration is located at: <strong>typo3conf/ext/moox_core/Configuration/Apache/.htaccess</strong>',
                'Apache .htaccess file already exists',
                FlashMessage::NOTICE,
                TRUE
            );
            FlashMessageQueue::addMessage($message);
			return;
	}
                   
        $htaccessContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey).'/Configuration/Apache/.htaccess');
        GeneralUtility::writeFile($htaccessFile, $htaccessContent, TRUE);
        
        /**
         * Add Flashmessage that the example htaccess file was placed in the root directory
         */
        $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'For RealURL and optimization purposes an example .htaccess file was placed in your root directory. <br>'            . ' Please check if the RewriteBase correctly set for your environment. ',            'Apache example .htaccess was placed in the root directory.',            FlashMessage::OK,            TRUE       );       FlashMessageQueue::addMessage($message);    }   
    /**
	 * Creates AdditionalConfiguration.php file inside the typo3conf directory	 *	 * @param string $configurationFile Path of AdditionalConfiguration.php file	 * @return void	 */
    public function createDefaultAdditionalConfiguration($extension = NULL){	if($extension == $this->extKey){	    	    $configurationFile = GeneralUtility::getFileAbsFileName("typo3conf/AdditionalConfiguration.php");		    	    if(file_exists($configurationFile)){				/**		 * Add Flashmessage that there is already an AdditionalConfiguration.php file and we are not going to override this.		 */		$message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',		    'There is already an AdditionalConfiguration file in the typo3conf directory, please make this line to your configuration "$GLOBALS[\'TYPO3_CONF_VARS\'][\'FE\'][\'contentRenderingTemplates\'] = array(\'mooxcore/Configuration/TypoScript/\');".<br>'		    . 'An example configuration is located at: <strong>typo3conf/ext/moox_core/Configuration/AdditionalConfiguration/AdditionalConfiguration.php</strong>',		    'AdditionalConfiguration.php file already exists',		    FlashMessage::NOTICE,		    TRUE		);		FlashMessageQueue::addMessage($message);			    return;		    }		       	    $configurationContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey).'/Configuration/AdditionalConfiguration/AdditionalConfiguration.php');	    GeneralUtility::writeFile($configurationFile, $configurationContent, TRUE);	    	    /**	     * Add Flashmessage that the example AdditionalCOnfiguration.php file was placed in the typo3conf directory	     */	    $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',		'AdditionalConfiguration.php file was placed in your typo3conf directory. <br>',		'AdditionalConfiguration.php was placed in the typo3conf directory.',		FlashMessage::OK,		TRUE	   );	   FlashMessageQueue::addMessage($message);	   	}    }
    	/**	 * Creates robots.txt file inside the root directory	 *
	 * @param string $robotsFile Path of robots.txt file
	 * @return void
	 */
    public function createDefaultRobots($extension = NULL){
	if($extension == $this->extKey){
	
	    $robotsFile = GeneralUtility::getFileAbsFileName("robots.txt");
		    
	    if(file_exists($robotsFile)){
		
		/**
		 * Add Flashmessage that there is already an robots.txt file and we are not going to override this.
		 */
		$message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
		    'There is already an robots.txt file in the root directory.<br>'
		    . 'An example robots.txt is located at: <strong>typo3conf/ext/moox_core/Configuration/Robots/robots.txt</strong>',
		    'robots.txt file already exists',
		    FlashMessage::NOTICE,
		    TRUE
		);
		FlashMessageQueue::addMessage($message);
			    return;
		    }
		       
	    $robotsContent .= "User-Agent: * \n";
	    $robotsContent .= " \n";
	    $robotsContent .= "Allow: / \n";
	    $robotsContent .= "Disallow: /fileadmin/System/ \n";
	    $robotsContent .= "Disallow: /cms/ \n";
	    $robotsContent .= "Disallow: /t3lib/ \n";
	    $robotsContent .= "Disallow: /typo3/ \n";
	    $robotsContent .= "Disallow: /typo3conf/ \n";
	    $robotsContent .= "Disallow: /typo3temp/ \n";
	    $robotsContent .= "Disallow: /*?id=* \n";
	    $robotsContent .= "Disallow: /*&type=98 \n";
	    $robotsContent .= " \n";
	    $robotsContent .= "Sitemap: http://" .$_SERVER['HTTP_HOST']. "/sitemap.xml";
	    GeneralUtility::writeFile($robotsFile, $robotsContent, TRUE);
	    
	    /**
	     * Add Flashmessage that the example AdditionalCOnfiguration.php file was placed in the typo3conf directory
	     */
	    $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
		'robots.txt file was placed in your root directory. <br>',
		'robots.txt was placed in the root directory.',
		FlashMessage::OK,
		TRUE
	   );
	   FlashMessageQueue::addMessage($message);
	   
	}
    }}