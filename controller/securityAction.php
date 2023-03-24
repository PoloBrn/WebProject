<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: ../controller/authActions.php');
} 

require_once '../assets/smarty/Smarty.class.php';

$smarty = new Smarty();

switch ($_SESSION['id_role']){

    case 3:
        $smarty->display('../includes/navbar/navbarStudent.tpl');
        break;
    case 2:
        $smarty->display('../includes/navbar/navbarPilote.tpl');
        break;
    case 1:
        $smarty->display('../includes/navbar/navbarAdmin.tpl');
        break;
    default:
        header('Location: ../controller/authActions.php');
}