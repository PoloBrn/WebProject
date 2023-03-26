<?php


/*
if ($_SESSION['id_role'] == 3) {
    header('Location: index.php');
}*/



require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';


class viewCampus
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayCampus($errorMsg, $campus, $promoTypes, $promos, $search, $maxPage, $page, $nbByPage)
    {

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('campus', $campus);
        $this->smarty->assign('promoTypes', $promoTypes);
        $this->smarty->assign('promos', $promos);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);

        $this->smarty->display('../view/templates/campuses/oneCampus.tpl');
    }

    function displayAllCampuses($errorMsg, $campuses, $search, $maxPage, $page, $nbByPage)
    {

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('campuses', $campuses);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);

        $this->smarty->display('../view/templates/campuses/campuses.tpl');
    }
}
