<?php
use MODELE\CRUD_campus;
use MODELE\CRUD_user;
/*
if ($_SESSION['id_role'] == 3) {
    header('Location: index.php');
}*/



require_once '../assets/smarty/Smarty.class.php';


Class viewUsers{
    
    private $smarty,$campus,$users;

    function __construct() {
        $this->smarty = new Smarty();
        $campus = new CRUD_campus();
        $users = new CRUD_user();
        

    }

    function displayUser($msg,$oneUser){
        //display an user documents

        if ($msg !="0"){
            $this->smarty->assign('errorMsg', $msg) ;
        }

        $this->smarty->assign('oneUser', $oneUser) ;
    }

    function displayAllUsers($msg, $campus, $user) {
        //display users

        if ($msg !="0"){
            $this->smarty->assign('errorMsg', $msg) ;
        }


        $this->smarty->assign('campus', $campus );
        $this->smarty->assign('users', $user );


        $this->smarty->display('../view/templates/users.tpl');
    }

}
