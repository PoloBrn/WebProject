<?php

require_once '../model/CRUD_user.php';
require '../view/login.php';


error_log("test");

if (session_status() !== PHP_SESSION_ACTIVE) session_start();


class ControlAuth {

    private $login, $errorMsg;

    function __construct() {
        if (isset($_SESSION['auth'])) {
            header('Location: ../view/index.php');
        }
        $this->login = new Login();
    }


    function auth() {


        
        $user = new \MODELE\CRUD_user();

        // Validation du formulaire
        if (isset($_POST['login'])) {

            // Vérifiersi l'user a bien complété tous les champs
            if (!(empty($_POST['email']) && empty($_POST['password']))) {
                // Les données que l'utilisateur a entré
                $user_email = htmlspecialchars($_POST['email']);
                $user_password = htmlspecialchars($_POST['password']);

                $users_infos = $user->getUserInfos($user_email);

                if (count($users_infos) == 1) {
                    $user_infos = $users_infos[0];
                    if (password_verify($user_password, $user_infos['password'])) {
                        //Authentifie l'utilisateur sur le site et récupérer ses données dans la superglobale session
                        $_SESSION['auth'] = true;
                        $_SESSION['id_user'] = $user_infos['id_user'];
                        $_SESSION['email'] = $user_infos['email'];
                        $_SESSION['id_role'] = $user_infos['id_role'];
                        $_SESSION['first_name'] = $user_infos['first_name'];
                        $_SESSION['last_name'] = $user_infos['last_name'];
                        //Rediriger l'utilisateur vers l'index
                        header('Location: ../view/index.php');
                    } else {
                        $this->errorMsg = "L'email ou le mot de passe sont incorrects";
                    }
                } else {
                    // Si l'utilisateur existe, ne pas utiliser pas
                    $this->errorMsg = "L'email ou le mot de passe sont incorrects";
                }
            } else {
                $this->errorMsg = 'Veuillez compléter tous les champs';
            }
        }
        $this->login->display($this->errorMsg);
    }
}


$login = new ControlAuth();
$login->auth();