<?php

require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';


class ViewPostulate
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }
    function displayOffersByUser($errorMsg, $user, $offers)
    {
        $this->smarty->assign('errorMsg', $errorMsg);



        $this->smarty->assign('offers', $offers);
        $this->smarty->assign('user', $user);

        $this->smarty->display('../view/templates/postulate/userPostulates.tpl');
    }

    function displayUsersByOffer($errorMsg, $offer, $users)
    {
        $this->smarty->assign('errorMsg', $errorMsg);



        $this->smarty->assign('offer', $offer);
        $this->smarty->assign('users', $users);

        $this->smarty->display('../view/templates/postulate/offerPostulates.tpl');
    }

    function displayCandid($errorMsg, $offer, $user, $postulate)
    {
        $this->smarty->assign('errorMsg', $errorMsg);



        $this->smarty->assign('offer', $offer);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('postulate', $postulate);

        $this->smarty->display('../view/templates/postulate/postulateEdit.tpl');
    }

    function displayPostulate($msg, $offer, $user)
    {
        //display

        $this->smarty->assign('errorMsg', $msg);



        $this->smarty->assign('offer', $offer);
        $this->smarty->assign('user', $user);
        $this->smarty->display('../view/templates/postulate/postulate.tpl');
    }
}
