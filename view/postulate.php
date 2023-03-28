<?php

require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';


Class ViewPostulate
{
    
    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
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
