<?php

require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';


Class viewUsers
{
    
    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayPostulate($msg, $postulate)
    {
        //display

        if ($msg != "0") {
            $this->smarty->assign('errorMsg', $msg);
        }


        $this->smarty->assign('postulate', $postulate);

        $this->smarty->display('../view/templates/postulate/postulate.tpl');
    }

    function displayAllPostulate($users, $offer, $progress, $msg)
    {
        //display postulate

        if ($msg != "0") {
            $this->smarty->assign('errorMsg', $msg);
        }

        $this->smarty->assign('users', $users);
        $this->smarty->assign('search', $offer);
        $this->smarty->assign('role', $progress);

        $this->smarty->display('../view/templates/postulate/postulate.tpl');
    }
}
