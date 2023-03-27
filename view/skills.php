<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once '../assets/smarty/Smarty.class.php';
include '../includes/head.php';
include '../includes/scripts.php';

$smarty = new Smarty();

class ViewSkills
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displaySkills($errorMsg, $skills, $search, $maxPage, $page, $nbByPage){
        //display an user documents

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('skills', $skills);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);

        
        $this->smarty->display('../view/templates/skills/skills.tpl');

    }
}
