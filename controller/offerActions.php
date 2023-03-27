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
require '../model/CRUD_promotype.php';
require '../model/CRUD_skills.php';
require '../model/CRUD_wishlist.php';
require '../model/CRUD_campus.php';
require '../model/CRUD_promo.php';
require_once '../view/offer.php';

class ControlOffers
{

    private $errorMsg, 
    $CRUD_offer, 
    $CRUD_company, 
    $CRUD_localities, 
    $CRUD_activities, 
    $CRUD_promotype, 
    $CRUD_skills, 
    $CRUD_wishlist,
    $CRUD_campus,
    $CRUD_promo,
    $View_offers;

    function __construct()
    {
        $this->CRUD_offer = new \MODELE\CRUD_offer();
        $this->CRUD_company = new \MODELE\CRUD_company();
        $this->CRUD_localities = new \MODELE\CRUD_localities();
        $this->CRUD_activities = new \MODELE\CRUD_activities();
        $this->CRUD_promotype = new \MODELE\CRUD_promotype();
        $this->CRUD_skills = new \MODELE\CRUD_skills();
        $this->CRUD_wishlist = new \MODELE\CRUD_wishlist();
        $this->CRUD_campus = new \MODELE\CRUD_campus();
        $this->CRUD_promo = new \MODELE\CRUD_promo();
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
        $offer_name = htmlspecialchars($_POST['offer_name']);
        $offer_locality_id = $_POST['offer_locality'];
        $offer_activity_id = $_POST['offer_activity'];
        $offer_start_date = $_POST['offer_start_date'];
        $offer_end_date = $_POST['offer_end_date'];
        $offer_places = $_POST['offer_places'];
        $offer_salary = $_POST['offer_salary'];
        $offer_description = htmlspecialchars($_POST['offer_description']);
        $offer_active = $_POST['active'][0];

        $this->CRUD_offer->update(array(
            $offer_name, $offer_locality_id, $offer_activity_id, $offer_start_date,
            $offer_end_date, $offer_places, $offer_salary, $offer_description, $offer_active, $_GET['id']
        ));
        header('Location: offerActions.php?id=' . $_GET['id'] . '&edit');
    }

    function addWishlist()
    {

        $user_id = $_POST['student'];
        $offer_id = $_POST['offer_id'];

        if (count($this->CRUD_wishlist->getRelation($offer_id, $user_id)) == 0) {
            $this->CRUD_wishlist->create(array($user_id, $offer_id));
        } else {
            $this->errorMsg = 'Wishlist deja faite';
        }
    }

    function removeWishlist()
    {
        $user_id = $_POST['student'];
        $offer_id = $_POST['offer_id'];

        $this->CRUD_wishlist->delete(array($user_id, $offer_id));
    }

    function addSkill()
    {

        $skill_id = htmlspecialchars($_POST['skill']);

        if (count($this->CRUD_skills->getRelation($_GET['id'], $skill_id)) == 0) {
            $this->CRUD_skills->addToOffer($_GET['id'], $skill_id);
        } else {
            $this->errorMsg = 'Activité déjà ajoutée';
        }
    }

    function removeSkill()
    {


        $skill_id = htmlspecialchars($_POST['id_skill']);

        $this->CRUD_skills->removeFromOffer($_GET['id'], $skill_id);
    }

    function addType()
    {

        $type_id = htmlspecialchars($_POST['promotype']);

        if (count($this->CRUD_promotype->getRelation($_GET['id'], $type_id)) == 0) {
            $this->CRUD_promotype->addToOffer($_GET['id'], $type_id);
        } else {
            $this->errorMsg = 'Activité déjà ajoutée';
        }
    }

    function removeType()
    {


        $type_id = htmlspecialchars($_POST['id_type']);

        $this->CRUD_promotype->removeFromOffer($_GET['id'], $type_id);
    }



