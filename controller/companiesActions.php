<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require '../model/CRUD_company.php';
require '../model/CRUD_address.php';
require '../model/CRUD_localities.php';
require '../model/CRUD_activities.php';

$company = new \MODELE\CRUD_company();
$address = new \MODELE\CRUD_address();
$localities = new \MODELE\CRUD_localities();

$activity = new \MODELE\CRUD_activities();


// Validation du formulaire
if (isset($_POST['create'])) {


    // Vérifiersi l'user a bien complété tous les champs
    if (!(empty($_POST['company_name']) && empty($_POST['email']) && empty($_POST['nb_student']) && empty($_FILES['logo']['name']))) {


        // Les données que l'utilisateur a entré
        $company_name = htmlspecialchars($_POST['company_name']);
        $company_mail = htmlspecialchars($_POST['email']);
        $company_nb_student = $_POST['nb_student'];
        //$company_logo = htmlspecialchars($_POST['logo']);

        // Vérifier sur l'entreprise existe dèjà sur le site
        if (count($company->getByInfos($company_name, $company_mail)) == 0) {
            //Insérer l'entreprise dans la bdd
            $image_size = getimagesize($_FILES['logo']['tmp_name']);
            $company_id = $company->create(array($company_name, $company_mail, $company_nb_student, $_SESSION['id_user']));
            if ($image_size[0] != $image_size[1]) {
                $errorMsg = 'Image pas bonne taille : ' . $image_size[0] . ' x ' . $image_size[1] . '.php';
            } else {
                $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                $file_name = 'company_' . $company_id . '_logo' . '.' . $extension;
                $path = '../assets/company-logos/' . $file_name;
                $result = move_uploaded_file($_FILES['logo']['tmp_name'], $path);

                $company->updateLogo($file_name, $company_id);
            }

            //Rediriger l'utilisateur sur la page de l'entreprise
            header('Location:companies.php#company' . $company_id);
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

    if (isset($_FILES['logo']) and !empty($_FILES['logo']['name'])) {
        // Si le logo est renvoyé
        $image_size = getimagesize($_FILES['logo']['tmp_name']);


        if ($image_size[0] != $image_size[1]) {
            $errorMsg = 'Image pas bonne taille : ' . $image_size[0] . ' x ' . $image_size[1] . '.php';
        } else {
            $old_file_name = '../assets/company-logos/' . $company->getLogo($_GET['id'])[0]['logo'];
            if (file_exists($old_file_name)) {
                unlink($old_file_name);
            }
            $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
            $file_name = 'company_' . $_GET['id'] . '_logo' . '.' . $extension;
            $path = '../assets/company-logos/' . $file_name;
            $result = move_uploaded_file($_FILES['logo']['tmp_name'], $path);

            $company->updateLogo($file_name, $_GET['id']);
        }
    }

    header('Location:companies.php#company' . $_GET['id']);
}


if (isset($_POST['delete'])) {
    $logo_file = '../assets/company-logos/' . $company->getLogo($_GET['id'])[0]['logo'];
    if (file_exists($logo_file)) {
        unlink($logo_file);
    }
    $company->delete(array($_GET['id']));
    header('Location: companies.php');
}


if (isset($_POST['createAddress'])) {
    $address_label = htmlspecialchars($_POST['label']);
    $address_postal_code = htmlspecialchars($_POST['postal_code']);
    $address_city = htmlspecialchars($_POST['city']);

    if (count($address->getFromCompanyAndInfos($_GET['id'], $address_label, $address_postal_code, $address_city)) == 0) {

        $address_id = $address->create(array($address_label, $address_postal_code, $address_city));

        $localities->create(array($address_id, $_GET['id']));
    }
}

if (isset($_POST['deleteAddress']) && isset($_POST['address'])) {
    $address_id = htmlspecialchars($_POST['address']);

    $localities->delete(array($address_id, $_GET['id']));

    $address->delete(array($address_id));
}

if (isset($_POST['create_activity'])) {

    $activity_name = htmlspecialchars($_POST['create_activity_name']);

    if (count($activity->getByName($activity_name)) == 0) {

        $activity_id = $activity->create(array($activity_name));

        header('Location: companies.php?activity#activity' . $activity_id);
    }
}

if (isset($_POST['update_activity'])) {

    $activity_id = htmlspecialchars($_POST['id_activity']);
    $activity_name = htmlspecialchars($_POST['name_activity']);

    $activity->update(array($activity_id, $activity_name));

    header('Location: companies.php?activity#activity' . $activity_id);
}

if (isset($_POST['delete_activity'])) {

    $activity_id = htmlspecialchars($_POST['id_activity']);

    $activity->delete(array($activity_id));

    header('Location: companies.php?activity');
}

if (isset($_POST['add_activity'])) {

    $activity_id = htmlspecialchars($_POST['activity']);

    if (count($activity->getRelation($activity_id, $_GET['id'])) == 0) {
        $activity->addToCompany($activity_id, $_GET['id']);
    }
}

if (isset($_POST['remove_activity'])) {

    $activity_id = htmlspecialchars($_POST['id_activity']);

    $activity->removeFromCompany($activity_id, $_GET['id']);
}

$allCompanies = $company->get(0);

if (isset($_GET['id'])) {
    $company_infos = $company->getById($_GET['id']);

    $addresses = $localities->get(array($_GET['id']));

    $company_activities = $activity->getCompanyActivities($_GET['id']);
}

if (isset($_GET['activity'])) {
}

$allActivities = $activity->get(0);
