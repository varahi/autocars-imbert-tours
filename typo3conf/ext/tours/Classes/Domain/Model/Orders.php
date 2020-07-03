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
 * Orders
 */
class Orders extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * fromId
     *
     * @var integer
     */
    protected $fromId = 0;
    
    /**
     * fromTime
     *
     * @var string
     */
    protected $fromTime = '';

    /**
     * fromHour
     *
     * @var string
     */
    protected $fromHour = '';

    /**
     * fromCity
     *
     * @var string
     */
    protected $fromCity = '';

    /**
     * fromOption
     *
     * @var string
     */
    protected $fromOption = '';

    /**
     * fromTime2
     *
     * @var string
     */
    protected $fromTime2 = '';

    /**
     * fromHour2
     *
     * @var string
     */
    protected $fromHour2 = '';

    /**
     * fromCity2
     *
     * @var string
     */
    protected $fromCity2 = '';
        
    /**
     * fromOption2
     *
     * @var string
     */
    protected $fromOption2 = '';

    /**
     * toId
     *
     * @var integer
     */
    protected $toId = 0;
        
    /**
     * toTime
     *
     * @var string
     */
    protected $toTime = '';

    /**
     * toHour
     *
     * @var string
     */
    protected $toHour = '';

    /**
     * toCity
     *
     * @var string
     */
    protected $toCity = '';

    /**
     * toOption
     *
     * @var string
     */
    protected $toOption = '';

    /**
     * toTime2
     *
     * @var string
     */
    protected $toTime2 = '';

    /**
     * toHour2
     *
     * @var string
     */
    protected $toHour2 = '';

    /**
     * toCity2
     *
     * @var string
     */
    protected $toCity2 = '';

    /**
     * toOption2
     *
     * @var string
     */
    protected $toOption2 = '';

    /**
     * nbAdult
     *
     * @var integer
     */
    protected $nbAdult = 0;

    /**
     * nbChildren
     *
     * @var integer
     */
    protected $nbChildren = 0;

    /**
     * nbBaby
     *
     * @var integer
     */
    protected $nbBaby = 0;

    /**
     * price
     *
     * @var string
     */
    protected $price = '';
        
    /**
     * status
     *
     * @var integer
     */
    protected $status = 0;

    /**
     * idUsers
     *
     * @var \Autocars\Tours\Domain\Model\Users
     */
    protected $idUsers = null;

    /**
     * Returns the fromId
     *
     * @return integer $fromId
     */
    public function getFromId()
    {
        return $this->fromId;
    }
        
    /**
     * Sets the fromId
     *
     * @param integer $fromId
     * @return void
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }
        
    /**
     * Returns the fromTime
     *
     * @return string $fromTime
     */
    public function getFromTime()
    {
        return $this->fromTime;
    }

    /**
     * Sets the fromTime
     *
     * @param string $fromTime
     * @return void
     */
    public function setFromTime($fromTime)
    {
        $this->fromTime = $fromTime;
    }
    /**
     * Returns the fromHour
     *
     * @return string $fromHour
     */
    public function getFromHour()
    {
        return $this->fromHour;
    }

    /**
     * Sets the fromHour
     *
     * @param string $fromHour
     * @return void
     */
    public function setFromHour($fromHour)
    {
        $this->fromHour = $fromHour;
    }
    /**
     * Returns the fromCity
     *
     * @return string $fromCity
     */
    public function getFromCity()
    {
        return $this->fromCity;
    }

    /**
     * Sets the fromCity
     *
     * @param string $fromCity
     * @return void
     */
    public function setFromCity($fromCity)
    {
        $this->fromCity = $fromCity;
    }

    /**
     * Returns the fromOption
     *
     * @return string $fromOption
     */
    public function getFromOption()
    {
        return $this->fromOption;
    }

    /**
     * Sets the fromOption
     *
     * @param string $fromOption
     * @return void
     */
    public function setFromOption($fromOption)
    {
        $this->fromOption = $fromOption;
    }
    /**
     * Returns the fromTime2
     *
     * @return string $fromTime2
     */
    public function getFromTime2()
    {
        return $this->fromTime2;
    }

    /**
     * Sets the fromTime2
     *
     * @param string $fromTime2
     * @return void
     */
    public function setFromTime2($fromTime2)
    {
        $this->fromTime2 = $fromTime2;
    }
    /**
     * Returns the fromHour2
     *
     * @return string $fromHour2
     */
    public function getFromHour2()
    {
        return $this->fromHour2;
    }

    /**
     * Sets the fromHour2
     *
     * @param string $fromHour2
     * @return void
     */
    public function setFromHour2($fromHour2)
    {
        $this->fromHour2 = $fromHour2;
    }
        
    /**
     * Returns the fromCity2
     *
     * @return string $fromCity2
     */
    public function getFromCity2()
    {
        return $this->fromCity2;
    }

    /**
     * Sets the fromCity2
     *
     * @param string $fromCity2
     * @return void
     */
    public function setFromCity2($fromCity2)
    {
        $this->fromCity2 = $fromCity2;
    }
        
    /**
     * Returns the fromOption2
     *
     * @return string $fromOption2
     */
    public function getFromOption2()
    {
        return $this->fromOption2;
    }

    /**
     * Sets the fromOption2
     *
     * @param string $fromOption2
     * @return void
     */
    public function setFromOption2($fromOption2)
    {
        $this->fromOption2 = $fromOption2;
    }
        
    /**
     * Returns the toId
     *
     * @return integer $toId
     */
    public function getToId()
    {
        return $this->toId;
    }
        
    /**
     * Sets the toId
     *
     * @param integer $toId
     * @return void
     */
    public function setToId($toId)
    {
        $this->toId = $toId;
    }
        
    /**
     * Returns the toTime
     *
     * @return string $toTime
     */
    public function getToTime()
    {
        return $this->toTime;
    }

    /**
     * Sets the toTime
     *
     * @param string $toTime
     * @return void
     */
    public function setToTime($toTime)
    {
        $this->toTime = $toTime;
    }
        
    /**
     * Returns the toHour
     *
     * @return string $toHour
     */
    public function getToHour()
    {
        return $this->toHour;
    }

    /**
     * Sets the toHour
     *
     * @param string $toHour
     * @return void
     */
    public function setToHour($toHour)
    {
        $this->toHour = $toHour;
    }
        
    /**
     * Returns the toCity
     *
     * @return string $toCity
     */
    public function getToCity()
    {
        return $this->toCity;
    }

    /**
     * Sets the toCity
     *
     * @param string $toCity
     * @return void
     */
    public function setToCity($toCity)
    {
        $this->toCity = $toCity;
    }
        
    /**
     * Returns the toOption
     *
     * @return string $toOption
     */
    public function getToOption()
    {
        return $this->toOption;
    }

    /**
     * Sets the toOption
     *
     * @param string $toOption
     * @return void
     */
    public function setToOption($toOption)
    {
        $this->toOption = $toOption;
    }
        
    /**
     * Returns the toTime2
     *
     * @return string $toTime2
     */
    public function getToTime2()
    {
        return $this->toTime2;
    }

    /**
     * Sets the toTime2
     *
     * @param string $toTime2
     * @return void
     */
    public function setToTime2($toTime2)
    {
        $this->toTime2 = $toTime2;
    }
        
    /**
     * Returns the toHour2
     *
     * @return string $toHour2
     */
    public function getToHour2()
    {
        return $this->toHour2;
    }

    /**
     * Sets the toHour2
     *
     * @param string $toHour2
     * @return void
     */
    public function setToHour2($toHour2)
    {
        $this->toHour2 = $toHour2;
    }
        
    /**
     * Returns the toCity2
     *
     * @return string $toCity2
     */
    public function getToCity2()
    {
        return $this->toCity2;
    }

    /**
     * Sets the toCity2
     *
     * @param string $toCity2
     * @return void
     */
    public function setToCity2($toCity2)
    {
        $this->toCity2 = $toCity2;
    }
        
    /**
     * Returns the toOption2
     *
     * @return string $toOption2
     */
    public function getToOption2()
    {
        return $this->toOption2;
    }

    /**
     * Sets the toOption2
     *
     * @param string $toOption2
     * @return void
     */
    public function setToOption2($toOption2)
    {
        $this->toOption2 = $toOption2;
    }
        
    /**
     * Returns the nbAdult
     *
     * @return integer $nbAdult
     */
    public function getNbAdult()
    {
        return $this->nbAdult;
    }

    /**
     * Sets the nbAdult
     *
     * @param integer $nbAdult
     * @return void
     */
    public function setNbAdult($nbAdult)
    {
        $this->nbAdult = $nbAdult;
    }
        
    /**
     * Returns the nbChildren
     *
     * @return integer $nbChildren
     */
    public function getNbChildren()
    {
        return $this->nbChildren;
    }

    /**
     * Sets the nbChildren
     *
     * @param integer $nbChildren
     * @return void
     */
    public function setNbChildren($nbChildren)
    {
        $this->nbChildren = $nbChildren;
    }
        
    /**
     * Returns the nbBaby
     *
     * @return integer $nbBaby
     */
    public function getNbBaby()
    {
        return $this->nbBaby;
    }

    /**
     * Sets the nbBaby
     *
     * @param integer $nbBaby
     * @return void
     */
    public function setNbBaby($nbBaby)
    {
        $this->nbBaby = $nbBaby;
    }
        
    /**
     * Returns the price
     *
     * @return string $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price
     *
     * @param string $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
        
    /**
     * Returns the status
     *
     * @return integer $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param integer $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
        
    /**
     * Returns the idUsers
     *
     * @return \Autocars\Tours\Domain\Model\Users $idUsers
     */
    public function getIdUsers()
    {
        return $this->idUsers;
    }

    /**
     * Sets the idUsers
     *
     * @param \Autocars\Tours\Domain\Model\Users $idUsers
     * @return void
     */
    public function setIdUsers(\Autocars\Tours\Domain\Model\Users $idUsers)
    {
        $this->idUsers = $idUsers;
    }
}
