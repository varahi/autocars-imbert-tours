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
 * ArrivalLocation
 */
class ArrivalLocation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * city
     *
     * @var \Autocars\Tours\Domain\Model\City
     */
    protected $city = null;

    /**
     * area
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Autocars\Tours\Domain\Model\Area>
     * @cascade remove
     */
    protected $area = null;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the city
     *
     * @return \Autocars\Tours\Domain\Model\City $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param \Autocars\Tours\Domain\Model\City $city
     * @return void
     */
    public function setCity(\Autocars\Tours\Domain\Model\City $city)
    {
        $this->city = $city;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->area = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Area
     *
     * @param \Autocars\Tours\Domain\Model\Area $area
     * @return void
     */
    public function addArea(\Autocars\Tours\Domain\Model\Area $area)
    {
        $this->area->attach($area);
    }

    /**
     * Removes a Area
     *
     * @param \Autocars\Tours\Domain\Model\Area $areaToRemove The Area to be removed
     * @return void
     */
    public function removeArea(\Autocars\Tours\Domain\Model\Area $areaToRemove)
    {
        $this->area->detach($areaToRemove);
    }

    /**
     * Returns the area
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Autocars\Tours\Domain\Model\Area> $area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Sets the area
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Autocars\Tours\Domain\Model\Area> $area
     * @return void
     */
    public function setArea(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $area)
    {
        $this->area = $area;
    }
}