    function delete()
    {
        $offer_id = $_GET['id'];

        $this->CRUD_offer->delete($offer_id);
        header('Location: offerActions.php');
    }
    function displayOne()
    {
        $allOffers = $this->CRUD_offer->get(0);
        if (in_array($_GET['id'], array_column($allOffers, 'id_offer'))) {
            $offer = array();
            foreach ($allOffers as $oneoffer) {
                if ($oneoffer['id_offer'] == $_GET['id']) {
                    $offer = $oneoffer;
                }
            }

            $offer['localities'] = $this->CRUD_localities->get(array($offer['id_company']));
            $offer['activities'] = $this->CRUD_activities->getCompanyActivities($offer['id_company']);

            $offer['promotypes'] = $this->CRUD_promotype->getFromOffer($offer['id_offer']);
            $offer['skills'] = $this->CRUD_skills->getFromOffer($offer['id_offer']);


            $promotypes = $this->CRUD_promotype->get(0);
            $skills = $this->CRUD_skills->get(0);


            $edit = isset($_GET['edit']) && ($_SESSION['id_user'] == $offer['id_user'] || $_SESSION['id_role'] == 1);

            $this->View_offers->displayOne($this->errorMsg, $offer, $promotypes, $skills, $edit);
        } else {
            echo '<h1>Offre inexistante</h1>';
        }
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

        $newoffers = array();
        foreach ($allOffers as $offer) {
            if (($offer['id_user'] == $_SESSION['id_user'] || $_SESSION['id_role'] == 1) || $offer['offer_active'] == 'on') {
                $offer['wishes'] = $this->CRUD_wishlist->getFromOffer($offer['id_offer']);
                $offer['promotypes'] = $this->CRUD_promotype->getFromOffer($offer['id_offer']);
                $offer['skills'] = $this->CRUD_skills->getFromOffer($offer['id_offer']);
                $newoffers[] = $offer;
            }
        }
        $allOffers = $newoffers;
        $newoffers = array();
        if (isset($_GET['skill'])) {
            $skill = intval($_GET['skill']);
            if ($skill != 0 || !empty($skill)) {
                foreach ($allOffers as $offer) {
                    if (in_array($skill, array_column($offer['skills'], 'id_skill'))) {
                        $newoffers[] = $offer;
                    }
                }
                $allOffers = $newoffers;
            } else {
                $skill = 0;
            }
        } else {
            $skill = 0;
        }

        $newoffers = array();
        if (isset($_GET['type'])) {
            $type = intval($_GET['type']);
            if ($type != 0 || !empty($type)) {
                foreach ($allOffers as $offer) {
                    if (in_array($type, array_column($offer['promotypes'], 'id_type'))) {
                        $newoffers[] = $offer;
                    }
                }
                $allOffers = $newoffers;
            } else {
                $type = 0;
            }
        } else {
            $type = 0;
        }


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
                    strpos(strtolower($offer['activity_name']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['city_name']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['label']), strtolower($search)) !== false ||
                    strpos(strtolower($offer['postal_code']), strtolower($search)) !== false
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

        $skills = $this->CRUD_skills->get(0);
        $types = $this->CRUD_promotype->get(0);

        $campuses = $this->CRUD_campus->get(0);
        $newcampuses = array();
        foreach ($campuses as $campus) {
            $campus['promos'] = $this->CRUD_promo->getByCampusID($campus['id_campus']);
            $newpromos = array();
            foreach ($campus['promos'] as $promo) {
                $promo['students'] = $this->CRUD_promo->getStudentsByPromo($promo['id_promo']);
                $newpromos[] = $promo;
            }
            $campus['promos'] = $newpromos;
            $newcampuses[] = $campus;
        }
        $campuses = $newcampuses;


        $this->View_offers->displayOffers($this->errorMsg, $companies, $offers, $search, $maxPage, $page, $nbByPage, $skills, $skill, $types, $type, $campuses);
    }
}

$controlOffers = new ControlOffers();

if (isset($_GET['id'])) {
    if (isset($_POST['update'])) {
        $controlOffers->update();
    }
    if (isset($_POST['delete'])) {
        $controlOffers->delete();
    }

    if (isset($_POST['addSkill'])) {
        $controlOffers->addSkill();
    }
    if (isset($_POST['removeSkill'])) {
        $controlOffers->removeSkill();
    }

    if (isset($_POST['addType'])) {
        $controlOffers->addType();
    }
    if (isset($_POST['removeType'])) {
        $controlOffers->removeType();
    }
    $controlOffers->displayOne();
} else {
    if (isset($_POST['offer_create'])) {
        $controlOffers->create();
    }
    if (isset($_POST['addWishlist'])) {
        $controlOffers->addWishlist();
    }
    if (isset($_POST['removeWishlist'])) {
        $controlOffers->removeWishlist();
    }
    $controlOffers->displayAll();
}
