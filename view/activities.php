<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once '../assets/smarty/Smarty.class.php';
include '../includes/head.php';
include '../includes/scripts.php';

$smarty = new Smarty();

class ViewActivities
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayActivities($msg, $activities){
        //display an user documents


        $this->smarty->assign('activities', $activities);
        
        $this->smarty->display('../view/templates/activities.tpl');

    }
}
