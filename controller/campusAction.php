<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once '../model/CRUD_campus.php';
require_once '../model/CRUD_promo.php';
require_once '../model/CRUD_promotype.php';
require_once '../model/CRUD_address.php';
require_once '../model/CRUD_user.php';

$campus = new \MODELE\CRUD_campus;
$promo = new \MODELE\CRUD_promo;
$promotype = new \MODELE\CRUD_promotype;
$address = new \MODELE\CRUD_address;
$user = new \MODELE\CRUD_user;


$promoTypes = $promotype->get(0);
$promos = $promo->get(0);
$campuses = $campus->get(0);

if ($_SESSION['id_role'] == 1) {

    if (isset($_POST['create_campus'])) {

        $address_label = htmlspecialchars($_POST['label']);
        $address_postal_code = htmlspecialchars($_POST['postal_code']);
        $address_city = htmlspecialchars($_POST['city']);

        $campus_name = htmlspecialchars($_POST['create_campus_name']);

        if (count($campus->getByInfos($campus_name)) == 0) {

            $address_id = $address->create(array($address_label, $address_postal_code, $address_city));

            $campus_id = $campus->create(array($campus_name, $address_id));

            header('Location: campus.php#' . $campus_id);
        }
    }
    if (isset($_POST['update_campus'])) {
        $campus_id = htmlspecialchars($_POST['id_campus']);
        $campus_name = htmlspecialchars($_POST['campus_name']);

        $address_postal_code = htmlspecialchars($_POST['campus_postal_code']);
        $address_city = htmlspecialchars($_POST['campus_city']);
        $address_label = htmlspecialchars($_POST['campus_label']);
        $address_id = htmlspecialchars($_POST['id_address']);

        $campus->update(array($campus_name, $campus_id));

        $address->update(array($address_label, $address_postal_code, $address_city, $address_id));

        header('Location: campus.php#' . $campus_id);
    }
    if (isset($_POST['delete_campus'])) {
        $campus_id = htmlspecialchars($_POST['id_campus']);
        $address_id = htmlspecialchars($_POST['id_address']);

        $campus->delete(array($campus_id));

        $address->delete(array($address_id));

        header('Location: campus.php');
    }

    if (isset($_POST['create_promo'])) {
        $campus_id = htmlspecialchars($_POST['create_campus_id']);
        $promo_name = htmlspecialchars($_POST['create_promo_name']);
        $promo_type = htmlspecialchars($_POST['create_promo_type']);

        $promo_id = $promo->create(array($promo_name, $promo_type, $campus_id));

        header('Location: campus.php#promo' . $promo_id);
    }


    if (isset($_GET['type'])) {

        if (isset($_POST['create_type'])) {
            $type_name = $_POST['create_type_name'];

            $type_id = $promotype->create(array($type_name));

            header('Location: campus.php?type=' . $type_id);
        }





        if (isset($_POST['update_type']) || isset($_POST['delete_type'])) {

            $type_id = $_POST['id_asso'];
            $type_name = $_POST['name_type'];

            if (isset($_POST['update_type'])) {
                $promotype->update(array($type_name, $type_id));
            }

            if (isset($_POST['delete_type'])) {

                $promotype->delete(array($type_id));
            }

            header('Location: campus.php?type');
        }








        if (!empty($_GET['type'])) {

            $id_type = $_GET['type'];

            header('Location: campus.php?type#' . $id_type);
        }
    }
}

function getPromoByIDcampus($campus_id)
{
    $promo = new \MODELE\CRUD_promo;
    return $promo->getByCampusID($campus_id);
}



if (isset($_GET['promo'])) {
    if (!empty(['promo'])) {
        $promo_infos = $promo->getById($_GET['promo']);

        $promo_pilots = $promo->getPilotsByPromo($_GET['promo']);

        $promo_students = $promo->getStudentsByPromo($_GET['promo']);

        $students = $user->getStudents();
        $pilots = $user->getPilots();


        if (isset($_POST['addStudent'])) {
            if (count($promo->getAffiliation($_GET['promo'], $_POST['new_student'])) == 0) {
                $promo->addUserInPromo($_GET['promo'], $_POST['new_student']);
                header("Refresh:0");
            }
        }
        if (isset($_POST['addPilot'])) {
            if (count($promo->getAffiliation($_GET['promo'], $_POST['new_pilot'])) == 0) {
                $promo->addUserInPromo($_GET['promo'], $_POST['new_pilot']);
                header("Refresh:0");
            }
        }

        if (isset($_POST['deletePilotStudent'])) {
            $promo->deleteAffiliation($_GET['promo'], $_POST['user']);
            header("Refresh:0");
        }

        if (isset($_POST['update'])) {
            $promo->update(array($_POST['promo_id'], $_POST['update_promo_name'], $_POST['update_promo_type']));
            header('Location: campus.php?promo='. $_POST['promo_id']);
        }

        if (isset($_POST['delete'])) {
            $promo->delete(array($_POST['promo_id']));
            header('Location: campus.php');
        }
    }
}
