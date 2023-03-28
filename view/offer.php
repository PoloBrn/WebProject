<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once '../assets/smarty/Smarty.class.php';
include '../includes/scripts.php';

$smarty = new Smarty();

class ViewOffers
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayOne($errorMsg, $offer, $promotypes, $skills, $edit) {

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('offer', $offer);
        $this->smarty->assign('promotypes', $promotypes);
        $this->smarty->assign('skills', $skills);

        if ($edit) {
            $this->smarty->display('../view/templates/offers/oneOfferEdit.tpl');
        } else {
            $this->smarty->display('../view/templates/offers/oneOffer.tpl');
        }
    }

    function displayOffers($errorMsg, $companies, $offers, $search, $maxPage, $page, $nbByPage, $skills, $skill, $types, $type, $campuses, $wishlist){
        //display an user documents

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('offers', $offers);
        $this->smarty->assign('companies', $companies);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);
        $this->smarty->assign('skills', $skills);
        $this->smarty->assign('skill', $skill);
        $this->smarty->assign('types', $types);
        $this->smarty->assign('type', $type);
        $this->smarty->assign('campuses', $campuses);
        $this->smarty->assign('wishlist', $wishlist);

        
        $this->smarty->display('../view/templates/offers/offers.tpl');

    }
}
