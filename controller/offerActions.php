<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../includes/head.php'); ?>
</head>
<?php
require('../controller/securityAction.php');

require '../model/CRUD_offer.php';
require '../model/CRUD_company.php';
require '../model/CRUD_localities.php';
require '../model/CRUD_activities.php';
require_once '../view/offer.php';

class ControlOffers
{

    private $errorMsg, $CRUD_offer, $CRUD_company, $CRUD_localities, $CRUD_activities, $View_offers;

    function __construct()
    {
        $this->CRUD_offer = new \MODELE\CRUD_offer();
        $this->CRUD_company = new \MODELE\CRUD_company();
        $this->CRUD_localities = new \MODELE\CRUD_localities();
        $this->CRUD_activities = new \MODELE\CRUD_activities();

        $this->View_offers = new ViewOffers();

        $this->errorMsg = '';
    }

    function create()
    {
        $offer_name = htmlspecialchars($_POST['offer_name']);
        $offer_locality_id = $_POST['offer_locality'];
        $offer_activity_id = $_POST['offer_activity'];
        $offer_start_date = $_POST['offer_start_date'];
        $offer_end_date = $_POST['offer_end_date'];
        $offer_places = $_POST['offer_places'];
        $offer_salary = $_POST['offer_salary'];
        $offer_description = htmlspecialchars($_POST['offer_description']);

        if (
            !empty($offer_name)
        ) {
            $offer_id = $this->CRUD_offer->create(array(
                $offer_name, $offer_locality_id, $offer_activity_id,
                $offer_start_date, $offer_end_date, $offer_places, $offer_salary, $offer_description, $_SESSION['id_user']
            ));

            header('Location: offerActions.php?id=' . $offer_id . '&edit');
        }
    }

    function update()
    {
    }

    function delete()
    {
    }

    function displayAll()
    {
        $companies = $this->CRUD_company->get(0);

        $newcompanies = array();
        foreach ($companies as $company) {
            if ($_SESSION['id_role'] == 1 || $_SESSION['id_user'] == $company['id_user']) {
                $company['localities'] = $this->CRUD_localities->get(array($company['id_company']));
                $company['activities'] = $this->CRUD_activities->getCompanyActivities($company['id_company']);
                $newcompanies[] = $company;
            }
        }
        $companies = $newcompanies;

        $allOffers = $this->CRUD_offer->get(0);
        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newoffers = array();    // Initialisation d'une vartiable temporaire
            foreach ($allOffers as $offer) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (
                    strpos(strtolower($offer['company_name']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['offer_name']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['offer_description']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['company_description']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['email']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['activity_name']), strtolower($search)) !== false
                ) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newoffers[] = $offer;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allOffers = $newoffers; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allOffers)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allOffers);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
        }

        if ($nbByPage < 1) {
            $nbByPage = 1;
        }

        if (!isset($_GET['page']) || empty($_GET['page'])) {    //Si la page demandée n'est pas initialisé ou est vide
            $page = 1;  // On initialise à 1
        } else {
            $page = intval($_GET['page']);  // Sinon on intègre le numéro de page demandé
        }

        if ($page < 1) { // Si le nombre de page demandé est inférieur à 1
            $page = 1;  // On remplace sa valeur par 1
        }

        $maxPage = ceil(count($allOffers) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newoffers = array();
        // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allOffers[$i])) {
                $newoffers[] = $allOffers[$i];
            }
        }
        $offers = $newoffers;
        $this->View_offers->displayOffers($this->errorMsg, $companies, $offers, $search, $maxPage, $page, $nbByPage);
    }
}

$controlOffers = new ControlOffers();

if (isset($_POST['offer_create'])) {
    $controlOffers->create();
}

if (isset($_POST['update_skill'])) {
    $controlOffers->update();
}

if (isset($_POST['delete_skill'])) {
    $controlOffers->delete();
}

$controlOffers->displayAll();
