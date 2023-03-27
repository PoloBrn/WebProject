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

    function displayAll($errorMsg, $promoTypes, $search, $maxPage, $page, $nbByPage)
    {

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('promoTypes', $promoTypes);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);

        $this->smarty->display('../view/templates/promotypes/promoTypes.tpl');
    }
}
