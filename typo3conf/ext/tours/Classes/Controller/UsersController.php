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
 * UsersController
 */
class UsersController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * usersRepository
     *
     * @var \Autocars\Tours\Domain\Repository\UsersRepository
     * @inject
     */
    protected $usersRepository = null;
        
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
        $users = $this->usersRepository->findAll();
        $this->view->assign('users', $users);
    }
        
    /**
     * action new
     *
     * @param \Autocars\Tours\Domain\Model\Users $newUsers
     * @ignorevalidation $newUsers
     * @return void
     */
    public function newAction(\Autocars\Tours\Domain\Model\Users $newUsers = null)
    {
        $this->view->assign('newUsers', $newUsers);
    }

    /**
     * action create
     *
     * @param \Autocars\Tours\Domain\Model\Users $newUsers
     * @return void
     */
    public function createAction(\Autocars\Tours\Domain\Model\Users $newUsers)
    {
        //		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            
        //vérification que l'adresse mail est valide
        if (!filter_var($newUsers->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $json = array('status' => 'ko', 'msg' => 'Votre adresse mail est incorrecte !');
            echo json_encode($json);
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
            $user->setAddress($newUsers->getAddress());
            $user->setZip($newUsers->getZip());
            $user->setCity($newUsers->getCity());
            $user->setTelephone($newUsers->getTelephone());
                    
            $this->usersRepository->update($user);
            unset($newUsers);
            $newUsers = $user;
        } else {
            $this->usersRepository->add($newUsers);
        }

        // on initialise la persistance afin d'avoir l'id du users
        $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
        $persistenceManager->persistAll();

        //création de la commande
        $newOrders = new \Autocars\Tours\Domain\Model\Orders();
        $newOrders->setNbAdult($this->request->getArgument('nbAdult'));
        $newOrders->setNbChildren($this->request->getArgument('nbChildren'));
        $newOrders->setNbBaby($this->request->getArgument('nbBaby'));
        $newOrders->setFromId($this->request->getArgument('fromId'));
        $newOrders->setFromTime($this->request->getArgument('fromTime'));
        $newOrders->setFromHour($this->request->getArgument('fromHour'));
        $newOrders->setFromCity($this->request->getArgument('fromCity'));
        $newOrders->setFromOption($this->request->getArgument('fromOption'));
        $newOrders->setFromTime2($this->request->getArgument('fromTime2'));
        $newOrders->setFromHour2($this->request->getArgument('fromHour2'));
        $newOrders->setFromCity2($this->request->getArgument('fromCity2'));
        $newOrders->setFromOption2($this->request->getArgument('fromOption2'));
        $newOrders->setToId($this->request->getArgument('toId'));
        $newOrders->setToTime($this->request->getArgument('toTime'));
        $newOrders->setToHour($this->request->getArgument('toHour'));
        $newOrders->setToCity($this->request->getArgument('toCity'));
        $newOrders->setToOption($this->request->getArgument('toOption'));
        $newOrders->setToTime2($this->request->getArgument('toTime2'));
        $newOrders->setToHour2($this->request->getArgument('toHour2'));
        $newOrders->setToCity2($this->request->getArgument('toCity2'));
        $newOrders->setToOption2($this->request->getArgument('toOption2'));
        $newOrders->setPrice($this->request->getArgument('price'));
        $newOrders->setIdUsers($newUsers);
                
        $this->ordersRepository->add($newOrders);

        // on réinitialise la persistance afin de faire l'insert car à la fin de la fonction on fait un exit
        $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
        $persistenceManager->persistAll();
                
        if (is_null($newUsers->getUid()) || is_null($newOrders->getUid())) {
            $json = array('status' => 'ko');
        }
        if ($GLOBALS['TSFE']->fe_user->user['usergroup']==1) { //admin
            /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj */
            $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
            $url = $cObj->typolink_URL(array('parameter' => '16', 'forceAbsoluteUrl' => 1));
                    
            $json = array('status' => 'resa', 'url' => $url);
        } else {
                    
                    //données pour le module bancaire
            // version pack 1.0f
            $params['vads_contrib']='Pack_PSP_1.0f';

            $confFile = PATH_site . 'typo3conf/ext/tours/Classes/ConfModuleBancaire.txt';
            //$conf_txt = parse_ini_file("/home/imbert/domains/autocars-imbert.com/public_html/typo3conf/ext/tours/Classes/ConfModuleBancaire.txt");
            $conf_txt = parse_ini_file($confFile);
            if ($conf_txt['vads_ctx_mode'] == "TEST") {
                $conf_txt['key'] = $conf_txt['TEST_key'];
            }
            if ($conf_txt['vads_ctx_mode'] == "PRODUCTION") {
                $conf_txt['key'] = $conf_txt['PROD_key'];
            }
            // Affichage d'une erreur si conf.txt n'est pas configuré
            $error = 'false';
            if ($conf_txt['vads_site_id'] == "11111111") {
                $error = 'true';
            }
            if ($conf_txt['vads_site_id'] == "") {
                $error = 'true';
            }
            if ($conf_txt['key'] == "2222222222222222") {
                $error = 'true';
            }
            if ($conf_txt['key'] == "3333333333333333") {
                $error = 'true';
            }
            if ($conf_txt['key'] == "") {
                $error = 'true';
            }
            //if ($conf_txt['vads_url_return'] == "") $error = 'true';
                    
            if ($error == 'true') {
                echo $json = array('status' => 'ko');
                exit;
            }

            foreach ($conf_txt as $conf_field => $conf_value) {
                $field[$conf_field] = $conf_value;
            }

            $params=array();
            foreach ($field as $nom => $valeur) {
                if (substr($nom, 0, 5) == 'vads_') {
                    $params[$nom]=$valeur;
                }
            }
            $params['vads_cust_address'] = $newUsers->getAddress();
            $params['vads_cust_city'] = $newUsers->getCity();
            $params['vads_cust_country'] = 'FR';
            $params['vads_cust_email'] = $newUsers->getEmail();
            $params['vads_cust_id'] = $newUsers->getUid();
            $params['vads_cust_name'] = $newUsers->getFirstName().' '.$newUsers->getLastName();
            $params['vads_cust_phone'] = $newUsers->getTelephone();
            $params['vads_cust_zip'] = $newUsers->getZip();
            $params['vads_order_id'] = $newOrders->getUid();
            $params['vads_amount'] = $newOrders->getPrice()*100;

            if (isset($field['vads_trans_id'])) {
                $params['vads_trans_id'] = $field['vads_trans_id'];
            } else {
                $params['vads_trans_id'] = $this->get_Trans_id();
            }
            if (isset($field['vads_trans_date'])) {
                $params['vads_trans_date'] = $field['vads_trans_date'];
            } else {
                $params['vads_trans_date'] = gmdate("YmdHis", time());
            }
            if (isset($field['signature'])) {
                $params['signature'] = $field['signature'];
            } else {
                $params['signature'] = $this->get_Signature($params, $conf_txt['key']);
            }
                    
            $pay_form = '<input type="hidden" name="signature" value="'.$params['signature'].'" />
                            <input type="hidden" name="vads_action_mode" value="'.$params['vads_action_mode'].'" />
                            <input type="hidden" name="vads_amount" value="'.$params['vads_amount'].'" />
                            <input type="hidden" name="vads_ctx_mode" value="'.$params['vads_ctx_mode'].'" />
                            <input type="hidden" name="vads_currency" value="'.$params['vads_currency'].'" />
                            <input type="hidden" name="vads_cust_address" value="'.$params['vads_cust_address'].'" />
                            <input type="hidden" name="vads_cust_city" value="'.$params['vads_cust_city'].'" />
                            <input type="hidden" name="vads_cust_country" value="'.$params['vads_cust_country'].'" />
                            <input type="hidden" name="vads_cust_email" value="'.$params['vads_cust_email'].'" />
                            <input type="hidden" name="vads_cust_id" value="'.$params['vads_cust_id'].'" />
                            <input type="hidden" name="vads_cust_name" value="'.$params['vads_cust_name'].'" />
                            <input type="hidden" name="vads_cust_phone" value="'.$params['vads_cust_phone'].'" />
                            <input type="hidden" name="vads_cust_zip" value="'.$params['vads_cust_zip'].'" />
                            <input type="hidden" name="vads_language" value="'.$params['vads_language'].'" />
                            <input type="hidden" name="vads_order_id" value="'.$params['vads_order_id'].'" />
                            <input type="hidden" name="vads_page_action" value="'.$params['vads_page_action'].'" />
                            <input type="hidden" name="vads_payment_config" value="'.$params['vads_payment_config'].'" />
                            <input type="hidden" name="vads_redirect_error_message" value="'.$params['vads_redirect_error_message'].'" />
                            <input type="hidden" name="vads_redirect_error_timeout" value="'.$params['vads_redirect_error_timeout'].'" />
                            <input type="hidden" name="vads_redirect_success_message" value="'.$params['vads_redirect_success_message'].'" />
                            <input type="hidden" name="vads_redirect_success_timeout" value="'.$params['vads_redirect_success_timeout'].'" />
                            <input type="hidden" name="vads_return_mode" value="'.$params['vads_return_mode'].'" />
                            <input type="hidden" name="vads_site_id" value="'.$params['vads_site_id'].'" />
                            <input type="hidden" name="vads_trans_date" value="'.$params['vads_trans_date'].'" />
                            <input type="hidden" name="vads_trans_id" value="'.$params['vads_trans_id'].'" />
                            <input type="hidden" name="vads_url_cancel" value="'.$params['vads_url_cancel'].'" />
                            <input type="hidden" name="vads_url_error" value="'.$params['vads_url_error'].'" />
                            <input type="hidden" name="vads_url_refused" value="'.$params['vads_url_refused'].'" />
                            <input type="hidden" name="vads_url_success" value="'.$params['vads_url_success'].'" />
                            <input type="hidden" name="vads_version" value="'.$params['vads_version'].'" />';

            $json = array('status' => 'ok', 'pay_form' => $pay_form, 'params' => $params );
        }

        echo json_encode($json);
        exit;
    }
        
    /**
     * action edit
     *
     * @param \Autocars\Tours\Domain\Model\Users $users
     * @ignorevalidation $users
     * @return void
     */
    public function editAction(\Autocars\Tours\Domain\Model\Users $users)
    {
        $this->view->assign('users', $users);
    }
        
    /**
     * action update
     *
     * @param \Autocars\Tours\Domain\Model\Users $users
     * @return void
     */
    public function updateAction(\Autocars\Tours\Domain\Model\Users $users)
    {
        $this->usersRepository->update($users);
        $this->redirect('list');
    }
        
    /*--------------------------------------------------------------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------------
    FONCTION => Exemple de génération de trans_id basé sur un compteur.
    Trans_id est un identifiant de transaction qui doit être:
                    - unique sur une même journée
                    - compris entre 000000 et 899999
                    - de longueur 6 ( 6 caractères )
    ---------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------------------------------------------------------------------------*/

    public function get_Trans_id()
    {
        // Dans cet exemple la valeur du compteur est stocké dans un fichier count.txt,incrémenté de 1 et remis à zéro si la valeur est superieure à 899999
            // ouverture/lock
            //$filename = "/home/imbert/domains/autocars-imbert.com/public_html/typo3conf/ext/tours/Classes/count.txt";// il faut ici indiquer le chemin du fichier.
            $confFile = PATH_site . 'typo3conf/ext/tours/Classes/count.txt';
            $fp = fopen($confFile, 'r+');
        flock($fp, LOCK_EX);

        // lecture/incrémentation
            $count = (int)fread($fp, 6);    // (int) = conversion en entier.
            $count++;
        if ($count < 0 || $count > 899999) {
            $count = 0;
        }

        // on revient au début du fichier
        fseek($fp, 0);
        ftruncate($fp, 0);

        // écriture/fermeture/Fin du lock
        fwrite($fp, $count);
        flock($fp, LOCK_UN);
        fclose($fp);

        // le trans_id : on rajoute des 0 au début si nécessaire
        $trans_id = sprintf("%06d", $count);
        return($trans_id);
    }

    // -------------------------------------------------------------------------------------------------------------------

    /*--------------------------------------------------------------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------------
    FONCTION => CALCUL DE LA SIGNATURE
    ---------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------------------------------------------------------------------------*/
    public function get_Signature($field, $key)
    {
        ksort($field); // tri des paramétres par ordre alphabétique
        $contenu_signature = "";
        foreach ($field as $nom => $valeur) {
            if (substr($nom, 0, 5) == 'vads_') {
                $contenu_signature .= $valeur."+";
            }
        }
        $contenu_signature .= $key;	// On ajoute le certificat à la fin de la chaîne.
        $signature = sha1($contenu_signature);
        return($signature);
    }

    //--------------------------------------------------------------------------------------------------------------------


    /*--------------------------------------------------------------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------------
    FONCTION => CONTROLE DE LA SIGNATURE RECUE
    ---------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------------------------------------------------------------------------*/
    public function Check_Signature($field, $key)
    {
        $result='false';

        $signature=$this->get_Signature($field, $key);

        if (isset($field['signature']) && ($signature == $field['signature'])) {
            $result='true';
        }
        return ($result);
    }

    //--------------------------------------------------------------------------------------------------------------------
}
