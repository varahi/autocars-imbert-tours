<?php
namespace Autocars\Tours\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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
class VojageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager = null;

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

    //protected $path_log = '/home/imbert/domains/autocars-imbert.com/public_html/typo3conf/ext/tours/Logs/';
    protected $path_log = '';

    public function __construct() {
        $this->path_log = PATH_site . 'public_html/typo3conf/ext/tours/Logs/';
    }


    /**
     * action create
     *
     * @return void
     */
    public function createAction()
    {
        switch ($this->request->getArgument('fromLocation')) {

                    case '12': //départ le Queyras

                            switch ($this->request->getArgument('toLocation')) {
                                    case '7': //Queyras => Marseille

                                            //Le Queyras - Aiguilles ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    6, //Le Queyras - Aiguilles (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Aiguilles ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    6, //Le Queyras - Aiguilles (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    31, //Aix-en-Pce Gare Routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Aiguilles ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    6, //Le Queyras - Aiguilles (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Aiguilles ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    6, //Le Queyras - Aiguilles (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Abriès ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    7, //Le Queyras - Abriès (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Abriès ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    7, //Le Queyras - Abriès (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    31, //Aix-en-Pce Gare Routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Abriès ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    7, //Le Queyras - Abriès (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Abriès ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    7, //Le Queyras - Abriès (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Molines ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    10, //Le Queyras - Molines (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Molines ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    10, //Le Queyras - Molines (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Molines ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    10, //Le Queyras - Molines (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Molines ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    10, //Le Queyras - Molines (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Ristolas ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    11, //Le Queyras - Ristolas (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Ristolas ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    11, //Le Queyras - Ristolas (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    31, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Ristolas ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    11, //Le Queyras - Ristolas (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Ristolas ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    11, //Le Queyras - Ristolas (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Saint-Véran ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    12, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Saint-Véran ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    12, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Saint-Véran ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    12, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Saint-Véran ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    12, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Ville-Vieille ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    37, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Ville-Vieille ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    37, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Ville-Vieille ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    37, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Ville-Vieille ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    37, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                                
                                            //Le Queyras - Arvieux ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    8, //Le Queyras - Arvieux (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Arvieux ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    8, //Le Queyras - Arvieux (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Arvieux ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    8, //Le Queyras - Arvieux (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Arvieux ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    8, //Le Queyras - Arvieux (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Ceillac ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    9, //Le Queyras - Ceillac (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Le Queyras - Ceillac ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    9, //Le Queyras - Ceillac (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Le Queyras - Ceillac ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    9, //Le Queyras - Ceillac (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Le Queyras - Ceillac ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    9, //Le Queyras - Ceillac (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Puy Saint Vincent ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('puyAdultPrice'),
                                                    $this->request->getArgument('puyChildPrice'),
                                                    16, //Puy Saint Vincent (departure location)
                                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Puy Saint Vincent ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('puyAdultPrice'),
                                                    $this->request->getArgument('puyChildPrice'),
                                                    16, //Puy Saint Vincent (departure location)
                                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Puy Saint Vincent ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('puyAdultPrice'),
                                                    $this->request->getArgument('puyChildPrice'),
                                                    16, //Puy Saint Vincent (departure location)
                                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Puy Saint Vincent ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('puyAdultPrice'),
                                                    $this->request->getArgument('puyChildPrice'),
                                                    16, //Puy Saint Vincent (departure location)
                                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                                
                                            //L'Argentière la Bessée ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('argentiereAdultPrice'),
                                                    $this->request->getArgument('argentiereChildPrice'),
                                                    26, //L'Argentière la Bessée (departure location)
                                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //L'Argentière la Bessée ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('argentiereAdultPrice'),
                                                    $this->request->getArgument('argentiereChildPrice'),
                                                    26, //L'Argentière la Bessée (departure location)
                                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //L'Argentière la Bessée ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('argentiereAdultPrice'),
                                                    $this->request->getArgument('argentiereChildPrice'),
                                                    26, //L'Argentière la Bessée (departure location)
                                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //L'Argentière la Bessée ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('argentiereAdultPrice'),
                                                    $this->request->getArgument('argentiereChildPrice'),
                                                    26, //L'Argentière la Bessée (departure location)
                                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Risoul ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    13, //Risoul (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Risoul ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    13, //Risoul (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Risoul ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    13, //Risoul (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Risoul ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    13, //Risoul (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Vars - St Marcellin ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    14, //Vars - St Marcellin (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Vars - St Marcellin ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    14, //Vars - St Marcellin (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Vars - St Marcellin ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    14, //Vars - St Marcellin (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Vars - St Marcellin ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    14, //Vars - St Marcellin (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Vars - Ste Marie ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    17, //Vars - Ste Marie (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Vars - Ste Marie ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    17, //Vars - Ste Marie (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Vars - Ste Marie ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    17, //Vars - Ste Marie (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Vars - Ste Marie ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    17, //Vars - Ste Marie (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Vars - OT les claux ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    18, //Vars - OT les claux (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Vars - OT les claux ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    18, //Vars - OT les claux (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    31, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Vars - OT les claux ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    18, //Vars - OT les claux (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Vars - OT les claux ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    18, //Vars - OT les claux (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Vars - Point Show ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    19, //Vars - Point Show (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Vars - Point Show ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    19, //Vars - Point Show (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Vars - Point Show ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    19, //Vars - Point Show (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Vars - Point Show ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    19, //Vars - Point Show (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Vars - Fournet ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    20, //Vars - Fournet (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Vars - Fournet ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    20, //Vars - Fournet (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Vars - Fournet ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    20, //Vars - Fournet (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Vars - Fournet ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    20, //Vars - Fournet (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Les Orres ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('lesOrresAdultPrice'),
                                                    $this->request->getArgument('lesOrresChildPrice'),
                                                    4, //Les Orres (departure location)
                                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Les Orres ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('lesOrresAdultPrice'),
                                                    $this->request->getArgument('lesOrresChildPrice'),
                                                    4, //Les Orres (departure location)
                                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Les Orres ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('lesOrresAdultPrice'),
                                                    $this->request->getArgument('lesOrresChildPrice'),
                                                    4, //Les Orres (departure location)
                                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Les Orres ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('lesOrresAdultPrice'),
                                                    $this->request->getArgument('lesOrresChildPrice'),
                                                    4, //Les Orres (departure location)
                                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Crévoux ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('crevouxAdultPrice'),
                                                    $this->request->getArgument('crevouxChildPrice'),
                                                    15, //Crévoux (departure location)
                                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Crévoux ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('crevouxAdultPrice'),
                                                    $this->request->getArgument('crevouxChildPrice'),
                                                    15, //Crévoux (departure location)
                                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Crévoux ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('crevouxAdultPrice'),
                                                    $this->request->getArgument('crevouxChildPrice'),
                                                    15, //Crévoux (departure location)
                                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Crévoux ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('crevouxAdultPrice'),
                                                    $this->request->getArgument('crevouxChildPrice'),
                                                    15, //Crévoux (departure location)
                                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                                
                                            //Guillestre ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('guillestreAdultPrice'),
                                                    $this->request->getArgument('guillestreChildPrice'),
                                                    27, //Guillestre (departure location)
                                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute'),
                                                    32, //Aix-en-Pce TGV (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Guillestre ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('guillestreAdultPrice'),
                                                    $this->request->getArgument('guillestreChildPrice'),
                                                    27, //Guillestre (departure location)
                                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Guillestre ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('guillestreAdultPrice'),
                                                    $this->request->getArgument('guillestreChildPrice'),
                                                    27, //Guillestre (departure location)
                                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Guillestre ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('guillestreAdultPrice'),
                                                    $this->request->getArgument('guillestreChildPrice'),
                                                    27, //Guillestre (departure location)
                                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                                
                                            //Embrun ==> Aix-en-Pce TGV
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('embrunAdultPrice'),
                                                    $this->request->getArgument('embrunChildPrice'),
                                                    28, //Embrun (departure location)
                                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute'),
                                                    32, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute')
                                                );
                                            //Embrun ==> Aix-en-Pce Gare routière
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('embrunAdultPrice'),
                                                    $this->request->getArgument('embrunChildPrice'),
                                                    28, //Embrun (departure location)
                                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute'),
                                                    31, //Aix-en-Pce Gare routière (destination location)
                                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute')
                                                );
                                            //Embrun ==> Marseille Aéroport
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('embrunAdultPrice'),
                                                    $this->request->getArgument('embrunChildPrice'),
                                                    28, //Embrun (departure location)
                                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute'),
                                                    6, //Marseille Aéroport (destination location)
                                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute')
                                                );
                                            //Embrun ==> Marseille Saint Charles
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('embrunAdultPrice'),
                                                    $this->request->getArgument('embrunChildPrice'),
                                                    28, //Embrun (departure location)
                                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute'),
                                                    7, //Marseille Saint Charles (destination location)
                                                            $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                                
                                    break;

                                    case '8': // Queyras => Paris

                                            //Les Orres ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('lesOrresAdultPrice'),
                                                    $this->request->getArgument('lesOrresChildPrice'),
                                                    4, //Les Orres (departure location)
                                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Crévoux ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('crevouxAdultPrice'),
                                                    $this->request->getArgument('crevouxChildPrice'),
                                                    15, //Crévoux (departure location)
                                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            
                                            //Le Queyras - Aiguilles ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    6, //Le Queyras - Aiguilles (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Abriès ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    7, //Le Queyras - Abriès (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Molines ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    10, //Le Queyras - Molines (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Ristolas ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    11, //Le Queyras - Ristolas (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Saint-Véran ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    12, //Le Queyras - Saint-Véran (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Ville-Vieille ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyrasAdultPrice'),
                                                    $this->request->getArgument('queyrasChildPrice'),
                                                    37, //Le Queyras - Ville-Vieille (departure location)
                                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Arvieux ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    8, //Le Queyras - Arvieux (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Le Queyras - Ceillac ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('queyras2AdultPrice'),
                                                    $this->request->getArgument('queyras2ChildPrice'),
                                                    9, //Le Queyras - Ceillac (departure location)
                                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Risoul ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    13, //Risoul (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Vars - St Marcellin ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    14, //Vars - St Marcellin (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Vars - Ste Marie ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    17, //Vars - Ste Marie (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Vars - OT les claux ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    18, //Vars - OT les claux (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Vars - Point Show ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    19, //Vars - Point Show (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Vars - Fournet ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('varsAdultPrice'),
                                                    $this->request->getArgument('varsChildPrice'),
                                                    20, //Vars - Fournet (departure location)
                                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                                
                                            //Embrun ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('embrunAdultPrice'),
                                                    $this->request->getArgument('embrunChildPrice'),
                                                    28, //Embrun (departure location)
                                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Puy Saint Vincent ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('puyAdultPrice'),
                                                    $this->request->getArgument('puyChildPrice'),
                                                    16, //Puy Saint Vincent (departure location)
                                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Guillestre ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('guillestreAdultPrice'),
                                                    $this->request->getArgument('guillestreChildPrice'),
                                                    27, //Guillestre (departure location)
                                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //L'Argentière la Bessée ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('argentiereAdultPrice'),
                                                    $this->request->getArgument('argentiereChildPrice'),
                                                    26, //L'Argentière la Bessée (departure location)
                                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Montgenèvre ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('montgenevreAdultPrice'),
                                                    $this->request->getArgument('montgenevreChildPrice'),
                                                    25, //Montgenèvre (departure location)
                                                            $this->request->getArgument('montgenevreDate').' '.$this->request->getArgument('montgenevreHour').':'.$this->request->getArgument('montgenevreMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                            //Serre Chevalier - Briançon ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('brianconAdultPrice'),
                                                    $this->request->getArgument('brianconChildPrice'),
                                                    24, //Serre Chevalier - Briançon (departure location)
                                                            $this->request->getArgument('brianconDate').' '.$this->request->getArgument('brianconHour').':'.$this->request->getArgument('brianconMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Serre Chevalier - Chantemerle ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('chantemerleAdultPrice'),
                                                    $this->request->getArgument('chantemerleChildPrice'),
                                                    23, //Serre Chevalier - Chantemerle (departure location)
                                                            $this->request->getArgument('chantemerleDate').' '.$this->request->getArgument('chantemerleHour').':'.$this->request->getArgument('chantemerleMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Serre Chevalier - Villeneuve ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('villeneuveAdultPrice'),
                                                    $this->request->getArgument('villeneuveChildPrice'),
                                                    22, //Serre Chevalier - Villeneuve (departure location)
                                                            $this->request->getArgument('villeneuveDate').' '.$this->request->getArgument('villeneuveHour').':'.$this->request->getArgument('villeneuveMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );
                                            //Serre Chevalier - Monétier ==> Paris
                                                $this->addNewVoyage(
                                                    $this->request->getArgument('monetierAdultPrice'),
                                                    $this->request->getArgument('monetierChildPrice'),
                                                    21, //Serre Chevalier - Monétier (departure location)
                                                            $this->request->getArgument('monetierDate').' '.$this->request->getArgument('monetierHour').':'.$this->request->getArgument('monetierMinute'),
                                                    $this->request->getArgument('toLocation'),
                                                    $this->request->getArgument('toDate').' '.$this->request->getArgument('toHour').':'.$this->request->getArgument('toMinute')
                                                );

                                    break;
                            }

                    break;
                
                    case '2': //départ Marseille
                    
                            //Aix-en-Pce TGV ==> Embrun
                                $this->addNewVoyage(
                                    $this->request->getArgument('embrunAdultPrice'),
                                    $this->request->getArgument('embrunChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    28, //Embrun (destination location)
                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Embrun
                                $this->addNewVoyage(
                                    $this->request->getArgument('embrunAdultPrice'),
                                    $this->request->getArgument('embrunChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    28, //Embrun (destination location)
                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute')
                                );
                            //Marseille Aéroport ==> Embrun
                                $this->addNewVoyage(
                                    $this->request->getArgument('embrunAdultPrice'),
                                    $this->request->getArgument('embrunChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    28, //Embrun (destination location)
                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute')
                                );
                            //Marseille Saint Charles ==> Embrun
                                $this->addNewVoyage(
                                    $this->request->getArgument('embrunAdultPrice'),
                                    $this->request->getArgument('embrunChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    28, //Embrun (destination location)
                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Les Orres
                                $this->addNewVoyage(
                                    $this->request->getArgument('lesOrresAdultPrice'),
                                    $this->request->getArgument('lesOrresChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    1, //Les Orres (destination location)
                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Les Orres
                                $this->addNewVoyage(
                                    $this->request->getArgument('lesOrresAdultPrice'),
                                    $this->request->getArgument('lesOrresChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    1, //Les Orres (destination location)
                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute')
                                );
                            //Marseille Aéroport ==> Les Orres
                                $this->addNewVoyage(
                                    $this->request->getArgument('lesOrresAdultPrice'),
                                    $this->request->getArgument('lesOrresChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    1, //Les Orres (destination location)
                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute')
                                );
                            //Marseille Saint Charles ==> Les Orres
                                $this->addNewVoyage(
                                    $this->request->getArgument('lesOrresAdultPrice'),
                                    $this->request->getArgument('lesOrresChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    1, //Les Orres (destination location)
                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute')
                                );

                            //Aix-en-Pce TGV ==> Crévoux
                                $this->addNewVoyage(
                                    $this->request->getArgument('crevouxAdultPrice'),
                                    $this->request->getArgument('crevouxChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    16, //Crévoux (destination location)
                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Crévoux
                                $this->addNewVoyage(
                                    $this->request->getArgument('crevouxAdultPrice'),
                                    $this->request->getArgument('crevouxChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    16, //Crévoux (destination location)
                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute')
                                );
                            //Marseille Aéroport ==> Crévoux
                                $this->addNewVoyage(
                                    $this->request->getArgument('crevouxAdultPrice'),
                                    $this->request->getArgument('crevouxChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    16, //Crévoux (destination location)
                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute')
                                );
                            //Marseille Saint Charles ==> Crévoux
                                $this->addNewVoyage(
                                    $this->request->getArgument('crevouxAdultPrice'),
                                    $this->request->getArgument('crevouxChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    16, //Crévoux (destination location)
                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute')
                                );

                            //Aix-en-Pce TGV ==> Guillestre
                                $this->addNewVoyage(
                                    $this->request->getArgument('guillestreAdultPrice'),
                                    $this->request->getArgument('guillestreChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    27, //Guillestre (destination location)
                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Guillestre
                                $this->addNewVoyage(
                                    $this->request->getArgument('guillestreAdultPrice'),
                                    $this->request->getArgument('guillestreChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    27, //Guillestre (destination location)
                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute')
                                );
                            //Marseille Aéroport ==> Guillestre
                                $this->addNewVoyage(
                                    $this->request->getArgument('guillestreAdultPrice'),
                                    $this->request->getArgument('guillestreChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    27, //Guillestre (destination location)
                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute')
                                );
                            //Marseille Saint Charles ==> Guillestre
                                $this->addNewVoyage(
                                    $this->request->getArgument('guillestreAdultPrice'),
                                    $this->request->getArgument('guillestreChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    27, //Guillestre (destination location)
                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Vars - St Marcellin
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    4, //Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Vars - St Marcellin
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    4, //Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Aéroport ==> Vars - St Marcellin
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    4, //Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Saint Charles ==> Vars - St Marcellin
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    4, //Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Vars - Ste Marie
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    17, //Vars - Ste Marie (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Vars - Ste Marie
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    17, //Vars - Ste Marie (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Aéroport ==> Vars - Ste Marie
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    17, //Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Saint Charles ==> Vars - Ste Marie
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    17, //Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Vars - OT les claux
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    18, //Vars - OT les claux (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Vars - OT les claux
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    18, //Vars - OT les claux (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Aéroport ==> Vars - OT les claux
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    18, //Vars - OT les claux (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Saint Charles ==> Vars - OT les claux
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    18, //Vars - OT les claux (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Vars - Point Show
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    19, //Vars - Point Show (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Vars - Point Show
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    19, //Vars - Point Show (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Aéroport ==> Vars - Point Show
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    19, //Vars - Point Show (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Saint Charles ==> Vars - Point Show
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    19, //Vars - Point Show (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Vars - Fournet
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    20, //Vars - Fournet (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Vars - Fournet
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    20, //Vars - Fournet (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Aéroport ==> Vars - Fournet
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    20, //Vars - Fournet (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Saint Charles ==> Vars - Fournet
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    20, //Vars - Fournet (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );

                            //Aix-en-Pce TGV ==> Risoul
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    2, //Risoul (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Risoul
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    2, //Risoul (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Aéroport ==> Risoul
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    2, //Risoul (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                            //Marseille Saint Charles ==> Risoul
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    2, //Risoul (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );

                            //Aix-en-Pce TGV ==> L'Argentière la Bessée
                                $this->addNewVoyage(
                                    $this->request->getArgument('argentiereAdultPrice'),
                                    $this->request->getArgument('argentiereChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    26, //L'Argentière la Bessée (destination location)
                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute')
                                );
                            //Aix-en-Pce Gare routière ==> L'Argentière la Bessée
                                $this->addNewVoyage(
                                    $this->request->getArgument('argentiereAdultPrice'),
                                    $this->request->getArgument('argentiereChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    26, //L'Argentière la Bessée (destination location)
                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute')
                                );
                            //Marseille Aéroport ==> L'Argentière la Bessée
                                $this->addNewVoyage(
                                    $this->request->getArgument('argentiereAdultPrice'),
                                    $this->request->getArgument('argentiereChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    26, //L'Argentière la Bessée (destination location)
                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute')
                                );
                            //Marseille Saint Charles ==> L'Argentière la Bessée
                                $this->addNewVoyage(
                                    $this->request->getArgument('argentiereAdultPrice'),
                                    $this->request->getArgument('argentiereChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    26, //L'Argentière la Bessée (destination location)
                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute')
                                );

                            //Aix-en-Pce TGV ==> Le Queyras - Aiguilles
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    5, //Le Queyras - Aiguilles (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Aiguilles
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    5, //Le Queyras - Aiguilles (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Aiguilles
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    5, //Le Queyras - Aiguilles (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Aiguilles
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    5, //Le Queyras - Aiguilles (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            //Aix-en-Pce TGV ==> Le Queyras - Abriès
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    3, //Le Queyras - Abriès (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Abriès
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    3, //Le Queyras - Abriès (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Abriès
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    3, //Le Queyras - Abriès (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Abriès
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    3, //Le Queyras - Abriès (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            //Aix-en-Pce TGV ==> Le Queyras - Molines
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    11, //Le Queyras - Molines (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Molines
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    11, //Le Queyras - Molines (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Molines
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    11, //Le Queyras - Molines (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Molines
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    11, //Le Queyras - Molines (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            //Aix-en-Pce TGV ==> Le Queyras - Ristolas
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    12, //Le Queyras - Ristolas (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Ristolas
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    12, //Le Queyras - Ristolas (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Ristolas
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    12, //Le Queyras - Ristolas (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Ristolas
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    12, //Le Queyras - Ristolas (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Le Queyras - Saint-Véran
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    13, //Le Queyras - Saint-Véran (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Saint-Véran
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    13, //Le Queyras - Saint-Véran (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Saint-Véran
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    13, //Le Queyras - Saint-Véran (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Saint-Véran
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    13, //Le Queyras - Saint-Véran (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                                
                            //Aix-en-Pce TGV ==> Le Queyras - Ville-Vieille
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    33, //Le Queyras - Ville-Vieille (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Ville-Vieille
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    33, //Le Queyras - Ville-Vieille (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Ville-Vieille
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    33, //Le Queyras - Ville-Vieille (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Ville-Vieille
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    33, //Le Queyras - Ville-Vieille (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                                
                                                        
                            //Aix-en-Pce TGV ==> Le Queyras - Arvieux
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    9, //Le Queyras - Arvieux (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Arvieux
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    9, //Le Queyras - Arvieux (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Arvieux
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    9, //Le Queyras - Arvieux (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Arvieux
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    9, //Le Queyras - Arvieux (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );

                            //Aix-en-Pce TGV ==> Le Queyras - Ceillac
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    10, //Le Queyras - Ceillac (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );
                            //Aix-en-Pce Gare routière ==> Le Queyras - Ceillac
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    10, //Le Queyras - Ceillac (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );
                            //Marseille Aéroport ==> Le Queyras - Ceillac
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    10, //Le Queyras - Ceillac (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );
                            //Marseille Saint Charles ==> Le Queyras - Ceillac
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    10, //Le Queyras - Ceillac (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );

                            //Aix-en-Pce TGV ==> Puy Saint Vincent
                                $this->addNewVoyage(
                                    $this->request->getArgument('puyAdultPrice'),
                                    $this->request->getArgument('puyChildPrice'),
                                    36, //Aix-en-Pce TGV (departure location)
                                            $this->request->getArgument('aixTgvDate').' '.$this->request->getArgument('aixTgvHour').':'.$this->request->getArgument('aixTgvMinute'),
                                    15, //Puy Saint Vincent (destination location)
                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute')
                                );
                            //Aix-en-Pce Gare routière ==> Puy Saint Vincent
                                $this->addNewVoyage(
                                    $this->request->getArgument('puyAdultPrice'),
                                    $this->request->getArgument('puyChildPrice'),
                                    35, //Aix-en-Pce Gare routière (departure location)
                                            $this->request->getArgument('aixVilleDate').' '.$this->request->getArgument('aixVilleHour').':'.$this->request->getArgument('aixVilleMinute'),
                                    15, //Puy Saint Vincent (destination location)
                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute')
                                );
                            //Marseille Aéroport ==> Puy Saint Vincent
                                $this->addNewVoyage(
                                    $this->request->getArgument('puyAdultPrice'),
                                    $this->request->getArgument('puyChildPrice'),
                                    1, //Marseille Aéroport (departure location)
                                            $this->request->getArgument('marseilleAeroportDate').' '.$this->request->getArgument('marseilleAeroportHour').':'.$this->request->getArgument('marseilleAeroportMinute'),
                                    15, //Puy Saint Vincent (destination location)
                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute')
                                );
                            //Marseille Saint Charles ==> Puy Saint Vincent
                                $this->addNewVoyage(
                                    $this->request->getArgument('puyAdultPrice'),
                                    $this->request->getArgument('puyChildPrice'),
                                    2, //Marseille Saint Charles (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    15, //Puy Saint Vincent (destination location)
                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute')
                                );

                    break;

                    case '5': //départ Paris

                            // Paris ==> Serre Chevalier - Monétier
                                $this->addNewVoyage(
                                    $this->request->getArgument('monetierAdultPrice'),
                                    $this->request->getArgument('monetierChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    21, // Serre Chevalier - Monétier (destination location)
                                            $this->request->getArgument('monetierDate').' '.$this->request->getArgument('monetierHour').':'.$this->request->getArgument('monetierMinute')
                                );

                            // Paris ==> Serre Chevalier - Villeneuve
                                $this->addNewVoyage(
                                    $this->request->getArgument('villeneuveAdultPrice'),
                                    $this->request->getArgument('villeneuveChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    22, // Serre Chevalier - Villeneuve (destination location)
                                            $this->request->getArgument('villeneuveDate').' '.$this->request->getArgument('villeneuveHour').':'.$this->request->getArgument('villeneuveMinute')
                                );

                            // Paris ==> Serre Chevalier - Chantemerle
                                $this->addNewVoyage(
                                    $this->request->getArgument('chantemerleAdultPrice'),
                                    $this->request->getArgument('chantemerleChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    23, // Serre Chevalier - Chantemerle (destination location)
                                            $this->request->getArgument('chantemerleDate').' '.$this->request->getArgument('chantemerleHour').':'.$this->request->getArgument('chantemerleMinute')
                                );

                            // Paris ==> Serre Chevalier - Briançon
                                $this->addNewVoyage(
                                    $this->request->getArgument('brianconAdultPrice'),
                                    $this->request->getArgument('brianconChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    24, // Serre Chevalier - Briançon (destination location)
                                            $this->request->getArgument('brianconDate').' '.$this->request->getArgument('brianconHour').':'.$this->request->getArgument('brianconMinute')
                                );

                            // Paris ==> Montgenèvre
                                $this->addNewVoyage(
                                    $this->request->getArgument('montgenevreAdultPrice'),
                                    $this->request->getArgument('montgenevreChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    25, // Montgenèvre (destination location)
                                            $this->request->getArgument('montgenevreDate').' '.$this->request->getArgument('montgenevreHour').':'.$this->request->getArgument('montgenevreMinute')
                                );
                                
                            // Paris ==> L'Argentière la Bessée
                                $this->addNewVoyage(
                                    $this->request->getArgument('argentiereAdultPrice'),
                                    $this->request->getArgument('argentiereChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    26, // L'Argentière la Bessée (destination location)
                                            $this->request->getArgument('argentiereDate').' '.$this->request->getArgument('argentiereHour').':'.$this->request->getArgument('argentiereMinute')
                                );
                            
                            // Paris ==> Puy Saint Vincent
                                $this->addNewVoyage(
                                    $this->request->getArgument('puyAdultPrice'),
                                    $this->request->getArgument('puyChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    15, // Puy Saint Vincent (destination location)
                                            $this->request->getArgument('puyDate').' '.$this->request->getArgument('puyHour').':'.$this->request->getArgument('puyMinute')
                                );
                            
                            // Paris ==> Guillestre
                                $this->addNewVoyage(
                                    $this->request->getArgument('guillestreAdultPrice'),
                                    $this->request->getArgument('guillestreChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    27, // Guillestre (destination location)
                                            $this->request->getArgument('guillestreDate').' '.$this->request->getArgument('guillestreHour').':'.$this->request->getArgument('guillestreMinute')
                                );
                                
                            // Paris ==> Vars - St Marcellin
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    4, // Vars - St Marcellin (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            // Paris ==> Vars - Ste Marie
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    17, // Vars - Ste Marie (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            // Paris ==> Vars - OT les claux
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    18, // Vars - OT les claux (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            // Paris ==> Vars - Point Show
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    19, // Vars - Point Show (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );
                                
                            // Paris ==> Vars - Fournet
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    20, // Vars - Fournet (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );

                            // Paris ==> Risoul
                                $this->addNewVoyage(
                                    $this->request->getArgument('varsAdultPrice'),
                                    $this->request->getArgument('varsChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    2, // Risoul (destination location)
                                            $this->request->getArgument('varsDate').' '.$this->request->getArgument('varsHour').':'.$this->request->getArgument('varsMinute')
                                );

                            // Paris ==> Embrun
                                $this->addNewVoyage(
                                    $this->request->getArgument('embrunAdultPrice'),
                                    $this->request->getArgument('embrunChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    28, // Embrun (destination location)
                                            $this->request->getArgument('embrunDate').' '.$this->request->getArgument('embrunHour').':'.$this->request->getArgument('embrunMinute')
                                );

                            // Paris ==> Le Queyras - Aiguilles
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    5, // Le Queyras - Aiguilles (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            // Paris ==> Le Queyras - Abriès
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    3, // Le Queyras - Abriès (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            // Paris ==> Le Queyras - Molines
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    11, // Le Queyras - Molines (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            // Paris ==> Le Queyras - Ristolas
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    12, // Le Queyras - Ristolas (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            // Paris ==> Le Queyras - Saint-Véran
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    13, // Le Queyras - Saint-Véran (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );

                            // Paris ==> Le Queyras - Ville-Vieille
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyrasAdultPrice'),
                                    $this->request->getArgument('queyrasChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    33, // Le Queyras - Ville-Vieille (destination location)
                                            $this->request->getArgument('queyrasDate').' '.$this->request->getArgument('queyrasHour').':'.$this->request->getArgument('queyrasMinute')
                                );
                                
                            // Paris ==> Le Queyras - Arvieux
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    9, // Le Queyras - Arvieux (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );

                            // Paris ==> Le Queyras - Ceillac
                                $this->addNewVoyage(
                                    $this->request->getArgument('queyras2AdultPrice'),
                                    $this->request->getArgument('queyras2ChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    10, // Le Queyras - Ceillac (destination location)
                                            $this->request->getArgument('queyras2Date').' '.$this->request->getArgument('queyras2Hour').':'.$this->request->getArgument('queyras2Minute')
                                );

                            // Paris ==> Les Orres
                                $this->addNewVoyage(
                                    $this->request->getArgument('lesOrresAdultPrice'),
                                    $this->request->getArgument('lesOrresChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    1, //Les Orres (destination location)
                                            $this->request->getArgument('lesOrresDate').' '.$this->request->getArgument('lesOrresHour').':'.$this->request->getArgument('lesOrresMinute')
                                );

                            // Paris ==> Crévoux
                                $this->addNewVoyage(
                                    $this->request->getArgument('crevouxAdultPrice'),
                                    $this->request->getArgument('crevouxChildPrice'),
                                    5, //Paris (departure location)
                                            $this->request->getArgument('fromDate').' '.$this->request->getArgument('fromHour').':'.$this->request->getArgument('fromMinute'),
                                    16, //Crévoux (destination location)
                                            $this->request->getArgument('crevouxDate').' '.$this->request->getArgument('crevouxHour').':'.$this->request->getArgument('crevouxMinute')
                                );
                                
                    break;

            }
            
        $this->redirect('middleOffice');
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        //$vojages = $this->vojageRepository->findAll();
        $fromList = $toList = array();


        // /** @var \Autocars\Tours\Domain\Model\Vojage $vojage */
        // foreach( $vojages as $vojage ) {
        //     $fromList[] = $vojage->getFromLocation()->getCity()->getTitle();
        //     $toList[]   = $vojage->getToLocation()->getCity()->getTitle();
        // }
        // $fromList = array_unique($fromList);
        // $toList   = array_unique($toList);

        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($uri, 'htmlParser');
      
        $fromLabel = $data['settings.fromLabel'];
        $toLabel = $data['settings.toLabel'];
        $actionButtonLabel = $data['settings.actionButtonLabel'];
        $toLabelImages = $data['settings.toImage'];
        $nextStepPID = $data['settings.firstReservationPid'];

        // $counter = 0;
        // $activeIndex = -1 ;
        // foreach($fromList as $index => $city) {
        // 	if ( $city == GeneralUtility::_GP('list_from') ) {
        // 		$activeIndex = $counter;
        // 		break;
        // 	}
        // 	$counter++;
        // }

        $fromList = $this->locationHelper->buildCitiesWithAreasByCityIds($data['settings.departureCases'], $data['settings.allowedCityPlaces']);

        $counter = 0;
        $activeIndex = -1 ;
        foreach ($fromList as $index => $city) {
            if ($city['title'] == GeneralUtility::_GP('list_from')) {
                $activeIndex = $counter;
                break;
            }
            $counter++;
        }

        $toList = $this->locationHelper->buildCitiesWithAreasByCityIds($data['settings.destinationCases'], $data['settings.allowedCityPlaces']);
        $counter = 0;
        $activeToIndex = -1 ;
        foreach ($toList as $index => $city) {
            if ($city['title'] == GeneralUtility::_GP('list_to')) {
                $activeToIndex = $counter;
                break;
            }
            $counter++;
        }

        $useAjax = false;
        foreach (explode(",", $data['settings.ajaxOnPages']) as $pageID) {
            if ($pageID == $GLOBALS['TSFE']->id) {
                $useAjax = true;
            }
        }
     
        $this->view->assign('arrivalList', $fromList);
        $this->view->assign('destinationList', $toList);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($fromList, 'fromList');

        
        $this->view->assign('fromLabel', $fromLabel);
        $this->view->assign('toLabel', $toLabel);
        $this->view->assign('actionLabel', $actionButtonLabel);
        $this->view->assign('toLabelImage', $toLabelImages);
        $this->view->assign('nextStepPID', $nextStepPID);

        $this->view->assign('fromActive', $activeIndex);
        $this->view->assign('toActive', $activeToIndex);
        $this->view->assign('noButtonMode', $useAjax);
    }


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
    }

    /**
     * action listEvent
     *
     * @return void
     */
    public function listEventAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        //$vojages = $this->vojageRepository->findAll();
        $fromList = $toList = array();


        // /** @var \Autocars\Tours\Domain\Model\Vojage $vojage */
        // foreach( $vojages as $vojage ) {
        //     $fromList[] = $vojage->getFromLocation()->getCity()->getTitle();
        //     $toList[]   = $vojage->getToLocation()->getCity()->getTitle();
        // }
        // $fromList = array_unique($fromList);
        // $toList   = array_unique($toList);

        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($uri, 'htmlParser');
      
        $fromLabel = $data['settings.fromLabel'];
        $toLabel = $data['settings.toLabel'];
        $actionButtonLabel = $data['settings.actionButtonLabel'];
        $toLabelImages = $data['settings.toImage'];
        $nextStepPID = $data['settings.firstReservationPid'];

        // $counter = 0;
        // $activeIndex = -1 ;
        // foreach($fromList as $index => $city) {
        // 	if ( $city == GeneralUtility::_GP('list_from') ) {
        // 		$activeIndex = $counter;
        // 		break;
        // 	}
        // 	$counter++;
        // }

        $fromList = $this->locationHelper->buildCitiesWithAreasByCityIds($data['settings.departureCases'], $data['settings.allowedCityPlaces']);

        $counter = 0;
        $activeIndex = -1 ;
        foreach ($fromList as $index => $city) {
            if ($city['title'] == GeneralUtility::_GP('list_from')) {
                $activeIndex = $counter;
                break;
            }
            $counter++;
        }

        $toList = $this->locationHelper->buildCitiesWithAreasByCityIds($data['settings.destinationCases'], $data['settings.allowedCityPlaces']);
        $counter = 0;
        $activeToIndex = -1 ;
        foreach ($toList as $index => $city) {
            if ($city['title'] == GeneralUtility::_GP('list_to')) {
                $activeToIndex = $counter;
                break;
            }
            $counter++;
        }

        $useAjax = false;
        foreach (explode(",", $data['settings.ajaxOnPages']) as $pageID) {
            if ($pageID == $GLOBALS['TSFE']->id) {
                $useAjax = true;
            }
        }
     
        $this->view->assign('arrivalList', $fromList);
        $this->view->assign('destinationList', $toList);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($fromList, 'fromList');

        
        $this->view->assign('fromLabel', $fromLabel);
        $this->view->assign('toLabel', $toLabel);
        $this->view->assign('actionLabel', $actionButtonLabel);
        $this->view->assign('toLabelImage', $toLabelImages);
        $this->view->assign('nextStepPID', $nextStepPID);

        $this->view->assign('fromActive', $activeIndex);
        $this->view->assign('toActive', $activeToIndex);
        $this->view->assign('noButtonMode', $useAjax);
    }


    /**
     * action firstReservationStep
     *
     * @return void
     */
    public function firstReservationStepAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);
        $nextStepPID = $data['settings.secondReservationPid'];

//        $postVars = GeneralUtility::_GP('tx_tours_vojage')['tx_tours_vojage'];
        $postVars = GeneralUtility::_GP('tx_tours_vojage');
        $from = $postVars['from-place'];
        $to   = $postVars['to-place'];

        if (empty($from)) {
            if ($this->request->hasArgument('from')) {
                $from = $this->request->getArgument('from');
            } else {
                $from = 1; // Marseille
            }
        }
        if (empty($to)) {
            if ($this->request->hasArgument('to')) {
                $to = $this->request->getArgument('to');
            } else {
                $to = 3; // Les Orres
            }
        }

        if ($from === 'all' || $to === 'all') {
            $filtered = $this->findAllVojagesAction();
            $backWayEvents = null;
        } else {
            $_POST['list_from'] = $from;
            $_POST['list_to'] = $to;
            $filtered = $this->findVojagesByLocationAction(1, $from, $to);
            $backWayEvents = $this->findVojagesByLocationAction(1, $to, $from);
        }

        // if ($this->request->getArgument('from'))

        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($filtered, '$filtered');
        // die();

       

        // if (empty($from)) {
        //     \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(NULL, 'error');
        //     die();
        // }
      
       
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($filtered, 'to');
        // $backWayEvents = $this->findBackwayAction($to);
        

        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($cObjData, 'back');
        $currentTime = time();
        $limitTime   =  $data['settings.monthLimit'];
        
        //on vérifie si le voyage est un event afin de cacher certains champs dans le formulaire
        $event = 0;
        if ($this->request->hasArgument('event')) {
            $event = 1;
        }

        $this->view->assign('nextStepPID', $nextStepPID);
        $this->view->assign('vojages', $filtered);
        $this->view->assign('backWayEvents', $backWayEvents);
        $this->view->assign('list_from-city', $from);
        $this->view->assign('list_to-city', $to);
        $this->view->assign('event', $event);
    }

    /**
     * action secondReservationStep
     *
     * @return void
     */
    public function secondReservationStepAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);
        $backButtonLabel = $data['settings.previousButtonLabel'];
        $previousStepPID = $data['settings.fromSecondToFirstStepPID'];
                
        $this->view->assign('backButtonLabel', $backButtonLabel);
        $this->view->assign('previousStepPID', $previousStepPID);
        $this->view->assign('from', $this->request->getArgument('from'));
        $this->view->assign('to', $this->request->getArgument('to'));
        /*echo'<pre>';
        print_r($this->request->getArguments());
        echo'</pre>';//*/
        //récupération des données du voyage
        $vojage = $this->request->getArgument('tx_tours_vojage');
        $this->view->assign('nbAdult', intval($vojage['adultes']));
        $this->view->assign('nbChildren', intval($vojage['enfants']));
        $this->view->assign('nbBaby', intval($vojage['enfants-de-3']));
        $this->view->assign('fromId', $vojage['from-id']);
        $this->view->assign('fromTime', $vojage['from-time']);
        $this->view->assign('fromHour', $vojage['from-hour']);
        $this->view->assign('fromCity', $vojage['from-city']);
        $this->view->assign('fromOption', $vojage['from--option']);
        $this->view->assign('fromTime2', $vojage['from-time2']);
        $this->view->assign('fromHour2', $vojage['from-hour2']);
        $this->view->assign('fromCity2', $vojage['from-city2']);
        $this->view->assign('fromOption2', $vojage['from--option-2']);
        $this->view->assign('toId', $vojage['to-id']);
        $this->view->assign('toTime', $vojage['to-time']);
        $this->view->assign('toHour', $vojage['to-hour']);
        $this->view->assign('toCity', $vojage['to-city']);
        $this->view->assign('toOption', $vojage['to--option']);
        $this->view->assign('toTime2', $vojage['to-time2']);
        $this->view->assign('toHour2', $vojage['to-hour2']);
        $this->view->assign('toCity2', $vojage['to-city2']);
        $this->view->assign('toOption2', $vojage['to--option-2']);
        $this->view->assign('price', $vojage['price']);
                
        $newUsers = new \Autocars\Tours\Domain\Model\Users();
        $this->view->assign('newUsers', $newUsers);
                
        //vérification si c'est l'admin
        $isAdmin = 0;
        if ($GLOBALS['TSFE']->fe_user->user['usergroup']==1) {
            $isAdmin=1;
        }
        $this->view->assign('isAdmin', $isAdmin);
                
                
        //on vérifie si le voyage est un event afin de cacher certains champs dans le formulaire
        $event = 0;
        if ($this->request->hasArgument('event')) {
            $event = 1;
        }
        $this->view->assign('event', $event);
    }
        
    /**
     * action returnToShop
     *
     * @return void
     */
    public function returnToShopAction()
    {
        //validation de la commande
    }
        
    /**
     * action validOrder
     *
     * @return void
     */
    public function validOrderAction()
    {
        $this->writeLog('======================'.chr(13), $this->path_log);
        foreach ($_POST as $nom => $valeur) {
            if (substr($nom, 0, 5) == 'vads_') {
                echo "$nom = $valeur <br/>";
                $this->writeLog($nom.' = '.$valeur.chr(13), $this->path_log);
            }
        }

        // --------------------------------------------------------------------------------------
        // RENSEIGNER LA VALEUR DU CERTIFICAT
        // --------------------------------------------------------------------------------------

        $conf_txt = parse_ini_file("/home/imbert/domains/autocars-imbert.com/public_html/typo3conf/ext/tours/Classes/ConfModuleBancaire.txt");
        if ($conf_txt['vads_ctx_mode'] == "TEST") {
            $key = $conf_txt['TEST_key'];
        }
        if ($conf_txt['vads_ctx_mode'] == "PRODUCTION") {
            $key = $conf_txt['PROD_key'];
        }

        // --------------------------------------------------------------------------------------
        // CONTROLE DE LA SIGNATURE RECUE
        // --------------------------------------------------------------------------------------

        /*$this->writeLog('controle de la signature'.chr(13), $this->path_log);
        $control = $this->Check_Signature($_POST, $key);
        if($control != 'true'){
            $this->writeLog('signature invalide'.chr(13), $this->path_log);
            exit;
        }//*/
            
        $vads_order_id = $_POST['vads_order_id']?intval($_POST['vads_order_id']):intval($_GET['vads_order_id']);
            
        $this->writeLog('MAJ de la BDD'.chr(13), $this->path_log);
        if (($_POST['vads_trans_status'] == 'AUTHORISED' && $_POST['vads_result'] == '00') || ($_GET['valid'] == 1 && isset($_GET['vads_order_id']))) {
            $this->writeLog('paiement autorisé'.chr(13), $this->path_log);
            $order = $this->ordersRepository->findByUid($vads_order_id);
                    
            if (is_object($order)) {
                $this->writeLog('mise à jour de la commande'.chr(13), $this->path_log);
                $order->setStatus(1);
                $this->ordersRepository->update($order);
                        
                // on réinitialise la persistance afin de faire l'update car à la fin de la fonction on fait un exit
                $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
                $persistenceManager->persistAll();
                        
                //on envoie les mails de notifications pour la commande
                $this->sendMailCommande($order);
                        
                //vérification du nb de place pour les voyages
                if ($order->getFromId() > 0) {
                    $voyageFrom = $this->vojageRepository->findByUid($order->getFromId());
                    $placesReserveesFrom = $voyageFrom->getPlacesReservees()+$order->getNbAdult()+$order->getNbChildren()+$order->getNbBaby();

                    $voyageFrom->setPlacesReservees($placesReserveesFrom);
                    $this->vojageRepository->update($voyageFrom);

                    // on réinitialise la persistance afin de faire l'update car à la fin de la fonction on fait un exit
                    $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
                    $persistenceManager->persistAll();

                    if ($placesReserveesFrom > 45) {
                        $this->writeLog('envoi du mail à l\'admin pour le nombre de place from'.chr(13), $this->path_log);
                        $contenuHTML = 'Bonjour,<br>Le voyage (ref:'.$voyageFrom->getUid().') du '.$order->getFromTime().' de '.$order->getFromCity().' - '.$order->getFromHour().' à '.$order->getFromCity2().' - '.$order->getFromHour2().' est maintenant à '.$placesReserveesFrom.' places réservées';
                        $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', 'info@neigeexpress.com', '', '[ AUTOCARS IMBERT ] Voyage (ref:'.$voyageFrom->getUid().') - '.$placesReserveesFrom.' places réservées', $contenuHTML);
                    }
                }
                        
                //si retour
                if ($order->getToId() != '' && $order->getToId() > 0) {
                    //vérification du nb de place pour les voyages
                    $voyageTo = $this->vojageRepository->findByUid($order->getToId());
                    $placesReserveesTo = $voyageTo->getPlacesReservees()+$order->getNbAdult()+$order->getNbChildren()+$order->getNbBaby();

                    $voyageTo->setPlacesReservees($placesReserveesTo);
                    $this->vojageRepository->update($voyageTo);
                            
                    // on réinitialise la persistance afin de faire l'update car à la fin de la fonction on fait un exit
                    $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
                    $persistenceManager->persistAll();

                    if ($placesReserveesTo > 45) {
                        $this->writeLog('envoi du mail à l\'admin pour le nombre de place from'.chr(13), $this->path_log);
                        $contenuHTML = 'Bonjour,<br>Le voyage (ref:'.$voyageTo->getUid().') du '.$order->getToTime().' de '.$order->getToCity().' - '.$order->getToHour().' à '.$order->getToCity2().' - '.$order->getToHour2().' est maintenant à '.$placesReserveesTo.' places réservées';
                        $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', 'info@neigeexpress.com', '', '[ AUTOCARS IMBERT ] Voyage (ref:'.$voyageTo->getUid().') - '.$placesReserveesTo.' places réservées', $contenuHTML);
                    }
                }
                        
                // on réinitialise la persistance afin de faire l'insert car à la fin de la fonction on fait un exit
                $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
                $persistenceManager->persistAll();
            }
        } else {
            $this->writeLog('paiement non autorisé ==> '.$_POST['vads_trans_status'].chr(13), $this->path_log);
        }
            
        $this->writeLog('FIN'.chr(13), $this->path_log);
        exit;
    }
        
    /**
     * action middleOffice
     *
     * @return void
     */
    public function middleOfficeAction()
    {
        $results = $this->vojageRepository->findFutureVoyages();
                
        foreach ($results as $key => $val) {
            $tabIdVoyage = array();
                    
            //on récupère la zone de départ (Hautes-Alpes, Paris, Marseille)
            $departId = $this->tabArrival[$val->getFromLocation()->getUid()];
            $val->setZoneDepart($this->tabZone[$departId]);

            //on récupère la zone d'arrivée (Hautes-Alpes, Paris, Marseille)
            $arriveeId = $this->tabDestination[$val->getToLocation()->getUid()];
            $val->setZoneArrivee($this->tabZone[$arriveeId]);
                    
            //on récupère le nombre de passager
            $index = $val->getDepartureDate()->format('Ydm').'-'.$departId.'-'.$arriveeId;
            $totalPlacesReservees = $val->getPlacesReservees();
            if ($voyages[$index]) {
                $totalPlacesReservees = $voyages[$index]->getTotalPlacesReservees()+$val->getPlacesReservees();
                $tabIdVoyage = $voyages[$index]->getTabIdVoyage();
            }
            $tabIdVoyage[] = $val->getUid();
                    
            $val->setTotalPlacesReservees($totalPlacesReservees);
            $val->setTabIdVoyage($tabIdVoyage);
            $voyages[$index] = $val;
            /*
            if($val->getDepartureDate()->format('U') > '1450998000' && $val->getDepartureDate()->format('U') < '1451170800' && $val->getUid() == 500){
                echo'<pre>';
                print_r($val);
                echo'</pre>';
            }//*/
        }
                
        $this->view->assign('voyages', $voyages);
                
        $adultPrices = $this->adultPriceRepository->findAll();
        $this->view->assign('adultPrices', $adultPrices);
        $childPrices = $this->childPriceRepository->findAll();
        $this->view->assign('childPrices', $childPrices);
                
        $hours = array();
        for ($i=0; $i<24; $i++) {
            $hours[$i] = $i;
        }
        $minutes = array();
        for ($i=0; $i<60; $i+=5) {
            $minutes[$i] = $i;
        }
        $this->view->assign('hours', $hours);
        $this->view->assign('minutes', $minutes);
    }
        
    /**
     * action updatePlaceMax
     *
     * @return void
     */
    public function updatePlaceMaxAction()
    {
        foreach ($this->request->getArgument('idVoyage') as $key => $idVoyage) {
            $voyage = $this->vojageRepository->findOneByUid(intval($idVoyage));
            if (is_object($voyage)) {
                $voyage->setPlacesMax(intval($this->request->getArgument('placeMax')));
                $this->vojageRepository->update($voyage);

                // on réinitialise la persistance afin de faire l'update car à la fin de la fonction on fait un exit
                $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
                $persistenceManager->persistAll();
            }
        }

        $json = array('status' => 'ok');
        echo json_encode($json);
        exit;
    }
        
    /**
     * action formValideOrder
     *
     * @return void
     */
    public function formValideOrderAction()
    {
        $orders = $this->ordersRepository->findNonPayes();
        $this->view->assign('orders', $orders);
    }
        
    /**
     * action valideOrder
     *
     * @return void
     */
    public function valideOrderAction()
    {
        $order = $this->ordersRepository->findByUid(intval($this->request->getArgument('uid')));
                
        if ($order->getStatus() == 0) {
            //nb de place à reserver
            $nbPlacesReservees = $order->getNbAdult()+$order->getNbChildren()+$order->getNbBaby();

            //MAJ de la réservation
            $order->setStatus(1);
            $this->ordersRepository->update($order);

            //MAJ du voyage d'aller
            $voyageAller = $this->vojageRepository->findByUid($order->getFromId());
            $voyageAller->setPlacesReservees($voyageAller->getPlacesReservees()+$nbPlacesReservees);
            $this->vojageRepository->update($voyageAller);


            //MAJ du voyage de retour
            if ($order->getToId() > 0) {
                $voyageRetour = $this->vojageRepository->findByUid($order->getToId());
                $voyageRetour->setPlacesReservees($voyageRetour->getPlacesReservees()+$nbPlacesReservees);
                $this->vojageRepository->update($voyageRetour);
            }
                    
            //on envoie les mails de notifications pour la commande
            $this->sendMailCommande($order);
        }
                
        $this->redirect('formValideOrder');
    }
        
    /**
     * action hiddenVoyage
     *
     * @return void
     */
    public function hiddenVoyageAction()
    {
        foreach ($this->request->getArgument('idVoyage') as $key => $id) {
            $voyage = $this->vojageRepository->findByUid($id);
            $voyage->setHidden(1);
            $this->vojageRepository->update($voyage);

            // on réinitialise la persistance afin de faire le update car à la fin de la fonction on fait un exit
            $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
            $persistenceManager->persistAll();
        }

        $json = array('status' => 'ok');
        echo json_encode($json);
        exit;
    }
        
    /**
     * action showVoyage
     *
     * @return void
     */
    public function showVoyageAction()
    {
        foreach ($this->request->getArgument('idVoyage') as $key => $id) {
            $voyage = $this->vojageRepository->findHiddenByUid($id);
            $voyage->setHidden(0);
            $this->vojageRepository->update($voyage);

            // on réinitialise la persistance afin de faire le update car à la fin de la fonction on fait un exit
            $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
            $persistenceManager->persistAll();
        }

        $json = array('status' => 'ok');
        echo json_encode($json);
        exit;
    }

    /**
     * action delete
     *
     * @return void
     */
    public function deleteAction()
    {
        foreach ($this->request->getArgument('idVoyage') as $key => $id) {
            $voyage = $this->vojageRepository->findByUid($id);
            $this->vojageRepository->remove($voyage);

            // on réinitialise la persistance afin de faire le remove car à la fin de la fonction on fait un exit
            $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
            $persistenceManager->persistAll();
        }

        $json = array('status' => 'ok');
        echo json_encode($json);
        exit;
    }
        
    /**
     * action exportVoyageurs
     *
     * @return void
     */
    public function exportVoyageursAction()
    {
        /*echo'<pre>';
        print_r($this->request->getArguments());
        echo'</pre>';//*/
            
        $voyages = array();
        foreach ($this->request->getArgument('idVoyage') as $key => $idVoyage) {
            $retourOrder = $this->ordersRepository->findVoyageurs(intval($idVoyage));
            if (count($retourOrder) > 0) {
                $voyages[] = $retourOrder;
            }
        }
                
        foreach ($voyages as $key => $orders) {
            foreach ($orders as $key2 => $order) {
                if (in_array($order->getToId(), $this->request->getArgument('idVoyage'))) {
                    $voyageNameAller = $order->getToCity();
                    $voyageNameRetour = $order->getToCity2();
                    $date = $order->getFromTime();
                } else {
                    // $voyageName = $order->getFromCity().' - '.$order->getFromCity2();
                    $voyageNameAller = $order->getFromCity();
                    $voyageNameRetour = $order->getFromCity2();
                    $date = $order->getToTime();
                }
                            
                if ($key == 0) {
                    $content = $date."\n";
                    $content .= 'NOM;TEL;MAIL;REGLEMENT;ALLER;RETOUR;adulte;enfant;gratuit'."\n";
                }

                $content .= $order->getIdUsers()->getFirstName().' '.$order->getIdUsers()->getLastName().';'.$order->getIdUsers()->getTelephone().';'.$order->getIdUsers()->getEmail().';'.$order->getPrice().'euro;'.$voyageNameAller.';'.$voyageNameRetour.';'.$order->getNbAdult().';'.$order->getNbChildren().';'.$order->getNbBaby()."\n";
            }
        }

        header("Content-type: text/csv; charset=windows-1252");
        header("Content-Disposition: attachment; filename=AutocarsImbert_".date('YmdHis').".csv");
        // Disable caching
                header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                header("Pragma: no-cache");
        header("Expires: 0");

        echo utf8_decode($content);
//                echo $content;

        exit;
    }
        
        

    /**
     * action findVojagesByLocation
     *
     * @return string
     */
    public function findVojagesByLocationAction($php = 0, $from = '', $to = '')
    {
        if (strlen($from) == 0) {
            $from = GeneralUtility::_GP('from');
        } elseif (strlen($to) == 0) {
            $to = GeneralUtility::_GP('to');
        }
        
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        $currentTime = time();
        $limitTime   =  $data['settings.monthLimit'];

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'vjg.uid, vjg.departure_date, vjg.arrival_date, arrival.title AS _from, dst.title AS _to, aprice.price as adult_price, cprice.price as child_price, city.title  as _fromCity',
            'tx_tours_domain_model_vojage as vjg JOIN tx_tours_domain_model_arrivallocation AS arrival ON  arrival.uid = vjg.from_location JOIN tx_tours_domain_model_destinationlocation AS dst ON  dst.uid = vjg.to_location JOIN tx_tours_domain_model_adultprice AS aprice ON  aprice.uid = vjg.adult_price JOIN tx_tours_domain_model_childprice AS cprice ON cprice.uid = vjg.child_price JOIN tx_tours_domain_model_city AS city ON city.uid =  arrival.city  JOIN tx_tours_domain_model_city AS dCity ON  dCity.uid = dst.city',
            'vjg.deleted !=1 AND vjg.hidden!=1 AND vjg.departure_date > ' . $currentTime . ' AND city.title="' . $from . '" AND dCity.title="' . $to . '"',
            '',
            '',
            ''
        );

        $rows = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            if ($row['arrival_date'] > $limitTime &&  $limitTime > 0) {
                continue;
            }
            $rows[$row['uid']] = array('uid' => $row['uid'], 'departure_date' => $row['departure_date'], 'arrival_date' => $row['arrival_date'], 'from' => $row['_from'], 'to' => $row['_to'], 'adult_price' => $row['adult_price'], 'child_price' => $row['child_price'] );
        }

        $GLOBALS['TYPO3_DB']->sql_free_result($res);
        return $php ? $rows : json_encode($rows);
    }

    public function findAllVojagesAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        $currentTime = time();
        $limitTime   =  $data['settings.monthLimit'];

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'vjg.uid, vjg.departure_date, vjg.arrival_date, arrival.title AS _from, dst.title AS _to, aprice.price as adult_price, cprice.price as child_price, city.title  as _fromCity',
            'tx_tours_domain_model_vojage as vjg JOIN tx_tours_domain_model_arrivallocation AS arrival ON  arrival.uid = vjg.from_location JOIN tx_tours_domain_model_destinationlocation AS dst ON  dst.uid = vjg.to_location JOIN tx_tours_domain_model_adultprice AS aprice ON  aprice.uid = vjg.adult_price JOIN tx_tours_domain_model_childprice AS cprice ON cprice.uid = vjg.child_price JOIN tx_tours_domain_model_city AS city ON city.uid =  arrival.city  JOIN tx_tours_domain_model_city AS dCity ON  dCity.uid = dst.city',
            'vjg.deleted !=1 AND vjg.hidden!=1 AND vjg.departure_date > ' . $currentTime,
            '',
            '',
            ''
        );

        $rows = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            if ($row['arrival_date'] > $limitTime &&  $limitTime > 0) {
                continue;
            }
            $rows[$row['uid']] = array('uid' => $row['uid'], 'departure_date' => $row['departure_date'], 'arrival_date' => $row['arrival_date'], 'from' => $row['_from'], 'to' => $row['_to'], 'adult_price' => $row['adult_price'], 'child_price' => $row['child_price'] );
        }

        $GLOBALS['TYPO3_DB']->sql_free_result($res);
        return $rows;
    }


    /**
     * action findBackway
     *
     * @return string
     */
    public function findBackwayAction($from = '')
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        $currentTime = time();
        $limitTime   =  $data['settings.monthLimit'];

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'vjg.uid, vjg.departure_date, vjg.arrival_date, arrival.title AS _from, dst.title AS _to, aprice.price as adult_price, cprice.price as child_price, city.title  as _fromCity',
            'tx_tours_domain_model_vojage as vjg JOIN tx_tours_domain_model_arrivallocation AS arrival ON  arrival.uid = vjg.from_location JOIN tx_tours_domain_model_destinationlocation AS dst ON  dst.uid = vjg.to_location JOIN tx_tours_domain_model_adultprice AS aprice ON  aprice.uid = vjg.adult_price JOIN tx_tours_domain_model_childprice AS cprice ON cprice.uid = vjg.child_price JOIN tx_tours_domain_model_city AS city ON city.uid =  arrival.city ',
            'vjg.deleted !=1 AND vjg.hidden!=1 AND vjg.departure_date > ' . $currentTime .   ' AND city.title="' . $from . '"',
            '',
            '',
            ''
        );

        $rows = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            if ($row['arrival_date'] > $limitTime &&  $limitTime > 0) {
                continue;
            }
            $rows[$row['uid']] = array('uid' => $row['uid'], 'departure_date' => $row['departure_date'], 'arrival_date' => $row['arrival_date'], 'from' => $row['_from'], 'to' => $row['_to'], 'adult_price' => $row['adult_price'], 'child_price' => $row['child_price'] );
        }

        $GLOBALS['TYPO3_DB']->sql_free_result($res);
        return $rows;
    }


    /**
     * action findDestinations
     *
     * @return string
     */
    public function findDestinationsAction()
    {
        $from = GeneralUtility::_GP('from');
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        $currentTime = time();
        $limitTime   =  $data['settings.monthLimit'];

        
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'vjg.uid, vjg.departure_date, vjg.arrival_date, arrival.title AS _from, dst.title AS _to, aprice.price as adult_price, cprice.price as child_price, city.title  as _fromCity',
            'tx_tours_domain_model_vojage as vjg JOIN tx_tours_domain_model_arrivallocation AS arrival ON  arrival.uid = vjg.from_location JOIN tx_tours_domain_model_destinationlocation AS dst ON  dst.uid = vjg.to_location JOIN tx_tours_domain_model_adultprice AS aprice ON  aprice.uid = vjg.adult_price JOIN tx_tours_domain_model_childprice AS cprice ON cprice.uid = vjg.child_price JOIN tx_tours_domain_model_city AS city ON city.uid =  arrival.city ',
            'vjg.deleted !=1 AND vjg.hidden!=1 AND vjg.departure_date > ' . $currentTime . ' AND city.title="' . $from . '"',
            '',
            '',
            ''
        );


        $rows = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            if ($row['arrival_date'] > $limitTime &&  $limitTime > 0) {
                continue;
            }
            // $to = substr($row['_to'], strrpos($row['_to'], '-'));
            $to = $row['_to'];

            $rows[$row['uid']] = array('uid' => $row['uid'], 'departure_date' => $row['departure_date'], 'arrival_date' => $row['arrival_date'], 'from' => $row['_from'], 'to' => $to, 'adult_price' => $row['adult_price'], 'child_price' => $row['child_price'] );
        }


        foreach ($rows as $theRow) {
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                'city.title  as _toCity',
                'tx_tours_domain_model_vojage as vjg JOIN tx_tours_domain_model_destinationlocation AS dst ON  dst.uid = vjg.to_location JOIN tx_tours_domain_model_city AS city ON city.uid =  dst.city ',
                'vjg.uid = ' . $theRow['uid'],
                '',
                '',
                ''
            );
            $result = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

            $rows[$theRow['uid']]['_to'] = $result['_toCity'];
        }

        $GLOBALS['TYPO3_DB']->sql_free_result($res);
        return  json_encode($rows);
    }


    /**
     * action filterByDate
     *
     * @return array
     */
    public function filterByDateAction()
    {
        $from   = GeneralUtility::_GP('from');
        $to     = GeneralUtility::_GP('to');
        $tstamp = GeneralUtility::_GP('tstamp');

        $vojages = array();
        if ($from == 'all') {
            $vojages = $this->vojageRepository->findAll();
        } else {
            $vojages = $this->vojageRepository->findArrivalByCity($from);
        }
        
        $filtredByDateAndDestinationCityVojages = [];
        $destinationTemp = array();
        $compteur=0;
        
        if (empty($to) || $to == 'all') {
            foreach ($vojages as $vojage) {
//                if ($vojage->getArrivalDate()->format('D M d Y') == $tstamp ) {
                if ($vojage->getDepartureDate()->format('D M d Y') == $tstamp) {
                    if ($vojage->getFromLocation()->getArea()->count() > 0) {
                        $title = $vojage->getFromLocation()->getCity()->getTitle() . ' - ' . $vojage->getFromLocation()->getArea()->current()->getTitle() . ' - ' . $vojage->getDepartureDate()->format('H:i');
                        $city = $vojage->getFromLocation()->getCity()->getTitle() . ' - ' . $vojage->getFromLocation()->getArea()->current()->getTitle();
                    } else {
                        $title = $vojage->getFromLocation()->getCity()->getTitle() . ' - ' . $vojage->getDepartureDate()->format('H:i');
                        $city = $vojage->getFromLocation()->getCity()->getTitle();
                    }

                    $uid   = $vojage->getUid();

                    /*if (array_key_exists($title, $filtredByDateAndDestinationCityVojages) == FALSE ) {
                        $filtredByDateAndDestinationCityVojages[$title]['uid']   = $uid;
                        $filtredByDateAndDestinationCityVojages[$title]['area']  = '';
                        $filtredByDateAndDestinationCityVojages[$title]['time']  = $vojage->getDepartureDate()->format('Y-m-d H:i:s');
                        $filtredByDateAndDestinationCityVojages[$title]['title'] = $title;
                    }//*/
                    
                    if (!in_array($title, $destinationTemp)) {
                        $filtredByDateAndDestinationCityVojages[$compteur]['uid']   = $uid;
                        $filtredByDateAndDestinationCityVojages[$compteur]['area']  = '';
                        $filtredByDateAndDestinationCityVojages[$compteur]['city']  = $city;
                        $filtredByDateAndDestinationCityVojages[$compteur]['time']  = $vojage->getDepartureDate()->format('Y-m-d H:i:s');
                        $filtredByDateAndDestinationCityVojages[$compteur]['title'] = $title;
                        $destinationTemp[] = $title;
                        $compteur++;
                    }
                }
            }
        } else {
            foreach ($vojages as $vojage) {
                /*if ($vojage->getArrivalDate()->format('D M d Y') == $tstamp && $vojage->getToLocation()->getCity()->getTitle() == $to ) {
                    // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($vojage, 'not passed by date');
                    if ($vojage->getFromLocation()->getArea()->count() > 0 ) {
                        $title = $vojage->getFromLocation()->getArea()->current()->getTitle() . ' - ' . $vojage->getDepartureDate()->format('H:i');
                    } else {
                        $title = $vojage->getFromLocation()->getCity()->getTitle() . ' - ' . $vojage->getDepartureDate()->format('H:i');
                    }

                    $uid   = $vojage->getUid();

                    if (array_key_exists($title, $filtredByDateAndDestinationCityVojages) == FALSE ) {
                        $filtredByDateAndDestinationCityVojages[$title]['uid']   = $uid;
                        $filtredByDateAndDestinationCityVojages[$title]['area']  = '';
                        $filtredByDateAndDestinationCityVojages[$title]['time']  = $vojage->getDepartureDate()->format('Y-m-d H:i:s');
                        $filtredByDateAndDestinationCityVojages[$title]['title'] = $title;
                    }
                } else*/
                /*if($_SERVER['REMOTE_ADDR']=='176.129.0.228'){
                    //return json_encode($this->vojageRepository->findArrivalByCity($from));
                    return json_encode($vojage->getFromLocation()->getCity()->getTitle());
                }*/
                if ($vojage->getDepartureDate()->format('D M d Y') == $tstamp && $vojage->getToLocation()->getCity()->getTitle() == $to) {
                    if ($vojage->getFromLocation()->getArea()->count() > 0) {
                        $title = $vojage->getFromLocation()->getArea()->current()->getTitle() . ' - ' . $vojage->getDepartureDate()->format('H:i');
                        $city = $vojage->getFromLocation()->getArea()->current()->getTitle();
                    } else {
                        $title = $vojage->getFromLocation()->getCity()->getTitle() . ' - ' . $vojage->getDepartureDate()->format('H:i');
                        $city = $vojage->getFromLocation()->getCity()->getTitle();
                    }

                    $uid   = $vojage->getUid();

                    /*if (array_key_exists($title, $filtredByDateAndDestinationCityVojages) == FALSE ) {
                        $filtredByDateAndDestinationCityVojages[$title]['uid']   = $uid;
                        $filtredByDateAndDestinationCityVojages[$title]['area']  = '';
                        $filtredByDateAndDestinationCityVojages[$title]['time']  = $vojage->getDepartureDate()->format('Y-m-d H:i:s');
                        $filtredByDateAndDestinationCityVojages[$title]['title'] = $title;
                    }//*/
                    
                    if (!in_array($title, $destinationTemp)) {
                        $filtredByDateAndDestinationCityVojages[$compteur]['uid']   = $uid;
                        $filtredByDateAndDestinationCityVojages[$compteur]['area']  = '';
                        $filtredByDateAndDestinationCityVojages[$compteur]['city']  = $city;
                        $filtredByDateAndDestinationCityVojages[$compteur]['time']  = $vojage->getDepartureDate()->format('Y-m-d H:i:s');
                        $filtredByDateAndDestinationCityVojages[$compteur]['title'] = $title;

                        $destinationTemp[] = $title;
                        $compteur++;
                    }
                }
            }
        }
       
        /*
         if ($from === 'all') {
            usort($filtredByDateAndDestinationCityVojages, function ($a, $b) {
                 return strcmp($a["title"], $b["title"]);
            });
             // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($filtredByDateAndDestinationCityVojages, 'filtredByDateAndDestinationCityVojages');
         } else {
            usort($filtredByDateAndDestinationCityVojages, function ($a, $b) {
                $t1 = strtotime($a['time']);
                $t2 = strtotime($b['time']);
                return $t1 - $t2;
            });
         }//*/

        return json_encode($filtredByDateAndDestinationCityVojages);
    }

    /**
     * action findDestinationByAreaDateAndArrivalCity
     *
     * @return array
     */
    public function findDestinationByAreaDateAndArrivalCityAction()
    {
        $uid = GeneralUtility::_GP('uid');
        $isAll = GeneralUtility::_GP('isAll');

        if ($uid < 0) {
            return json_encode(array());
        }

        $vojage =  $this->vojageRepository->findByUid($uid);

        $date = $vojage->getDepartureDate();
        $area = $vojage->getFromLocation()->getTitle();
        $to = $vojage->getToLocation()->getCity()->getTitle();

        if ($isAll === 'true') {
            //$vojages = $this->vojageRepository->findAll();
            $vojages = $this->vojageRepository->findArrivalByArea($area);
        } else {
            $vojages = $this->vojageRepository->findDestinationByArrivalCity($to, $area);
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($isAll, '$isAll');
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($araa, 'area');

        
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($date, 'date');
        $filtred = [];
        $destinationTemp = array();
        $compteur=0;
        foreach ($vojages as $theVojage) {
            /*if($_SERVER['REMOTE_ADDR']=='62.34.254.184'){
                //return json_encode($this->vojageRepository->findArrivalByCity($from));
                return json_encode($theVojage->getDepartureDate());
            }*/
            if ($theVojage->getDepartureDate() == $date) {
                $uid   = $theVojage->getUid();

                if ($theVojage->getToLocation()->getArea()->count() > 0) {
                    // $title = $theVojage->getToLocation()->getArea()->current()->getTitle() . ' - ' . $theVojage->getDepartureDate()->format('H:i');
                    $title = $theVojage->getToLocation()->getCity()->getTitle() . ' - ' . $theVojage->getToLocation()->getArea()->current()->getTitle() . ' - ' . $theVojage->getArrivalDate()->format('H:i');
                    $city = $theVojage->getToLocation()->getCity()->getTitle() . ' - ' . $theVojage->getToLocation()->getArea()->current()->getTitle();
                } else {
                    $title = $theVojage->getToLocation()->getCity()->getTitle() . ' - ' . $theVojage->getArrivalDate()->format('H:i');
                    $city = $theVojage->getToLocation()->getCity()->getTitle();
                }

                /*if (array_key_exists($title, $filtred) == FALSE ) {
                    $filtred[$title]['uid']    = $uid;
                    $filtred[$title]['title']  = $title;
                    $filtred[$title]['child']  = $theVojage->getChildPrice()->getPrice();
                    $filtred[$title]['adult']  = $theVojage->getAdultPrice()->getPrice();
                    $filtred[$title]['tstamp'] = $theVojage->getArrivalDate()->format('Y-m-d H:i:s');
                }//*/

                /*if($_SERVER['REMOTE_ADDR']=='62.34.254.184'){
                    //return json_encode($this->vojageRepository->findArrivalByCity($from));
                    return json_encode($uid);
                }*/
                if (!in_array($title, $destinationTemp)) {
                    $filtred[$compteur]['uid']    = $uid;
                    $filtred[$compteur]['title']  = $title;
                    $filtred[$compteur]['city']  = $city;
                    $filtred[$compteur]['child']  = $theVojage->getChildPrice()->getPrice();
                    $filtred[$compteur]['adult']  = $theVojage->getAdultPrice()->getPrice();
                    $filtred[$compteur]['tstamp'] = $theVojage->getArrivalDate()->format('Y-m-d H:i:s');
                    
                    $destinationTemp[] = $title;
                    $compteur++;
                }
            }
        }

       
        /*if ($isAll === 'true') {
            usort($filtred, function ($a, $b) {
                 return strcmp($a["title"], $b["title"]);
            });
        } else {
            usort($filtred, function ($a, $b) {
                $t1 = strtotime($a['tstamp']);
                $t2 = strtotime($b['tstamp']);
                return $t1 - $t2;
            });
        }//*/


        
        return json_encode($filtred);
    }
    
    /*--------------------------------------------------------------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------------
    FONCTION => CALCUL DE LA SIGNATURE
    ---------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------------------------------------------------------------------------*/
    public function get_Signature($field, $key)
    {
        ksort($field); // tri des paramétres par ordre alphabétique
        $contenu_signature = "";
        foreach ($field as $nom => $valeur) {
            if (substr($nom, 0, 5) == 'vads_') {
                $contenu_signature .= $valeur."+";
            }
        }
        $contenu_signature .= $key;	// On ajoute le certificat à la fin de la chaîne.
        $signature = sha1($contenu_signature);
        return($signature);
    }

    //--------------------------------------------------------------------------------------------------------------------


    /*--------------------------------------------------------------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------------
    FONCTION => CONTROLE DE LA SIGNATURE RECUE
    ---------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------------------------------------------------------------------------*/
    public function Check_Signature($field, $key)
    {
        $result='false';

        $signature=$this->get_Signature($field, $key);

        if (isset($field['signature']) && ($signature == $field['signature'])) {
            $result='true';
        }
        return ($result);
    }

    //--------------------------------------------------------------------------------------------------------------------
        
    public function writeLog($string, $path_log)
    {
        $date_begin = date('Y-m-d');
        $name = 'log_'.$date_begin.'.txt';
        // fopen($path_log.$name, 'w+'); //ça ne sert plus à rien car file_put_contents le fait
        file_put_contents($path_log.$name, $string, FILE_APPEND | LOCK_EX);
    }
        
    // ---------------------------------------------------------------------
    //	Envoie un mail
    // ---------------------------------------------------------------------
    public function sendMail($emailEmetteur, $nomEmetteur, $emailDestinataire, $nomDestinataire, $sujet, $contenuHTML, $attachment='', $template='email_default.html')
    {
        $message = file_get_contents('fileadmin/templates/default/plugin_tpl/mail/'.$template);
        // $message = str_replace('%message%', $body, $message);
        $replace_array = array(
            '%message%' => $contenuHTML,
            '%ndd%' => 'http://'.$_SERVER['HTTP_HOST'].'/'
        );
        $message = strtr($message, $replace_array);
        
        //on declare l'objet mail
        $email= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        //on parametre l'emetteur
        $email->setFrom(array($emailEmetteur => $nomEmetteur));
        //on parametre le destinataire
        $email->setTo(array($emailDestinataire => $nomDestinataire));
        //on parametre le sujet de l'email
        $email->setSubject($sujet);
        
        if ($attachment != '') {
            // Create the attachment
            // * Note that you can technically leave the content-type parameter out
            $attachment = \Swift_Attachment::fromPath($attachment);

            // (optional) setting the filename
            //$attachment->setFilename('cool.jpg');

            // Attach it to the message
            $mail->attach($attachment);
        }
        //on ajoute le contenu sans preciser si c'est du texte ou de l'HTML
        $email->setBody($message, 'text/html');
        //on ajoute le contenu pour la version texte
        $email->addPart(strip_tags($message), 'text/plain');
        //on envoie l'email
        $email->send();
    }
        
    public function addNewVoyage($adultPrice, $childPrice, $fromLocation, $fromDate, $toLocation, $toDate)
    {
        $newVoyage = new \Autocars\Tours\Domain\Model\Vojage();
        $newVoyage->setAdultPrice($this->adultPriceRepository->findByUid($adultPrice));
        $newVoyage->setChildPrice($this->childPriceRepository->findByUid($childPrice));

        $newVoyage->setFromLocation($this->arrivalLocationRepository->findByUid($fromLocation));
        $departureDate = new \DateTime();
        $newVoyage->setDepartureDate($departureDate->setTimestamp(strtotime($fromDate)));

        $newVoyage->setToLocation($this->destinationLocationRepository->findByUid($toLocation));
        $arrivalDate = new \DateTime();
        $newVoyage->setArrivalDate($arrivalDate->setTimestamp(strtotime($toDate)));
            
        $this->vojageRepository->add($newVoyage);
            
        // then persist everything
        $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
        $persistenceManager->persistAll();
    }
        
    public function sendMailCommande($order)
    {
//                $this->writeLog('vérification s\'il y a un retour'.chr(13), $this->path_log);

        //calcule du prix pour l'aller
        $fromVoyage = $this->vojageRepository->findOneByUid($order->getFromId());
        $fromPrice = ($order->getNbAdult() * $fromVoyage->getAdultPrice()->getPrice()) + ($order->getNbChildren() * $fromVoyage->getChildPrice()->getPrice());

        $nbPers = intval($order->getNbAdult()) + intval($order->getNbChildren()) + intval($order->getNbBaby());
                
        $cgv = '<br><br><span style="text-decoration:underline;">Conditions générales de vente :</span>
								<ul>
									<li>Confirmation 30 h avant le trajet retour par mail : <a href="mailto:info@neigeexpress.com">info@neigeexpress.com</a> ou au téléphone (04 92 45 18 11) en précisant le lieu de prise en charge.</li>
									<li>Annulation : retenue dans tous les cas de 5 euros
										<ul>
											<li>Remboursement de 100 % (moins 5 euros) jusqu’à 7 jours avant le départ</li>
											<li>Remboursement de 50 % (moins 5 euros) de 6 à 2 jours avant le départ</li>
											<li>Pas de remboursement la veille et le jour du départ.</li>
										</ul>
									</li>
									<li>Bagages et effets personnels à l’intérieur du car : sous votre responsabilité</li>
									<li>Bagages en soute : étiquetage obligatoire, notre responsabilité est limitée à 500 euros par famille.</li>
								</ul>';

        $contenuHTML = '<span style="text-align:right">Guillestre le '.date('d/m/Y').'</span>
								<br><br><span style="text-align:center;text-decoration:underline;">TITRE DE TRANSPORT</span>
								<br><br><span style="text-decoration:underline;">DEPART LE :</span> '.$order->getFromTime().'
								<br><br><span style="text-decoration:underline;">TRAJET :</span> '.$order->getFromCity().' - '.$order->getFromHour().' à '.$order->getFromCity2().' - '.$order->getFromHour2().'
								<br><br><span style="text-decoration:underline;">NOM ET PRÉNOM :</span> '.$order->getIdUsers()->getFirstName().' '.$order->getIdUsers()->getLastName().'
								<br><br><span style="text-decoration:underline;">MAIL :</span> '.$order->getIdUsers()->getEmail().'
								<br><br><span style="text-decoration:underline;">TELEPHONE :</span> '.$order->getIdUsers()->getTelephone().'
								<br><br><span style="text-decoration:underline;">NOMBRE DE PERSONNES :</span> '.$nbPers.' ('.$order->getNbAdult().' adultes,'.$order->getNbChildren().' enfants,'.$order->getNbBaby().' bébé )
								<br><br><span style="text-decoration:underline;">RÈGLEMENT :</span> CB ('.$fromPrice.' €)
								<br><br><span style="text-align:center"><img src="https://www.autocars-imbert.com/fileadmin/templates/default/images/mail-image-content.png" /></span>
								'.$cgv;

        //envoie du mail à l'admin
//                $this->writeLog('envoi du mail à l\'admin'.chr(13), $this->path_log);
        $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', 'info@neigeexpress.com', '', '[ AUTOCARS IMBERT ] Nouvelle commande : '.$order->getUid().' ALLER', $contenuHTML, '', 'commande.html');

//                $this->writeLog('envoi du mail à nous'.chr(13), $this->path_log);
        $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', 'gap@pimentrouge.fr', '', '[ AUTOCARS IMBERT ] Nouvelle commande : '.$order->getUid().' ALLER', $contenuHTML, '', 'commande.html');

        //envoie du mail au client
//                $this->writeLog('envoi du mail au client'.chr(13), $this->path_log);
        $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', $order->getIdUsers()->getEmail(), $order->getIdUsers()->getFirstName().' '.$order->getIdUsers()->getLastName(), '[ AUTOCARS IMBERT ] Commande : '.$order->getUid().' ALLER', $contenuHTML, '', 'commande.html');
                
        //on fait un second mail s'il y a un retour pour le titre du transport sinon problème d'impression mail page par page
        if ($order->getToCity() != '') {
            //calcule du prix pour le retour
            $toVoyage = $this->vojageRepository->findOneByUid($order->getToId());
            $toPrice = ($order->getNbAdult() * $toVoyage->getAdultPrice()->getPrice()) + ($order->getNbChildren() * $toVoyage->getChildPrice()->getPrice());
                    
            $contenuHTML = '<span style="text-align:right">Guillestre le '.date('d/m/Y').'</span>
								<br><br><span style="text-align:center;text-decoration:underline;">TITRE DE TRANSPORT</span>
								<br><br><span style="text-decoration:underline;">DEPART LE :</span> '.$order->getToTime().'
								<br><br><span style="text-decoration:underline;">TRAJET :</span> '.$order->getToCity().' - '.$order->getToHour().' à '.$order->getToCity2().' - '.$order->getToHour2().'
								<br><br><span style="text-decoration:underline;">NOM ET PRÉNOM :</span> '.$order->getIdUsers()->getFirstName().' '.$order->getIdUsers()->getLastName().'
								<br><br><span style="text-decoration:underline;">MAIL :</span> '.$order->getIdUsers()->getEmail().'
								<br><br><span style="text-decoration:underline;">TELEPHONE :</span> '.$order->getIdUsers()->getTelephone().'
								<br><br><span style="text-decoration:underline;">NOMBRE DE PERSONNES :</span> '.$nbPers.' ('.$order->getNbAdult().' adultes,'.$order->getNbChildren().' enfants,'.$order->getNbBaby().' bébé )
								<br><br><span style="text-decoration:underline;">RÈGLEMENT :</span> CB ('.$toPrice.' €)
								<br><br><span style="text-align:center"><img src="https://www.autocars-imbert.com/fileadmin/templates/default/images/mail-image-content.png" /></span>
								'.$cgv;
                                
            //envoie du mail à l'admin
            //                $this->writeLog('envoi du mail à l\'admin'.chr(13), $this->path_log);
            $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', 'info@neigeexpress.com', '', '[ AUTOCARS IMBERT ] Nouvelle commande : '.$order->getUid().' RETOUR', $contenuHTML, '', 'commande.html');

            //                $this->writeLog('envoi du mail à nous'.chr(13), $this->path_log);
            $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', 'gap@pimentrouge.fr', '', '[ AUTOCARS IMBERT ] Nouvelle commande : '.$order->getUid().' RETOUR', $contenuHTML, '', 'commande.html');

            //envoie du mail au client
            //                $this->writeLog('envoi du mail au client'.chr(13), $this->path_log);
            $this->sendMail('info@neigeexpress.com', 'Autocars Imbert', $order->getIdUsers()->getEmail(), $order->getIdUsers()->getFirstName().' '.$order->getIdUsers()->getLastName(), '[ AUTOCARS IMBERT ] Commande : '.$order->getUid().' RETOUR', $contenuHTML, '', 'commande.html');
        }
    }
}
