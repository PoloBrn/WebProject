<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');
require_once '../model/CRUD_user.php';
require_once '../model/CRUD_address.php';
require_once '../model/CRUD_promo.php';
require_once '../model/CRUD_campus.php';
require_once '../view/users.php';


// function getPromoByIDcampusAndPilot($campus_id)
// {
//     $promo = new \MODELE\CRUD_promo;
//     return $promo->getPromoByIDcampusAndPilot($campus_id, $_SESSION['id_user']);
// }

// function getPromoByIDcampus($campus_id)
// {
//     $promo = new \MODELE\CRUD_promo;
//     return $promo->getByCampusID($campus_id);
// }


class ControlUsers{

    private $user, $address, $promo, $campus, $display, $errorMsg;

    function __construct() {
        $this->user = new \MODELE\CRUD_user;
        $this->address = new \MODELE\CRUD_address;
        $this->promo = new \MODELE\CRUD_promo;
        $this->campus = new \MODELE\CRUD_campus;
        $this->display = new viewUsers();

        $this->errorMsg = "0";
    }

    function users(){
        // Validation du formulaire
        if (isset($_POST['create'])) {

            // Vérifiersi l'user a bien complété tous les champs
            if (!(empty($_POST['first_name']) && empty($_POST['last_name']) && empty($_POST['email']) && empty($_POST['password']))) {
                // Les données que l'utilisateur a entré
                $user_first_name = htmlspecialchars($_POST['first_name']);
                $user_last_name = htmlspecialchars($_POST['last_name']);
                $user_email = htmlspecialchars($_POST['email']);
                $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user_role = $_POST['role'];
                

                $address_label = htmlspecialchars($_POST['label']);
                $address_postal_code = htmlspecialchars($_POST['postal_code']);
                $address_city = htmlspecialchars($_POST['city']);


                if (count($this->user->getUserInfos($user_email)) == 0) {

                    $id_address = $this->address->create(array($address_label, $address_postal_code, $address_city));

                    //Insérer l'utilisateur dans la bdd
                    $user_id = $this->user->create(array($user_first_name, $user_last_name, $user_email, $user_password, $user_role, $id_address));

                    if ($user_role == 3) {
                        $this->promo->addUserInPromo($_POST['promo'], $user_id);
                    }

                    //Rediriger l'utilisateur sur la page d'accueil
                    $this->errorMsg = "L'utilisateur a bien été créé avec l'id : " . $user_id;
                    header('Location: users.php');
                } else {
                    $this->errorMsg = "L'adresse email est déjà utilisée";
                }
                
                
            } else {
                $this->errorMsg = 'Veuillez compléter tous les champs';
            }
        }



        if (isset($_POST['update'])) {

            if (!empty($_POST['first_password']) && !empty(['second_password'])) {

                if ($_POST['first_password'] == $_POST['second_password']) {
                    $password = password_hash($_POST['first_password'], PASSWORD_DEFAULT);
                    $this->user->updatePassword($_GET['id'], $password);
                } else {
                    $errorMsg = 'Les mots de passe ne correspondent pas';
                }
            }
            $user_first_name = htmlspecialchars($_POST['first_name']);
            $user_last_name = htmlspecialchars($_POST['last_name']);
            $user_email = htmlspecialchars($_POST['email']);

            $address_id = htmlspecialchars($_POST['address_id']);
            $address_label = htmlspecialchars($_POST['label']);
            $address_postal_code = htmlspecialchars($_POST['postal_code']);
            $address_city = htmlspecialchars($_POST['city']);

            $this->user->update(array($_GET['id'], $user_first_name, $user_last_name, $user_email));

            $this->address->update(array($address_label, $address_postal_code, $address_city, $address_id));

            //header('Location:companies.php?id=' . $_GET['id']);
        }

        if (isset($_POST['delete'])) {
            $this->user->delete(array($_GET['id']));

            header('Location: users.php');
        }

        if ($_SESSION['id_role'] == '1') {
            $users = $this->user->getStudentsAndPilots();
        } elseif ($_SESSION['id_role'] == '2') {
            $users = $this->promo->getStudentsOfPilot($_SESSION['id_user']);
        } else {
            $users = array();
        }


        if (isset($_GET['id'])) {
            $oneUser = $this->user->get(array($_GET['id']));
        }

        $promos = $this->promo->getPilotPromos($_SESSION['id_user']);
        $campuses = array();
        if ($_SESSION['id_role'] == '2') {
            foreach ($promos as $promo_id) {
                $onecampus = $this->campus->getCampusByPromo($promo_id)[0];
                if (!in_array($onecampus, $campuses)) {
                    array_push($campuses, $onecampus);
                }
            }
        } else {
            $campuses = $this->campus->get(0);
        }



        ////////////////////////////////

        //display for one user

        if (isset($_GET['id'])){
            if ((in_array($_GET['id'], array_column($this->user->getStudents(), 'id_user')) && $_SESSION['id_user'] != 3) || ($_GET['id'] == $_SESSION['id_user'])) {

                $oneUser = $this->user->get(array($_GET['id']));
                $this->display->displayUser($this->errorMsg, $oneUser);
            }
        }

        //display all users (add check for admin)
        else {
            
            $this->display->displayAllUsers($this->errorMsg, $campuses, $users);
        }
    }
}

$users = new ControlUsers();
$users->users();