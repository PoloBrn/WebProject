<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require '../model/CRUD_company.php';
require '../model/CRUD_address.php';
require '../model/CRUD_localities.php';

$company = new \MODELE\CRUD_company();
$address = new \MODELE\CRUD_address();
$localities = new \MODELE\CRUD_localities();


// Validation du formulaire
if (isset($_POST['create'])) {

    // Vérifiersi l'user a bien complété tous les champs
    if (!(empty($_POST['company_name']) && empty($_POST['email']) && empty($_POST['nb_student']) /*&& empty($_POST['logo'])*/)) {
        // Les données que l'utilisateur a entré
        $company_name = htmlspecialchars($_POST['company_name']);
        $company_mail = htmlspecialchars($_POST['email']);
        $company_nb_student = $_POST['nb_student'];
        //$company_logo = htmlspecialchars($_POST['logo']);

        // Vérifier sur l'entreprise existe dèjà sur le site
        if (count($company->getByInfos($company_name, $company_mail)) == 0) {
            //Insérer l'entreprise dans la bdd
            $company_id = $company->create(array($company_name, $company_mail, $company_nb_student, $_SESSION['id_user']));

            //Rediriger l'utilisateur sur la page de l'entreprise
            header('Location:companies.php?id=' . $company_id);
        } else {
            $errorMsg = "L'entreprise existe déjà";
        }
    } else {
        $errorMsg = 'Veuillez compléter tous les champs';
    }
}

if (isset($_POST['update'])) {
    $company_name = htmlspecialchars($_POST['company_name']);
    $company_mail = htmlspecialchars($_POST['email']);
    $company_nb_student = $_POST['nb_student'];
    //$company_logo = htmlspecialchars($_POST['logo']);

    $company->update(array($company_name, $company_mail, $company_nb_student, $_GET['id']));

    header('Location:companies.php?id=' . $_GET['id']);
}


if (isset($_POST['delete'])) {
    $company->delete($_GET['id']);
    header('Location: companies.php');
}


if (isset($_POST['createAddress'])) {
    $address_label = htmlspecialchars($_POST['label']);
    $address_postal_code = htmlspecialchars($_POST['postal_code']);
    $address_city = htmlspecialchars($_POST['city']);

    $address_id = $address->create(array($address_label, $address_postal_code, $address_city));

    $localities->create(array($address_id, $_GET['id']));
}

if (isset($_POST['deleteAddress']) && isset($_POST['address'])) {
    $address_id = htmlspecialchars($_POST['address']);

    $localities->delete(array($address_id, $_GET['id']));

    $address->delete(array($address_id));
}



$allCompanies = $company->get(0);

if (isset($_GET['id'])) {
    $company_infos = $company->getById($_GET['id']);

    $addresses = $localities->get(array($_GET['id']));
}
