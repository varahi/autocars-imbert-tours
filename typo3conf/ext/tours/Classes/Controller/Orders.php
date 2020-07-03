<?php
namespace Autocars\Tours\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * OrdersController
 */
class OrdersController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * ordersRepository
     *
     * @var \Autocars\Tours\Domain\Repository\OrdersRepository
     * @inject
     */
    protected $ordersRepository = null;
        
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $users = $this->ordersRepository->findAll();
        $this->view->assign('orders', $orders);
    }
        
    /**
     * action new
     *
     * @param \Autocars\Tours\Domain\Model\Orders $newOrders
     * @ignorevalidation $newOrders
     * @return void
     */
    public function newAction(\Autocars\Tours\Domain\Model\Orders $newOrders = null)
    {
        $this->view->assign('newOrders', $newOrders);
    }

    /**
     * action create
     *
     * @param \Autocars\Tours\Domain\Model\Orders $newOrders
     * @return void
     */
    public function createAction(\Autocars\Tours\Domain\Model\Orders $newOrders)
    {
        //		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);

        if ($this->request->hasArgument('potdemiel') && $this->request->getArgument('potdemiel') != '') {
            $this->uriBuilder->setTargetPageUid(2)->setArguments(array('L' => $GLOBALS['TSFE']->sys_language_uid));
            $link = $this->uriBuilder->build();
            header("HTTP/1.0 404 Not Found");
            echo file_get_contents($link);
            //                $this->redirectToUri($link, 0, 404); //ne gère pas le header 404
            exit;
        }
                
        //vérification que l'adresse mail n'existe pas déjà
        $newUsers->setEmail(strtolower($newUsers->getEmail()));
        $user = $this->usersRepository->findOneByEmail($newUsers->getEmail());

        $newUsers->setUsername($newUsers->getEmail());

        $saltedpasswordsInstance = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance();
        $password = 'autocarsimbert123456';
        $encryptedPassword = $saltedpasswordsInstance->getHashedPassword($password);
        $newUsers->setPassword($encryptedPassword);

        if (is_object($user)) {
            $newUsers->setUid($user->getUid());
            $this->ordersRepository->update($newUsers);
        } else {
            $this->ordersRepository->add($newUsers);
        }

        // @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj
                /*$cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
                $url = $cObj->typolink_URL(array('parameter' => 17, 'forceAbsoluteUrl' => 1));*/
    }
        
    /**
     * action edit
     *
     * @param \Autocars\Tours\Domain\Model\Orders $orders
     * @ignorevalidation $orders
     * @return void
     */
    public function editAction(\Autocars\Tours\Domain\Model\Orders $orders)
    {
        $this->view->assign('orders', $orders);
    }
        
    /**
     * action update
     *
     * @param \Autocars\Tours\Domain\Model\Orders $orders
     * @return void
     */
    public function updateAction(\Autocars\Tours\Domain\Model\Orders $orders)
    {
        $this->ordersRepository->update($orders);
        $this->redirect('list');
    }
}
