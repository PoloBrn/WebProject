<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['id_role'] != 1) {
    header('Location: ../view/index.php');
}
?>


<head>
    <?php require_once('../includes/head.php'); ?>
</head>
<?php
require('../controller/securityAction.php');
require_once '../model/CRUD_promotype.php';
require_once '../view/promoTypes.php';


class ControlPromoTypes
{

    public $CRUD_promotype;
    private $display, $errorMsg;

    function __construct()
    {
        $this->CRUD_promotype = new \MODELE\CRUD_promotype;

        $this->display = new viewPromoTypes();

        $this->errorMsg = "";
    }

    function create()
    {
        $type_name = $_POST['create_type_name'];

        if (count($this->CRUD_promotype->getByName($type_name)) == 0) {
            $type_id = $this->CRUD_promotype->create(array($type_name));

            header('Location: promoTypeActions.php#' . $type_id);
        } else {
            $this->errorMsg = 'Ce type de promo existe déjà ...';

            header('Location: promoTypeActions.php');
        }
    }

    function update()
    {
        $type_id = $_POST['id_asso'];
        $type_name = $_POST['name_type'];

        $this->CRUD_promotype->update(array($type_name, $type_id));


        header('Location: promoTypeActions.php#' . $type_id);
    }

    function delete()
    {
        $type_id = $_POST['id_asso'];

        $this->CRUD_promotype->delete(array($type_id));


        header('Location: promoTypeActions.php');
    }

    function displayAll()
    {
        $allPromoTypes = $this->CRUD_promotype->get(0);

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newtypes = array();    // Initialisation d'une vartiable temporaire
            foreach ($allPromoTypes as $type) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (
                    strpos(strtolower($type['type_name']), strtolower($search)) !== false
                ) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newtypes[] = $type;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allPromoTypes = $newtypes; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allPromoTypes)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allPromoTypes);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allPromoTypes) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newtypes = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allPromoTypes[$i])) {
                $newtypes[] = $allPromoTypes[$i];
            }
        }
        $promoTypes = $newtypes;
        $this->display->displayAll($this->errorMsg, $promoTypes, $search, $maxPage, $page, $nbByPage);
    }
}

$controlPromoTypes = new ControlPromoTypes();


if (isset($_POST['update_type'])) {
    $controlPromoTypes->update();
}

if (isset($_POST['delete_type'])) {
    $controlPromoTypes->delete();
}

if (isset($_POST['create_type'])) {
    $controlPromoTypes->create();
}

$controlPromoTypes->displayAll();



/*


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