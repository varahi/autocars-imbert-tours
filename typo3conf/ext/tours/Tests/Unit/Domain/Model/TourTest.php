<?php

namespace Autocars\Tours\Tests\Unit\Domain\Model;

/***************************************************************
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \Autocars\Tours\Domain\Model\Tour.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Sergey Borulko <sergey.borulko@nazomi.com>
 * @author Vadym Girkalo <gvv100@gmail.com>
 */
class TourTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Autocars\Tours\Domain\Model\Tour
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new \Autocars\Tours\Domain\Model\Tour();
    }

    protected function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDaysCountReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getDaysCount()
        );
    }

    /**
     * @test
     */
    public function setDaysCountForStringSetsDaysCount()
    {
        $this->subject->setDaysCount('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'daysCount',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNightsCountReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getNightsCount()
        );
    }

    /**
     * @test
     */
    public function setNightsCountForStringSetsNightsCount()
    {
        $this->subject->setNightsCount('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'nightsCount',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDepartureTstampReturnsInitialValueForDateTime()
    {
        $this->assertEquals(
            null,
            $this->subject->getDepartureTstamp()
        );
    }

    /**
     * @test
     */
    public function setDepartureTstampForDateTimeSetsDepartureTstamp()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDepartureTstamp($dateTimeFixture);

        $this->assertAttributeEquals(
            $dateTimeFixture,
            'departureTstamp',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLeaveTstampReturnsInitialValueForDateTime()
    {
        $this->assertEquals(
            null,
            $this->subject->getLeaveTstamp()
        );
    }

    /**
     * @test
     */
    public function setLeaveTstampForDateTimeSetsLeaveTstamp()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setLeaveTstamp($dateTimeFixture);

        $this->assertAttributeEquals(
            $dateTimeFixture,
            'leaveTstamp',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceForStringSetsPrice()
    {
        $this->subject->setPrice('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'price',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPicturesReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->subject->getPictures()
        );
    }

    /**
     * @test
     */
    public function setPicturesForFileReferenceSetsPictures()
    {
        $picture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOnePictures = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOnePictures->attach($picture);
        $this->subject->setPictures($objectStorageHoldingExactlyOnePictures);

        $this->assertAttributeEquals(
            $objectStorageHoldingExactlyOnePictures,
            'pictures',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addPictureToObjectStorageHoldingPictures()
    {
        $picture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $picturesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', false);
        $picturesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($picture));
        $this->inject($this->subject, 'pictures', $picturesObjectStorageMock);

        $this->subject->addPicture($picture);
    }

    /**
     * @test
     */
    public function removePictureFromObjectStorageHoldingPictures()
    {
        $picture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $picturesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', false);
        $picturesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($picture));
        $this->inject($this->subject, 'pictures', $picturesObjectStorageMock);

        $this->subject->removePicture($picture);
    }
}
