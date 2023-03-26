<?php

require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';


class viewPromo
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayPromo($errorMsg, $promo, $students, $pilots, $promoTypes)
    {

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('promo', $promo);
        $this->smarty->assign('students', $students);
        $this->smarty->assign('pilots', $pilots);
        $this->smarty->assign('promoTypes', $promoTypes);

        $this->smarty->display('../view/templates/promos/onePromo.tpl');
    }
}
