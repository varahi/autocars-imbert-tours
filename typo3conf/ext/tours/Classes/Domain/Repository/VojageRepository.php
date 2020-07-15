<?php
namespace Autocars\Tours\Domain\Repository;

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
 * The repository for Vojages
 */
class VojageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $defaultOrderings = array(
                'departure_date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        );
        
    /**
     * Returns  voyage
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findHiddenByUid($uid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setEnableFieldsToBeIgnored(array('disabled'));
            
        return $query
            ->matching(
                $query->equals('uid', $uid)
            )
            ->execute()
            ->getFirst();
    }
            
    /**
     * Returns  future voyages
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFutureVoyages()
    {
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThan('departureDate', time())
        );
                
        //on ignore le champ hidden (disabled dans le fichier ext_tables.php)
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setEnableFieldsToBeIgnored(array('disabled'));
                
        $query->setOrderings(array("departure_date" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
                
        /*$query->setLimit(1); // integer

        $parser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser');
$queryParts = $parser->parseQuery($query);
\TYPO3\CMS\Core\Utility\DebugUtility::debug($queryParts, 'query');
\TYPO3\CMS\Core\Utility\DebugUtility::debug(count($query->execute()), 'number of results');//*/

        return $query->execute();
    }



    /**
     * Returns  Vojages which have the passed arrival city
     *
     * @param string $from For which city we should search ?
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findArrivalByCity($from)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('fromLocation.city.title', $from)
        );
        return $query->execute();
    }



    /**
     * Returns  Vojages which have the passed arrival city
     *
     * @param string $from For which city we should search ?
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findArrivalByArea($from)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('fromLocation.title', $from)
        );
        return $query->execute();
    }


    /**
     * Returns  Vojages which have the passed destination city
     *
     * @param int $tstamp The vojade arrival date
     * @param string $to The destination ?
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findDestinationByArrivalCity($to, $area)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('fromLocation.title', $area),
                $query->equals('toLocation.city.title', $to)
            )
        );
                
        $query->setOrderings(array("arrival_date" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)); // array

        return $query->execute();
    }
}
