<?php
namespace Autocars\Tours\Helpers\Area;

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
 * AreaHelper
 */
class AreaHelper
{
    /**
     * areaRepository
     *
     * @var \Autocars\Tours\Domain\Repository\AreaRepository
     * @inject
     */
    protected $areaRepository;


    /**
     * Returns an array that contains all the areas titles related to the passed IDs
     *
     * @API
     * @param  string areaIds  | The format is [ 1, 54, 3, 5 ... ]
     * @return array
     */
    public function getCityTitlesByIds($areaIds)
    {
        $areaTitles = array();

        foreach (explode(',', $areaIds) as $areaID) {
            $areaTitles[] = $this->getTitleByID($areaID);
        }
        return $areaTitles;
    }

    /**
     * Returns the title by it's ID
     *
     * @API
     * @param  int $areaID
     * @return string
     */
    public function getTitleByID($areaID)
    {
        $areaTitle = "";
        
        if ($areaID > 0) {
            $areaTitle = $this->areaRepository->findByUid($areaID)->getTitle();
        }
        return $areaTitle;
    }
}
