<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TCA']['tx_tours_domain_model_tour'] = array(
    'ctrl' => $GLOBALS['TCA']['tx_tours_domain_model_tour']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, days_count, nights_count, departure_tstamp, leave_tstamp, price, pictures, seotitle, seodescription',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description;;;richtext:rte_transform[mode=ts_links], days_count, nights_count, departure_tstamp, leave_tstamp, price, pictures, --div--;SEO, seotitle, seodescription, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
    
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_tours_domain_model_tour',
                'foreign_table_where' => 'AND tx_tours_domain_model_tour.pid=###CURRENT_PID### AND tx_tours_domain_model_tour.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),

        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
    
        'hidden' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),

        'title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'description' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => array(
                    'RTE' => array(
                        'icon' => 'wizard_rte2.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    )
                )
            ),
        ),
        'days_count' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.days_count',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'nights_count' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.nights_count',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'departure_tstamp' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.departure_tstamp',
            'config' => array(
                'type' => 'input',
                'size' => 7,
                'eval' => 'date',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'leave_tstamp' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.leave_tstamp',
            'config' => array(
                'type' => 'input',
                'size' => 7,
                'eval' => 'date',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'price' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.price',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'pictures' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.pictures',
            'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'pictures',
                array('maxitems' => 99),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ),
        'seotitle' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'seodescription' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_tour.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => array(
                    'RTE' => array(
                        'icon' => 'wizard_rte2.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    )
                )
            ),
        ),
        
    ),
);
