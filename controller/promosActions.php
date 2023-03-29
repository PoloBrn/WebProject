<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once('../includes/head.php');
require('../controller/securityAction.php');
require_once '../model/CRUD_promo.php';
require_once '../model/CRUD_promotype.php';
require_once '../model/CRUD_user.php';
require_once '../view/promo.php';


class ControlPromos
{

    public $CRUD_promo, $CRUD_user, $CRUD_promotype;
    private $display, $errorMsg;

    function __construct()
    {
        $this->CRUD_promo = new \MODELE\CRUD_promo;
        $this->CRUD_user = new \MODELE\CRUD_user;
        $this->CRUD_promotype = new \MODELE\CRUD_promotype;

        $this->display = new viewPromo();

        $this->errorMsg = "";
    }

    function addPilot()
    {
        if (count($this->CRUD_promo->getAffiliation($_GET['id'], $_POST['new_pilot'])) == 0) {
            $this->CRUD_promo->addUserInPromo($_GET['id'], $_POST['new_pilot']);
            header("Refresh:0");
        }
    }

    function addStudent()
    {
        if (count($this->CRUD_promo->getAffiliation($_GET['id'], $_POST['new_student'])) == 0) {
            $this->CRUD_promo->addUserInPromo($_GET['id'], $_POST['new_student']);
            header("Refresh:0");
        }
    }

    function removePilotStudent()
    {
        $this->CRUD_promo->deleteAffiliation($_GET['id'], $_POST['user']);
        header("Refresh:0");
    }

    function update()
    {
        $this->CRUD_promo->update(array($_POST['promo_id'], $_POST['update_promo_name'], $_POST['update_promo_type']));
        header('Location: campusAction.php?id=' . $_POST['campus_id']);
    }

    function delete()
    {
        $this->CRUD_promo->delete(array($_POST['promo_id']));
        header('Location: campusAction.php?id=' . $_POST['campus_id']);
    }


    function displayOne()
    {
        $promo = $this->CRUD_promo->getById($_GET['id'])[0];

        $promo['pilots'] = $this->CRUD_promo->getPilotsByPromo($_GET['id']);

        $promo['students'] = $this->CRUD_promo->getStudentsByPromo($_GET['id']);

        $students = $this->CRUD_user->getStudents();

        $pilots = $this->CRUD_user->getPilots();

        $promoTypes = $this->CRUD_promotype->get(0);

        $this->display->displayPromo($this->errorMsg, $promo, $students, $pilots, $promoTypes);
    }
}

$controlPromos = new ControlPromos();





if (isset($_POST['addStudent'])) {
    $controlPromos->addStudent();
}

if (isset($_POST['addPilot'])) {
    $controlPromos->addPilot();
}

if (isset($_POST['deletePilotStudent'])) {
    $controlPromos->removePilotStudent();
}

if (isset($_POST['update'])) {
    $controlPromos->update();
}

if (isset($_POST['delete'])) {
    $controlPromos->delete();
}

$controlPromos->displayOne();


include '../includes/footer.php';