<?php
namespace Autocars\Tours\Controller;

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
 * TourController
 */
class TourController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * tourRepository
     *
     * @var \Autocars\Tours\Domain\Repository\TourRepository
     * @inject
     */
    protected $tourRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        $detailPageUid = $data['settings.detailPid'];
           
        $this->view->assign('detailPageUid', $detailPageUid);
        $this->view->assign('tours', $this->tourRepository->findAll());
    }

    /**
     * action genMenu
     *
     * @return void
     */
    public function genMenuAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);
        $detailPageUid = $data['settings.sliderDetailPid'];
           
        $this->view->assign('detailPageUid', $detailPageUid);

        $this->view->assign('tours', $this->tourRepository->findAll());
    }


    /**
     * action slider
     *
     * @return void
     */
    public function sliderAction()
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);
        $detailPageUid = $data['settings.sliderDetailPid'];
           
        $this->view->assign('detailPageUid', $detailPageUid);

        $this->view->assign('tours', $this->tourRepository->findAll());
    }


    /**
     * action show
     *
     * @param \Autocars\Tours\Domain\Model\Tour $tour
     * @return void
     */
    public function showAction(\Autocars\Tours\Domain\Model\Tour $tour = null)
    {
        //gestion des fiches supprimées (header 404)
        //ne pas oublier le NULL en paramètre de la fonction sinon erreur 500
        if (is_null($tour)) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('No tour entry found.');
        }
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        $formPageUid= $data['settings.detailFormPid'];
        //SEO
        // $GLOBALS['TSFE']->page['title'] = $tour->getSeotitle()?$tour->getSeotitle():$tour->getTitle();
        // $title = $tour->getSeotitle()?$tour->getSeotitle():$tour->getTitle();
        // $GLOBALS['TSFE']->page['description'] = $tour->getSeodescription()?$tour->getSeodescription():'';
        
        //on met à jour le titre de la page
        //on doit faire ce hack car le module seobasics a supprimé la génération de la balise title
        $title = $tour->getSeotitle()?$tour->getSeotitle():$tour->getTitle();
        $this->response->addAdditionalHeaderData('<title>'.$title.'</title>');

        //on met à jour la description de la page
        //on doit faire ce hack car on a paramétré TYPO3 pour utiliser une meta description par défaut
        $description = $tour->getSeodescription()?$tour->getSeodescription():'';
        $myNewMetaDescription = mb_strimwidth(trim(strip_tags($description)), 0, 500, '...');
        $metaDescription = '<meta name="description" content="' .  $myNewMetaDescription . '">';
        $this->response->addAdditionalHeaderData($metaDescription);

        $this->view->assign('demandeInformationPID', $formPageUid);
        $this->view->assign('tour', $tour);
    }
}
