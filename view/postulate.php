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

    function displayPostulate($msg, $postulate)
    {
        //display

        if ($msg != "0") {
            $this->smarty->assign('errorMsg', $msg);
        }


        $this->smarty->assign('postulate', $postulate);

        $this->smarty->display('../view/templates/postulate/postulate.tpl');
    }
}
