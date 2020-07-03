<?php
namespace Autocars\Tours\Helpers\Location;

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
 * LocationHelper
 */
class LocationHelper
{
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
     * Returns an array that contains city with it's releted areas
     *
     * @API
     * @param  string cityIds  | The format is [ 1, 54, 3, 5 ... ]
     * @param  string allowedPlacesIds  | The format is [ 1, 54, 3, 5 ... ]
     * @return array
     */
    public function buildCitiesWithAreasByCityIds($cityIds = '', $allowedPlacesIds = '')
    {
        $cityList = array();
        
        foreach (explode(',', $cityIds) as $key => $cityID) {
            $cityList[$key]['title'] = $this->cityTitleHelper->getCityTitleByID($cityID);
            $cityList[$key]['areas'] = $this->cityAreasHelper->getAreasByCityID($cityID);
        }

        if (!empty($allowedPlacesIds)) {
            $cityList = $this->removeNotAllowedAreas($cityList, $allowedPlacesIds);
        }
        return $cityList;
    }


    /**
     * Removes not allowed places from passed cities list
     *
     * @API
     * @param  array cityList
     * @param  string allowedPlacesIds | The format is [ 1, 54, 3, 5 ... ]
     * @return array
     */
    private function removeNotAllowedAreas($cityList, $allowedPlacesIds)
    {
        $allowedAreas = $this->areaHelper->getCityTitlesByIds($allowedPlacesIds);

        foreach ($cityList  as $key => $area) {
            foreach ($area['areas']  as $areaPosition => $areaTitle) {
                if (!in_array($areaTitle, $allowedAreas)) {
                    unset($cityList[$key]['areas'][$areaPosition]);
                }
            }
        }
        return $cityList;
    }
}
