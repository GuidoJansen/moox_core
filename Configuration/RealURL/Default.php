<?php
$TYPO3_CONF_VARS['FE']['addRootLineFields'].= ',tx_realurl_pathsegment';
$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(
        'pagePath' => array(
                'type' => 'user',
                'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
                'spaceCharacter' => '-',
                'languageGetVar' => 'L',
                'expireDays' => '3',
                'firstHitPathCache'=>1
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
                                'en' => '1',
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
            'defaultToHTMLsuffixOnPrev' => '.html',
        ),
        'postVarSets' => array(
                '_DEFAULT' => array(
                        'controller' => array(
                                array(
                                        'GETvar' => 'tx_mooxnews_pi1[action]',
                                        'noMatch' => 'bypass'
                                ),
                                array(
                                        'GETvar' => 'tx_mooxnews_pi1[controller]',
                                        'noMatch' => 'bypass'
                                )
                        ),
                        'dateFilter' => array(
                                array(
                                        'GETvar' => 'tx_mooxnews_pi1[overwriteDemand][year]',
                                ),
                                array(
                                        'GETvar' => 'tx_mooxnews_pi1[overwriteDemand][month]',
                                ),
                        ),
                        'archive' => array (
                                '0' => array (
                                        'GETvar' => 'tx_mooxnews_pi1[year]',
                                ),
                                '1' => array (
                                        'GETvar' => 'tx_mooxnews_pi1[month]',
                                        'valueMap' => array (
                                                'january' => '01',
                                                'february' => '02',
                                                'march' => '03',
                                                'april' => '04',
                                                'may' => '05',
                                                'june' => '06',
                                                'july' => '07',
                                                'august' => '08',
                                                'september' => '09',
                                                'october' => '10',
                                                'november' => '11',
                                                'december' => '12',
                                        ),
                                ),
                        ),
                        'browse' => array (
                                '0' => array (
                                        'GETvar' => 'tx_mooxnews_pi1[pointer]',
                                ),
                        ),
                        'select_category' => array (
                                '0' => array (
                                        'GETvar' => 'tx_mooxnews_pi1[cat]',
                                ),
                        ),
                        'article' => array (
                                '0' => array (
                                        'GETvar' => 'tx_mooxnews_pi1[news]',
                                        'lookUpTable' => array (
                                                'table' => 'tx_mooxnews_domain_model_news',
                                                'id_field' => 'uid',
                                                'alias_field' => 'title',
                                                'addWhereClause' => ' AND NOT deleted',
                                                'useUniqueCache' => '1',
                                                'useUniqueCache_conf' => array (
                                                    'strtolower' => '1',
                                                    'spaceCharacter' => '-',
                                                ),
                                        ),
                                ),
                                '1' => array (
                                        'GETvar' => 'tx_mooxnews_pi1[swords]',
                                ),
                        ),
                        'page' => array(
                                array(
                                        'GETvar' => 'tx_mooxnews_pi1[@widget_0][currentPage]',
                                ),
                        ),
                ),
        ),
);

?>