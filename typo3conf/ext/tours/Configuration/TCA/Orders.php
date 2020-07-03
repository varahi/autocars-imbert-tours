<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TCA']['tx_tours_domain_model_orders'] = array(
    'ctrl' => $GLOBALS['TCA']['tx_tours_domain_model_orders']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, hidden, from_id, from_time, from_hour, from_city, from_option, from_time2, from_hour2, from_city2, from_option2, to_id, to_time, to_hour, to_city, to_option, to_time2, to_hour2, to_city2, to_option2, nb_adult, nb_children, nb_baby, price, status, id_users',
    ),
    'types' => array(
        // '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,from_id, from_time, from_hour, from_city, from_option, from_time2, from_hour2, from_city2, from_option2, to_id, to_time, to_hour, to_city, to_option, to_time2, to_hour2, to_city2, to_option2, nb_adult, nb_children, nb_baby, price, status, id_users'),
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,id_users, status, nb_adult, nb_children, nb_baby, price, --div--;Départ, from_id, from_time, from_hour, from_city, from_option, from_time2, from_hour2, from_city2, from_option2, --div--;Retour, to_id, to_time, to_hour, to_city, to_option, to_time2, to_hour2, to_city2, to_option2'),
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
                'foreign_table' => 'tx_tours_domain_model_orders',
                'foreign_table_where' => 'AND tx_tours_domain_model_orders.pid=###CURRENT_PID### AND tx_tours_domain_model_orders.sys_language_uid IN (-1,0)',
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
                'from_id' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_id',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_time' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_time',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_hour' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_hour',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_city' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_city',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_option' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_option',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_time2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_time2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_hour2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_hour2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_city2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_city2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'from_option2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.from_option2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_id' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_id',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_time' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_time',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_hour' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_hour',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_city' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_city',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_option' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_option',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_time2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_time2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_hour2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_hour2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_city2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_city2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'to_option2' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.to_option2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
                ),
                'nb_adult' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.nb_adult',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'nb_children' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.nb_children',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'nb_baby' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.nb_baby',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'price' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.price',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
                ),
                'status' => array(
                        'exclude' => 1,
            'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.status',
            'config' => array(
                'type' => 'check',
                'default' => 0
            ),
                ),
                'id_users' => array(
                        'exclude' => 0,
                        'label' => 'LLL:EXT:tours/Resources/Private/Language/locallang_db.xlf:tx_tours_domain_model_orders.id_users',
                        'config' => array(
                                'type' => 'select',
                                'foreign_table' => 'fe_users',
                                'minitems' => 0,
                                'maxitems' => 1,
                        ),
                ),
    ),
);
