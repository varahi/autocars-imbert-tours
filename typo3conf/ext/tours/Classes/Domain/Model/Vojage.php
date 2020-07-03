<?php
namespace Autocars\Tours\Domain\Model;

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
 * Vojage
 */
class Vojage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * departureDate
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $departureDate = null;

    /**
     * arrivalDate
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $arrivalDate = null;

    /**
     * fromLocation
     *
     * @var \Autocars\Tours\Domain\Model\ArrivalLocation
     */
    protected $fromLocation = null;

    /**
     * toLocation
     *
     * @var \Autocars\Tours\Domain\Model\DestinationLocation
     */
    protected $toLocation = null;

    /**
     * childPrice
     *
     * @var \Autocars\Tours\Domain\Model\ChildPrice
     */
    protected $childPrice = null;

    /**
     * adultPrice
     *
     * @var \Autocars\Tours\Domain\Model\AdultPrice
     */
    protected $adultPrice = null;
        
    /**
     * placesMax
     *
     * @var integer
     */
    protected $placesMax = 0;
        
    /**
     * placesReservees
     *
     * @var integer
     */
    protected $placesReservees = 0;
        
    /**
     * zoneDepart
     *
     * @var string
     */
    protected $zoneDepart = '';
        
    /**
     * zoneArrivee
     *
     * @var string
     */
    protected $zoneArrivee = '';

    /**
     * totalPlacesReservees
     *
     * @var integer
     */
    protected $totalPlacesReservees = 0;
        
    /**
     * tabIdVoyage
     *
     * @var array
     */
    protected $tabIdVoyage = array();
        
    /**
     * hidden
     *
     * @var boolean
     */
    protected $hidden = 0;

    /**
     * Returns the departureDate
     *
     * @return \DateTime $departureDate
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Sets the departureDate
     *
     * @param \DateTime $departureDate
     * @return void
     */
    public function setDepartureDate(\DateTime $departureDate)
    {
        $this->departureDate = $departureDate;
    }

    /**
     * Returns the arrivalDate
     *
     * @return \DateTime $arrivalDate
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * Sets the arrivalDate
     *
     * @param \DateTime $arrivalDate
     * @return void
     */
    public function setArrivalDate(\DateTime $arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
    }

    /**
     * Returns the fromLocation
     *
     * @return \Autocars\Tours\Domain\Model\ArrivalLocation $fromLocation
     */
    public function getFromLocation()
    {
        return $this->fromLocation;
    }

    /**
     * Sets the fromLocation
     *
     * @param \Autocars\Tours\Domain\Model\ArrivalLocation $fromLocation
     * @return void
     */
    public function setFromLocation(\Autocars\Tours\Domain\Model\ArrivalLocation $fromLocation)
    {
        $this->fromLocation = $fromLocation;
    }

    /**
     * Returns the toLocation
     *
     * @return \Autocars\Tours\Domain\Model\DestinationLocation $toLocation
     */
    public function getToLocation()
    {
        return $this->toLocation;
    }

    /**
     * Sets the toLocation
     *
     * @param \Autocars\Tours\Domain\Model\DestinationLocation $toLocation
     * @return void
     */
    public function setToLocation(\Autocars\Tours\Domain\Model\DestinationLocation $toLocation)
    {
        $this->toLocation = $toLocation;
    }

    /**
     * Returns the childPrice
     *
     * @return \Autocars\Tours\Domain\Model\ChildPrice $childPrice
     */
    public function getChildPrice()
    {
        return $this->childPrice;
    }

    /**
     * Sets the childPrice
     *
     * @param \Autocars\Tours\Domain\Model\ChildPrice $childPrice
     * @return void
     */
    public function setChildPrice(\Autocars\Tours\Domain\Model\ChildPrice $childPrice)
    {
        $this->childPrice = $childPrice;
    }

    /**
     * Returns the adultPrice
     *
     * @return \Autocars\Tours\Domain\Model\AdultPrice $adultPrice
     */
    public function getAdultPrice()
    {
        return $this->adultPrice;
    }

    /**
     * Sets the adultPrice
     *
     * @param \Autocars\Tours\Domain\Model\AdultPrice $adultPrice
     * @return void
     */
    public function setAdultPrice(\Autocars\Tours\Domain\Model\AdultPrice $adultPrice)
    {
        $this->adultPrice = $adultPrice;
    }

    /**
     * Returns the placesMax
     *
     * @return integer
     */
    public function getPlacesMax()
    {
        return $this->placesMax;
    }

    /**
     * Sets the placesMax
     *
     * @param integer
     * @return void
     */
    public function setPlacesMax($placesMax)
    {
        $this->placesMax = $placesMax;
    }

    /**
     * Returns the placesReservees
     *
     * @return integer
     */
    public function getPlacesReservees()
    {
        return $this->placesReservees;
    }

    /**
     * Sets the placesReservees
     *
     * @param integer
     * @return void
     */
    public function setPlacesReservees($placesReservees)
    {
        $this->placesReservees = $placesReservees;
    }

    /**
     * Returns the totalPlacesReservees
     *
     * @return integer
     */
    public function getTotalPlacesReservees()
    {
        return $this->totalPlacesReservees;
    }

    /**
     * Sets the totalPlacesReservees
     *
     * @param integer
     * @return void
     */
    public function setTotalPlacesReservees($totalPlacesReservees)
    {
        $this->totalPlacesReservees = $totalPlacesReservees;
    }
        
    /**
     * Returns the zoneDepart
     *
     * @return string
     */
    public function getZoneDepart()
    {
        return $this->zoneDepart;
    }

    /**
     * Sets the zoneDepart
     *
     * @param string
     * @return void
     */
    public function setZoneDepart($zoneDepart)
    {
        $this->zoneDepart = $zoneDepart;
    }
        
    /**
     * Returns the zoneArrivee
     *
     * @return string
     */
    public function getZoneArrivee()
    {
        return $this->zoneArrivee;
    }

    /**
     * Sets the zoneArrivee
     *
     * @param string
     * @return void
     */
    public function setZoneArrivee($zoneArrivee)
    {
        $this->zoneArrivee = $zoneArrivee;
    }
        
    /**
     * Returns the tabIdVoyage
     *
     * @return array
     */
    public function getTabIdVoyage()
    {
        return $this->tabIdVoyage;
    }

    /**
     * Sets the tabIdVoyage
     *
     * @param array
     * @return void
     */
    public function setTabIdVoyage($tabIdVoyage)
    {
        $this->tabIdVoyage = $tabIdVoyage;
    }
    
    /**
     * Returns the hidden
     *
     * @return boolean $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
