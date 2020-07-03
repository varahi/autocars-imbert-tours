<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Autocars.' . $_EXTKEY,
    'Tourslist',
    array(
        'Tour' => 'list, show, slider, genMenu',
    ),
    // non-cacheable actions
    array(
        'Tour' => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Autocars.' . $_EXTKEY,
    'Vojage',
    array(
        //'Vojage' => 'findVojagesByLocation, edit, updateVojage',
        'Vojage' => 'create, list, findDestinations, firstReservationStep, secondReservationStep, filterByDate, 
		findDestinationByAreaDateAndArrivalCity, findAllVojages, edit, updateVojage',
        'Users' => 'new, create',
    ),
    // non-cacheable actions
    array(
        //'Vojage' => 'create, list, findDestinations, firstReservationStep, secondReservationStep, filterByDate, findDestinationByAreaDateAndArrivalCity, findAllVojages, edit, updateVojage',
        'Vojage' => 'findVojagesByLocation, edit, updateVojage',
        'Users' => 'new, create',
    )
);