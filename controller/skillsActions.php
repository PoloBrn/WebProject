<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();


require_once('../includes/head.php'); 
require('../controller/securityAction.php');

require '../model/CRUD_skills.php';
require_once '../view/skills.php';

class ControlSkills
{

    private $errorMsg, $CRUD_skills, $View_skills;

    function __construct()
    {
        $this->CRUD_skills = new \MODELE\CRUD_skills();

        $this->View_skills = new ViewSkills();

        $this->errorMsg = '';
    }

    function create()
    {
        $skill_name = htmlspecialchars($_POST['skill_name']);

        if (!empty($skill_name)) {
            if (count($this->CRUD_skills->getByName($skill_name)) == 0) {
                $skill_id = $this->CRUD_skills->create((array($skill_name)));
    
                header('Location: skillsActions.php#'.$skill_id);
            }
            
        } else {
            $this->errorMsg = 'Veillez saisir le nom de la compétence';
        }
    }

    function update()
    {

        $skill_id = htmlspecialchars($_POST['id_skill']);
        $skill_name = htmlspecialchars($_POST['name_skill']);

        $this->CRUD_skills->update(array($skill_id, $skill_name));

        header('Location: skillsActions.php#'.$skill_id);
    }

    function delete()
    {

        $skill_id = htmlspecialchars($_POST['id_skill']);

        $this->CRUD_skills->delete(array($skill_id));

        header('Location: skillsActions.php');
    }

    function displayAll()
    {

        $allSkills = $this->CRUD_skills->get(0);

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newskills = array();    // Initialisation d'une vartiable temporaire
            foreach ($allSkills as $skill) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (
                    strpos(strtolower($skill['skill_name']), strtolower($search)) !== false
                ) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newskills[] = $skill;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allSkills = $newskills; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allSkills)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allSkills);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allSkills) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newskills = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allSkills[$i])) {
                $newskills[] = $allSkills[$i];
            }
        }
        $skills = $newskills;




        $this->View_skills->displaySkills($this->errorMsg, $skills, $search, $maxPage, $page, $nbByPage);
    }
}

$controlSkills = new ControlSkills();

if (isset($_POST['skill_create'])) {
    $controlSkills->create();
}

if (isset($_POST['update_skill'])) {
    $controlSkills->update();
}

if (isset($_POST['delete_skill'])) {
    $controlSkills->delete();
}

$controlSkills->displayAll();


include '../includes/footer.php';