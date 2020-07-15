<?php
namespace Autocars\Tours\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Messaging\AbstractMessage;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Sergey Borulko <sergey.borulko@nazomi.com>, Nazomi
 *           Vadym Girkalo <gvv100@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * VojageController
 */
class OfficeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager = null;

    protected $path_log = '/home/imbert/domains/autocars-imbert.com/public_html/typo3conf/ext/tours/Logs/';
    protected $tabZone = array(
        '1' => 'Marseille/Aix',
        '2' => 'Hautes-Alpes',
        '3' => 'Paris');
    //1 = Marseille - Aix
    //2 = Hautes-Alpes
    //3 = Paris

    protected $tabArrival = array('1' => '1', // Marseille Aéroport
        '2' => '1', // Marseille Saint Charles
        '3' => '1', // Aix-en-Pce TGV
        '4' => '2', // Les Orres
        '5' => '3', // Paris
        '6' => '2', // Le Queyras - Aiguilles
        '7' => '2', // Le Queyras - Abriès
        '8' => '2', // Le Queyras - Arvieux
        '9' => '2', // Le Queyras - Ceillac
        '10' => '2', // Le Queyras - Molines
        '11' => '2', // Le Queyras - Ristolas
        '12' => '2', // Le Queyras - Saint-Véran
        '13' => '2', // Risoul
        '14' => '2', // Vars - St Marcellin
        '15' => '2', // Crévoux
        '16' => '2', // Puy Saint Vincent
        '17' => '2', // Vars - Ste Marie
        '18' => '2', // Vars - OT les claux
        '19' => '2', //	Vars - Point Show
        '20' => '2', //	Vars - Fournet
        '21' => '2', // Serre Chevalier - Monétier
        '22' => '2', // Serre Chevalier - Villeneuve
        '23' => '2', // Serre Chevalier - Chantemerle
        '24' => '2', // Serre Chevalier - Briançon
        '25' => '2', // Montgenèvre
        '26' => '2', // L'Argentière la Bessée
        '27' => '2', // Guillestre
        '28' => '2', // Embrun
        '35' => '1', // Aix Gare Routiere
        '36' => '1', // Aix Gare TGV
        '37' => '2' // Le Queyras - Ville-Vieille
    );
    protected $tabDestination = array('1' => '2', // Les Orres
        '2' => '2', // Risoul
        '3' => '2', // Le Queyras - Abriès
        '4' => '2', // Vars - St Marcellin
        '5' => '2', // Le Queyras - Aiguilles
        '6' => '1', // Marseille Aéroport
        '7' => '1', // Marseille Saint Charles
        '8' => '3', // Paris
        '9' => '2', // Le Queyras - Arvieux
        '10' => '2', // Le Queyras - Ceillac
        '11' => '2', // Le Queyras - Molines
        '12' => '2', // Le Queyras - Ristolas
        '13' => '2', // Le Queyras - Saint-Véran
        '14' => '1', // Aix-en-Pce TGV
        '15' => '2', // Puy Saint Vincent
        '16' => '2', // Crévoux
        '17' => '2', // Vars - Ste Marie
        '18' => '2', // Vars - OT les claux
        '19' => '2', // Vars - Point Show
        '20' => '2', // Vars - Fournet
        '21' => '2', // Serre Chevalier - Monétier
        '22' => '2', // Serre Chevalier - Villeneuve
        '23' => '2', // Serre Chevalier - Chantemerle
        '24' => '2', // Serre Chevalier - Briançon
        '25' => '2', // Montgenèvre
        '26' => '2', // L'Argentière la Bessée
        '27' => '2', // Guillestre
        '28' => '2', // Embrun
        '31' => '1', // Aix Gare Routiere
        '32' => '1', // Aix Gare TGV
        '33' => '2' // Le Queyras - Ville-Vieille
    );

    /**
     * vojageRepository
     *
     * @var \Autocars\Tours\Domain\Repository\VojageRepository
     * @inject
     */
    protected $vojageRepository = null;

    /**
     * arrivalLocationRepository
     *
     * @var \Autocars\Tours\Domain\Repository\ArrivalLocationRepository
     * @inject
     */
    protected $arrivalLocationRepository = null;

    /**
     * destinationLocationRepository
     *
     * @var \Autocars\Tours\Domain\Repository\DestinationLocationRepository
     * @inject
     */
    protected $destinationLocationRepository = null;

    /**
     * cityRepository
     *
     * @var \Autocars\Tours\Domain\Repository\CityRepository
     * @inject
     */
    protected $cityRepository;

    /**
     * cityTitleHelper
     *
     * @var \Autocars\Tours\Helpers\City\CityTitleHelper
     * @inject
     */
    protected $cityTitleHelper;


    /**
     * cityAreasHelper
     *
     * @var \Autocars\Tours\Helpers\City\CityAreasHelper
     * @inject
     */
    protected $cityAreasHelper;

    /**
     * AreaHelper
     *
     * @var \Autocars\Tours\Helpers\Area\AreaHelper
     * @inject
     */
    protected $areaHelper;

    /**
     * AreaHelper
     *
     * @var \Autocars\Tours\Helpers\Location\LocationHelper
     * @inject
     */
    protected $locationHelper;

    /**
     * usersRepository
     *
     * @var \Autocars\Tours\Domain\Repository\UsersRepository
     * @inject
     */
    protected $usersRepository = null;

    /**
     * ordersRepository
     *
     * @var \Autocars\Tours\Domain\Repository\OrdersRepository
     * @inject
     */
    protected $ordersRepository = null;

    /**
     * adultPriceRepository
     *
     * @var \Autocars\Tours\Domain\Repository\AdultPriceRepository
     * @inject
     */
    protected $adultPriceRepository = null;

    /**
     * childPriceRepository
     *
     * @var \Autocars\Tours\Domain\Repository\ChildPriceRepository
     * @inject
     */
    protected $childPriceRepository = null;


    /**
     * @param \string $messageKey
     * @param \string $statusKey
     * @param \string $level
     */
    public function flashMessageService($messageKey, $statusKey, $level)
    {
        switch ($level) {
            case "NOTICE":
                $level = AbstractMessage::NOTICE;
                break;
            case "INFO":
                $level = AbstractMessage::INFO;
                break;
            case "OK":
                $level = AbstractMessage::OK;
                break;
            case "WARNING":
                $level = AbstractMessage::WARNING;
                break;
            case "ERROR":
                $level = AbstractMessage::ERROR;
                break;
        }

        $this->addFlashMessage(
            LocalizationUtility::translate($messageKey, 'tours'),
            LocalizationUtility::translate($statusKey, 'tours'),
            $level,
            true
        );
    }

    /**
     * redirect to page
     *
     * @return void
     */
    public function redirectPage($pageUid)
    {
        $uriBuilder = $this->uriBuilder;
        $uri = $uriBuilder->setTargetPageUid($pageUid)->setTargetPageType(0)->build();
        $this->redirectToURI($uri, $delay=0, $statusCode=200);
    }


    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
    }

    /**
     * Load JS Libraries and Code
     */
    protected function loadDatePickerSources()
    {

        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $extRelPath = ExtensionManagementUtility::siteRelPath('tours');
        $pageRenderer->addJsFooterFile($extRelPath . "Resources/Public/JavaScripts/datetimepicker/jquery.datetimepicker.full.js", 'text/javascript', false, false, '', true);
        $pageRenderer->addCssFile($extRelPath . "Resources/Public/Css/jquery.datetimepicker.min.css", 'stylesheet', 'all', '', true);
    }


    /**
     * action editVoyage
     *
     * @param \Autocars\Tours\Domain\Model\Vojage $voyage
     * @ignorevalidation $voyage
     *
     * @return void
     */
    public function editAction(
        \Autocars\Tours\Domain\Model\Vojage $voyage
    ) {

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($voyage);

        $this->loadDatePickerSources();

        $this->view->assign('voyage', $voyage);

        $arrivalList = $this->arrivalLocationRepository->findAll();
        $this->view->assign('arrivalList', $arrivalList);

        $destinationList = $this->destinationLocationRepository->findAll();
        $this->view->assign('destinationList', $destinationList);

        $tabZone = $this->tabZone;
        $this->view->assign('tabZone', $tabZone);

        //on récupère la zone de départ (Hautes-Alpes, Paris, Marseille)
        $departId = $this->tabArrival[$voyage->getFromLocation()->getUid()];
        $voyage->setZoneDepart($this->tabZone[$departId]);

        $arriveeId = $this->tabDestination[$voyage->getToLocation()->getUid()];
        $voyage->setZoneArrivee($this->tabZone[$arriveeId]);

        $totalPlacesReservees = $voyage->getPlacesReservees();
        $tabIdVoyage[] = $voyage->getUid();

        $voyage->setTotalPlacesReservees($totalPlacesReservees);
        $voyage->setTabIdVoyage($tabIdVoyage);

        //$fromLocation = $this->arrivalLocationRepository->findAll();
        $this->view->assign('fromLocation', $this->arrivalLocationRepository->findAll());
        $this->view->assign('toLocation', $this->destinationLocationRepository->findAll());
    }


    /**
     * Set TypeConverter option for date time
     *
     * @return void
     */
    public function initializeUpdateVojageAction()
    {
        if ($this->arguments->hasArgument('voyage')) {
            $this->arguments->getArgument('voyage')->getPropertyMappingConfiguration()->forProperty('departureDate')
                ->setTypeConverterOption(
                    'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                    'd/m/Y H:i'
                );

            $this->arguments->getArgument('voyage')->getPropertyMappingConfiguration()->forProperty('arrivalDate')
                ->setTypeConverterOption(
                    'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                    'd/m/Y H:i'
                );
        }
    }


    /**
     * action update
     *
     * @param \Autocars\Tours\Domain\Model\Vojage $voyage
     * @ignorevalidation $voyage
     *
     * @return void
     */
    public function updateVojageAction(\Autocars\Tours\Domain\Model\Vojage $voyage)
    {

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($fromList, 'fromList');
        //$totalPlacesReservees = $voyage->setTotalPlacesReservees($voyage->totalPlacesReservees);
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($voyage->getTotalPlacesReservees());
        //$voyage->setPlacesMax($voyage->getTotalPlacesReservees());

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($voyage);

        $this->vojageRepository->update($voyage);
        $this->persistenceManager->persistAll();

        $this->flashMessageService('tx_tours.voyageUdpated', 'successfullyStatus', 'OK');
        $this->redirectPage($this->settings['redirectPid']);
    }
}
