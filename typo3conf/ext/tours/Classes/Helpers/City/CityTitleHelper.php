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
 * CityHelper
 */
class CityTitleHelper
{
    /**
     * cityRepository
     *
     * @var \Autocars\Tours\Domain\Repository\CityRepository
     * @inject
     */
    protected $cityRepository;


    /**
     * Returns an array that contains titles of the cities
     *
     * @API
     * @param  string cityIds  | The format is [ 1, 54, 3, 5 ... ]
     * @return array
     */
    public function getCityTitlesByIds($cityIds)
    {
        $cityTitles = array();

        foreach (explode(',', $cityIds) as $cityID) {
            $cityTitles[] = $this->getCityTitleByID($cityID);
        }
        return $cityTitles;
    }

    /**
     * Returns city title by it's ID.
     *
     * @param int cityID
     * @return string
     */
    public function getCityTitleByID($cityID)
    {
        $cityTitle = "";
        
        if ($cityID > 0) {
            $cityTitle = $this->cityRepository->findByUid($cityID)->getTitle();
        }
        return $cityTitle;
    }
}
