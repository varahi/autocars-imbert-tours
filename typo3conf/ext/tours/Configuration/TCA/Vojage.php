<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TCA']['tx_tours_domain_model_vojage'] = array(
    'ctrl' => $GLOBALS['TCA']['tx_tours_domain_model_vojage']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, hidden, nb_place',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, places_max, places_reservees'),
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
                'foreign_table' => 'tx_tours_domain_model_vojage',
                'foreign_table_where' => 'AND tx_tours_domain_model_vojage.pid=###CURRENT_PID### AND tx_tours_domain_model_vojage.sys_language_uid IN (-1,0)',
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
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
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
            'exclude' => 1,
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
        'places_max' => array(
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.places_max',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,required'
            ),
        ),
        'places_reservees' => array(
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.places_reservees',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,required'
            ),
        )
    ),
);


// From  section
$fromColumns = array(
    'from_location' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.from_location',
        'config' => array(
            'type' => 'select',
            'foreign_table' => 'tx_tours_domain_model_arrivallocation',
            'minitems' => 0,
            'maxitems' => 1,
        ),
    ),
    'departure_date' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.departure_date',
        'config' => array(
            'type' => 'input',
            'size' => 10,
            'eval' => 'datetime,required',
            'checkbox' => 1,
            'default' => time()
        ),
    ),


);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_tours_domain_model_vojage', $fromColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_tours_domain_model_vojage',
    '--div--;From, from_location, departure_date'
);


// To  section
$toColumns = array(
    'to_location' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.to_location',
        'config' => array(
            'type' => 'select',
            'foreign_table' => 'tx_tours_domain_model_destinationlocation',
            'minitems' => 0,
            'maxitems' => 1,
        ),
    ),

    'arrival_date' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.arrival_date',
        'config' => array(
            'type' => 'input',
            'size' => 10,
            'eval' => 'datetime,required',
            'checkbox' => 1,
            'default' => time()
        ),
    )

);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_tours_domain_model_vojage', $toColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_tours_domain_model_vojage',
    '--div--;To, to_location, arrival_date'
);


// Pricing  section
$pricesColumns = array(
    'child_price' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.child_price',
        'config' => array(
            'type' => 'select',
            'foreign_table' => 'tx_tours_domain_model_childprice',
            'minitems' => 0,
            'maxitems' => 1,
        ),
    ),
    'adult_price' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_vojage.adult_price',
        'config' => array(
            'type' => 'select',
            'foreign_table' => 'tx_tours_domain_model_adultprice',
            'minitems' => 0,
            'maxitems' => 1,
        ),
    )
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_tours_domain_model_vojage', $pricesColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_tours_domain_model_vojage',
    '--div--;Pricing, child_price, adult_price'
);
