<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once('../includes/head.php');
require('../controller/securityAction.php');

require '../model/CRUD_activities.php';
require_once '../view/activities.php';

class ControlActivities
{

    private $errorMsg, $CRUD_activities, $View_activities;

    function __construct()
    {
        $this->CRUD_activities = new \MODELE\CRUD_activities();

        $this->View_activities = new ViewActivities();
    }

    function createActivity()
    {


        $activity_name = htmlspecialchars($_POST['create_activity_name']);

        if (count($this->CRUD_activities->getByName($activity_name)) == 0) {

            $activity_id = $this->CRUD_activities->create(array($activity_name));

            header('Location: activitiesActions.php#' . $activity_id);
        }
    }

    function updateActivity()
    {

        $activity_id = htmlspecialchars($_POST['id_activity']);
        $activity_name = htmlspecialchars($_POST['name_activity']);

        $this->CRUD_activities->update(array($activity_id, $activity_name));

        header('Location: activitiesActions.php#' . $activity_id);
    }

    function delete_activity()
    {

        $activity_id = htmlspecialchars($_POST['id_activity']);

        $this->CRUD_activities->delete(array($activity_id));

        header('Location: activitiesActions.php');
    }

    function displayActivities()
    {

        $allActivities = $this->CRUD_activities->get(0);

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newactivities = array();    // Initialisation d'une vartiable temporaire
            foreach ($allActivities as $activity) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (
                    strpos(strtolower($activity['activity_name']), strtolower($search)) !== false
                ) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newactivities[] = $activity;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allActivities = $newactivities; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allActivities)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allActivities);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allActivities) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newactivities = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allActivities[$i])) {
                $newactivities[] = $allActivities[$i];
            }
        }
        $activities = $newactivities;




        $this->View_activities->displayActivities($this->errorMsg, $activities, $search, $maxPage, $page, $nbByPage);
    }
}

$Controller_activities = new ControlActivities();

if (isset($_POST['create_activity'])) {
    $Controller_activities->createActivity();
}

if (isset($_POST['update_activity'])) {
    $Controller_activities->updateActivity();
}

if (isset($_POST['delete_activity'])) {
    $Controller_activities->delete_activity();
}

$Controller_activities->displayActivities();


include '../includes/footer.php';