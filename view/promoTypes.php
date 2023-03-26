<?php

require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';

class viewPromoTypes
{
    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayAll($errorMsg, $promoTypes)
    {

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('promoTypes', $promoTypes);

        $this->smarty->display('../view/templates/promotypes/promoTypes.tpl');
    }
}
