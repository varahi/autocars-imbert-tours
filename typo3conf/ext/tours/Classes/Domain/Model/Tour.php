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
 * Tour
 */
class Tour extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * daysCount
     *
     * @var string
     */
    protected $daysCount = '';

    /**
     * nightsCount
     *
     * @var string
     */
    protected $nightsCount = '';

    /**
     * departureTstamp
     *
     * @var \DateTime
     */
    protected $departureTstamp = null;

    /**
     * leaveTstamp
     *
     * @var \DateTime
     */
    protected $leaveTstamp = null;

    /**
     * price
     *
     * @var string
     */
    protected $price = '';

    /**
     * pictures
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $pictures = null;
    
    /**
     * seotitle
     *
     * @var string
     */
    protected $seotitle = '';

    /**
     * seodescription
     *
     * @var string
     */
    protected $seodescription = '';

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
        $this->pictures = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the daysCount
     *
     * @return string $daysCount
     */
    public function getDaysCount()
    {
        return $this->daysCount;
    }

    /**
     * Sets the daysCount
     *
     * @param string $daysCount
     * @return void
     */
    public function setDaysCount($daysCount)
    {
        $this->daysCount = $daysCount;
    }

    /**
     * Returns the nightsCount
     *
     * @return string $nightsCount
     */
    public function getNightsCount()
    {
        return $this->nightsCount;
    }

    /**
     * Sets the nightsCount
     *
     * @param string $nightsCount
     * @return void
     */
    public function setNightsCount($nightsCount)
    {
        $this->nightsCount = $nightsCount;
    }

    /**
     * Returns the departureTstamp
     *
     * @return \DateTime $departureTstamp
     */
    public function getDepartureTstamp()
    {
        return $this->departureTstamp;
    }

    /**
     * Sets the departureTstamp
     *
     * @param \DateTime $departureTstamp
     * @return void
     */
    public function setDepartureTstamp(\DateTime $departureTstamp)
    {
        $this->departureTstamp = $departureTstamp;
    }

    /**
     * Returns the leaveTstamp
     *
     * @return \DateTime $leaveTstamp
     */
    public function getLeaveTstamp()
    {
        return $this->leaveTstamp;
    }

    /**
     * Sets the leaveTstamp
     *
     * @param \DateTime $leaveTstamp
     * @return void
     */
    public function setLeaveTstamp(\DateTime $leaveTstamp)
    {
        $this->leaveTstamp = $leaveTstamp;
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
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $picture
     * @return void
     */
    public function addPicture(\TYPO3\CMS\Extbase\Domain\Model\FileReference $picture)
    {
        $this->pictures->attach($picture);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $pictureToRemove The FileReference to be removed
     * @return void
     */
    public function removePicture(\TYPO3\CMS\Extbase\Domain\Model\FileReference $pictureToRemove)
    {
        $this->pictures->detach($pictureToRemove);
    }

    /**
     * Returns the pictures
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $pictures
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Sets the pictures
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $pictures
     * @return void
     */
    public function setPictures(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $pictures)
    {
        $this->pictures = $pictures;
    }
    
    /**
     * Returns the seotitle
     *
     * @return string $seotitle
     */
    public function getSeotitle()
    {
        return $this->seotitle;
    }

    /**
     * Sets the seotitle
     *
     * @param string $seotitle
     * @return void
     */
    public function setSeotitle($seotitle)
    {
        $this->seotitle = $seotitle;
    }

    /**
     * Returns the seodescription
     *
     * @return string $seodescription
     */
    public function getSeodescription()
    {
        return $this->seodescription;
    }

    /**
     * Sets the seodescription
     *
     * @param string $seodescription
     * @return void
     */
    public function setSeodescription($seodescription)
    {
        $this->seodescription = $seodescription;
    }
}
