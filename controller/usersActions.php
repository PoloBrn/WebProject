<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once '../model/CRUD_user.php';
require_once '../model/CRUD_address.php';
require_once '../model/CRUD_promo.php';
require_once '../model/CRUD_campus.php';

$user = new \MODELE\CRUD_user;
$address = new \MODELE\CRUD_address;
$promo = new \MODELE\CRUD_promo;
$campus = new \MODELE\CRUD_campus;

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


        if (count($user->getUserInfos($user_email)) == 0) {

            $id_address = $address->create(array($address_label, $address_postal_code, $address_city));

            //Insérer l'utilisateur dans la bdd
            $user_id = $user->create(array($user_first_name, $user_last_name, $user_email, $user_password, $user_role, $id_address));

            if ($user_role == 3) {
                $promo->addUserInPromo($_POST['promo'], $user_id);
            }

            //Rediriger l'utilisateur sur la page d'accueil
            $errorMsg = "L'utilisateur a bien été créé avec l'id : " . $user_id;
            header('Location: users.php');
        } else {
            $errorMsg = "L'adresse email est déjà utilisée";
        }
        
        
    } else {
        $errorMsg = 'Veuillez compléter tous les champs';
    }
}



if (isset($_POST['update'])) {

    if (!empty($_POST['first_password']) && !empty(['second_password'])) {

        if ($_POST['first_password'] == $_POST['second_password']) {
            $password = password_hash($_POST['first_password'], PASSWORD_DEFAULT);
            $user->updatePassword($_GET['id'], $password);
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

    $user->update(array($_GET['id'], $user_first_name, $user_last_name, $user_email));

    $address->update(array($address_label, $address_postal_code, $address_city, $address_id));

    //header('Location:companies.php?id=' . $_GET['id']);
}

if (isset($_POST['delete'])) {
    $user->delete(array($_GET['id']));

    header('Location: users.php');
}





if ($_SESSION['id_role'] == '1') {
    $users = $user->getStudentsAndPilots();
} elseif ($_SESSION['id_role'] == '2') {
    $users = $promo->getStudentsOfPilot($_SESSION['id_user']);
}

if (isset($_GET['id'])) {
    $oneUser = $user->get(array($_GET['id']));
}

$promos = $promo->getPilotPromos($_SESSION['id_user']);
$campuses = array();
if ($_SESSION['id_role'] == '2') {
    foreach ($promos as $promo_id) {
        $onecampus = $campus->getCampusByPromo($promo_id)[0];
        if (!in_array($onecampus, $campuses)) {
            array_push($campuses, $onecampus);
        }
    }
} else {
    $campuses = $campus->get(0);
}

function getPromoByIDcampusAndPilot($campus_id)
{
    $promo = new \MODELE\CRUD_promo;
    return $promo->getPromoByIDcampusAndPilot($campus_id, $_SESSION['id_user']);
}

function getPromoByIDcampus($campus_id)
{
    $promo = new \MODELE\CRUD_promo;
    return $promo->getByCampusID($campus_id);
}