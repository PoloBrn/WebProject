<?php

/*
if ($_SESSION['id_role'] == 3) {
    header('Location: index.php');
}*/



require_once '../assets/smarty/Smarty.class.php';


Class viewUsers{
    
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
    }

    function displayUser($msg,$oneUser){
        //display an user documents

        if ($msg !="0"){
            $this->smarty->assign('errorMsg', $msg) ;
        }

        $this->smarty->assign('oneUser', $oneUser) ;

        $this->smarty->display('../view/templates/oneUser.tpl');

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
