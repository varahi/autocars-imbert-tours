<?php
namespace Autocars\Tours\Helpers\City;

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
 * CityAreasHelper
 */
class CityAreasHelper
{
    /**
     * arrivalLocationRepository
     *
     * @var \Autocars\Tours\Domain\Repository\ArrivalLocationRepository
     * @inject
     */
    protected $arrivalLocationRepository;

    /**
     * destinationLocationRepository
     *
     * @var \Autocars\Tours\Domain\Repository\DestinationLocationRepository
     * @inject
     */
    protected $destinationLocationRepository;


    /**
     * Returns an array that contains all the areas related to passed city
     *
     * @API
     * @param  int $cityID
     * @return array
     */
    public function getAreasByCityID($cityID)
    {
        $areas = array();

        $locations = $this->arrivalLocationRepository->findByCity($cityID);
        if (empty($locations)) {
            $locations = $this->destinationLocationRepository->findByCity($cityID);
        }

        foreach ($locations as $area) {
            if ($area->getArea()->count() > 0) {
                $areas[] = $area->getArea()->current()->getTitle();
            }
        }
        return $areas;
    }
}
