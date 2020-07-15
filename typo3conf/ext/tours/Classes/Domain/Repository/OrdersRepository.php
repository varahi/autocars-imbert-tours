<?php
namespace Autocars\Tours\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Piment Rouge <gap@pimentrouge.fr>, Piment Rouge
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
 * The repository for Orders
 */
class OrdersRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
        
        /**
         * Returns reservation
         *
         * @param int $voyageId
         * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
         */
    public function findVoyageurs($voyageId)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                    $query->logicalOr(
                                    $query->equals('from_id', $voyageId),
                                    $query->equals('to_id', $voyageId)
                                ),
                    $query->logicalAnd(
                                    $query->equals('status', 1)
                                )
                )
        );

        return $query->execute()->toArray();
    }

    /**
     * Returns orders
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findNonPayes()
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', 0)
        );
                        
        // LIMIT
                        $query->setLimit(40); // integer

                        // ORDERING
        $query->setOrderings(array("uid" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));

        return $query->execute();
    }
}
