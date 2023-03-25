<?php

use MODELE\CRUD_campus;
use MODELE\CRUD_user;
/*
if ($_SESSION['id_role'] == 3) {
    header('Location: index.php');
}*/



require_once '../assets/smarty/Smarty.class.php';

include '../includes/scripts.php';

class viewUsers
{

    private $smarty, $campus, $users;

    function __construct()
    {
        $this->smarty = new Smarty();
        $campus = new CRUD_campus();
        $users = new CRUD_user();
    }

    function displayUser($msg, $oneUser)
    {
        //display an user documents

        if ($msg != "0") {
            $this->smarty->assign('errorMsg', $msg);
        }

        $this->smarty->assign('oneUser', $oneUser);

        $this->smarty->display('../view/templates/oneUser.tpl');
    }

    function displayAllUsers($msg, $campuses, $users, $maxPage, $page, $nbByPage, $search, $role)
    {
        //display users

        if ($msg != "0") {
            $this->smarty->assign('errorMsg', $msg);
        }


        $this->smarty->assign('campuses', $campuses);
        $this->smarty->assign('users', $users);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('role', $role);

        $this->smarty->display('../view/templates/users.tpl');
    }
}
