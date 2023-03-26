<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

?>

<head>
    <?php require_once('../includes/head.php'); ?>
</head>
<?php
require('../controller/securityAction.php');
require_once '../model/CRUD_campus.php';
require_once '../model/CRUD_promo.php';
require_once '../model/CRUD_promotype.php';
require_once '../model/CRUD_address.php';
require_once '../model/CRUD_user.php';
require_once '../view/campus.php';


class ControlCampuses
{

    public $CRUD_campus, $CRUD_promo, $CRUD_promotype, $CRUD_address;
    private $display, $errorMsg;

    function __construct()
    {
        $this->CRUD_campus = new \MODELE\CRUD_campus;
        $this->CRUD_promo = new \MODELE\CRUD_promo;
        $this->CRUD_promotype = new \MODELE\CRUD_promotype;
        $this->CRUD_address = new \MODELE\CRUD_address;

        $this->display = new viewCampus();

        $this->errorMsg = "";
    }

    function create()
    {
        $address_label = htmlspecialchars($_POST['label']);
        $address_postal_code = htmlspecialchars($_POST['postal_code']);
        $address_city = htmlspecialchars($_POST['city']);

        $campus_name = htmlspecialchars($_POST['create_campus_name']);

        if (count($this->CRUD_campus->getByInfos($campus_name)) == 0) {

            $address_id = $this->CRUD_address->create(array($address_label, $address_postal_code, $address_city));

            $campus_id = $this->CRUD_campus->create(array($campus_name, $address_id));

            header('Location: campusAction.php#' . $campus_id);
        }
    }

    function update()
    {
        $campus_id = htmlspecialchars($_POST['id_campus']);
        $campus_name = htmlspecialchars($_POST['campus_name']);

        $address_postal_code = htmlspecialchars($_POST['campus_postal_code']);
        $address_city = htmlspecialchars($_POST['campus_city']);
        $address_label = htmlspecialchars($_POST['campus_label']);
        $address_id = htmlspecialchars($_POST['id_address']);

        $this->CRUD_campus->update(array($campus_name, $campus_id));

        $this->CRUD_address->update(array($address_label, $address_postal_code, $address_city, $address_id));

        header('Location: campusAction.php#' . $campus_id);
    }

    function delete()
    {
        $campus_id = htmlspecialchars($_POST['id_campus']);
        $address_id = htmlspecialchars($_POST['id_address']);

        $this->CRUD_campus->delete(array($campus_id));

        $this->CRUD_address->delete(array($address_id));

        header('Location: campusAction.php');
    }

    function create_promo()
    {
        $campus_id = htmlspecialchars($_POST['create_campus_id']);
        $promo_name = htmlspecialchars($_POST['create_promo_name']);
        $promo_type = htmlspecialchars($_POST['create_promo_type']);

        $promo_id = $this->CRUD_promo->create(array($promo_name, $promo_type, $campus_id));

        header('Location: campusAction.php?id=' . $campus_id . '#promo' . $promo_id);
    }

    function displayOne()
    {
        $campus = $this->CRUD_campus->getById($_GET['id']);
        $allPromos = $this->CRUD_promo->getByCampusID($campus['id_campus']);
        $promotypes = $this->CRUD_promotype->get(0);

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newpromos = array();    // Initialisation d'une vartiable temporaire
            foreach ($allPromos as $promo) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (
                    strpos(strtolower($promo['promo_name']), strtolower($search)) !== false ||
                    strpos(strtolower($promo['type_name']), strtolower($search)) !== false
                ) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newpromos[] = $promo;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allPromos = $newpromos; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allPromos)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allPromos);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allPromos) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newpromos = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allPromos[$i])) {
                $newpromos[] = $allPromos[$i];
            }
        }
        $promos = $newpromos;






        $this->display->displayCampus($this->errorMsg, $campus, $promotypes, $promos, $search, $maxPage, $page, $nbByPage);
    }

    function displayAll()
    {
        $allCampuses = $this->CRUD_campus->get(0);

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newcampuses = array();    // Initialisation d'une vartiable temporaire
            foreach ($allCampuses as $campus) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (
                    strpos(strtolower($campus['campus_name']), strtolower($search)) !== false ||
                    strpos(strtolower($campus['label']), strtolower($search)) !== false ||
                    strpos(strtolower($campus['postal_code']), strtolower($search)) !== false ||
                    strpos(strtolower($campus['city_name']), strtolower($search)) !== false
                ) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newcampuses[] = $campus;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allCampuses = $newcampuses; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allCampuses)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allCampuses);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allCampuses) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newcampuses = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allCampuses[$i])) {
                $newcampuses[] = $allCampuses[$i];
            }
        }
        $campuses = $newcampuses; // La varialbe users contiendra donc nos utilisateurs de la page

        $this->display->displayAllCampuses($this->errorMsg, $campuses, $search, $maxPage, $page, $nbByPage);
    }
}

$controlCampuses = new ControlCampuses();

if (isset($_GET['id'])) {
    if (isset($_POST['update_campus'])) {
        $controlCampuses->update();
    }

    if (isset($_POST['delete_campus'])) {
        $controlCampuses->delete();
    }

    if (isset($_POST['create_promo'])) {
        $controlCampuses->create_promo();
    }
    $controlCampuses->displayOne();
} else {
    if (isset($_POST['create_campus'])) {
        $controlCampuses->create();
    }
    $controlCampuses->displayAll();
}

   /* 

    


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
*/