<?php
// function user_encodeSpURL_postProc(&$params, &$ref) {
    // $params['URL'] = str_replace('article/datum', 'article', $params['URL']);
	// $params['URL'] = str_replace('news/news', 'news', $params['URL']);
// }
// function user_decodeSpURL_preProc(&$params, &$ref) {
    // $params['URL'] = str_replace('article', 'article/datum', $params['URL']);
	
	
// }

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'] = array(
    'encodeSpURL_postProc' => array('user_encodeSpURL_postProc'),
    'decodeSpURL_preProc' => array('user_decodeSpURL_preProc'));


$TYPO3_CONF_VARS['FE']['addRootLineFields'].= ',tx_realurl_pathsegment';

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(
        'pagePath' => array(
                'type' => 'user',
                'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
                'spaceCharacter' => '-',
                'languageGetVar' => 'L',
                'expireDays' => '3',
                'firstHitPathCache'=>1,
				'rootpage_id' => '36'
        ),
        'init' => array(
                'enableCHashCache' => TRUE,
                'respectSimulateStaticURLs' => 0,
                'appendMissingSlash' => 'ifNotFile',
                'enableUrlDecodeCache' => TRUE,
                'enableUrlEncodeCache' => TRUE,
                'emptyUrlReturnValue' => \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
        ),
        'preVars' => array(
                array(
                        'GETvar' => 'L',
                        'valueMap' => array(
                                'de' => '1',
                        ),
                        'noMatch' => 'bypass',
                ),
                array(
                        'GETvar' => 'no_cache',
                        'valueMap' => array(
                                'nc' => 1,
                        ),
                        'noMatch' => 'bypass',
                ),
        ),
        'fixedPostVars' => array(
        ),
        'fileName' => array (
            'index' => array(
                '_DEFAULT' => array(
                    'keyValues' => array(
                    )
                ),
                'sitemap.xml' => array(
                    'keyValues' => array(
                        'type' => 1234,
                    ),
                ),
            ),
            'defaultToHTMLsuffixOnPrev' => '',
        ),
        'postVarSets' => array(
                '_DEFAULT' => array(
                 
									 'browse' => array( 
                                                       array( 'GETvar' => 'tx_ttnews[pointer]', 'valueMap' => array('weiter' => '1','weiter' => '2',)),),
 
 
                                      // news kategorien
 
                                      'kategorie' => array ( 
                                                      array( 'GETvar' => 'tx_ttnews[cat]', 'lookUpTable' => array('table' => 'tt_news_cat', 'id_field' => 'uid', 'alias_field' => 'title', 'addWhereClause' => ' AND NOT deleted', 'useUniqueCache' => 1, 'useUniqueCache_conf' => array( 'strtolower' => 1, 'spaceCharacter' => '-',    ),),),),
                                           
 
                                      // news artikel
 
                                      'datum' => array(
                                                                           
                                              
                                              
                                              array('GETvar' => 'tx_ttnews[tt_news]','lookUpTable' => array( 'table' => 'tt_news', 'id_field' => 'uid', 'alias_field' => 'title', 'addWhereClause' => ' AND NOT deleted', 'useUniqueCache' => 1, 'useUniqueCache_conf' => array( 'strtolower' => 1, 'spaceCharacter' => '-',  ),),),),	
									  ),
        ),
);

?>