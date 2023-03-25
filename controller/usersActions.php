<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<head>
    <?php require_once('../includes/head.php'); ?>
</head>
<?php
require('../controller/securityAction.php');
require_once '../model/CRUD_user.php';
require_once '../model/CRUD_address.php';
require_once '../model/CRUD_promo.php';
require_once '../model/CRUD_campus.php';
require_once '../view/users.php';



class ControlUsers
{

    public $user, $address, $promo, $campus;
    private $display, $errorMsg;

    function __construct()
    {
        $this->user = new \MODELE\CRUD_user;
        $this->address = new \MODELE\CRUD_address;
        $this->promo = new \MODELE\CRUD_promo;
        $this->campus = new \MODELE\CRUD_campus;
        $this->display = new viewUsers();

        $this->errorMsg = "0";
    }

    function create()
    {

        // Vérifiersi l'user a bien complété tous les champs
        if (!(empty($_POST['first_name']) && empty($_POST['last_name']) && empty($_POST['email']) && empty($_POST['password']))) {
            // Les données que l'utilisateur a entré
            $user_first_name = htmlspecialchars($_POST['first_name']);
            $user_last_name = htmlspecialchars($_POST['last_name']);
            $user_email = htmlspecialchars($_POST['email']);
            $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user_role = $_POST['role'];

            $address_label = htmlspecialchars($_POST['label']);
            $address_postal_code = htmlspecialchars($_POST['postal_code']);
            $address_city = htmlspecialchars($_POST['city']);

            if (count($this->user->getUserInfos($user_email)) == 0) {

                $id_address = $this->address->create(array($address_label, $address_postal_code, $address_city));

                //Insérer l'utilisateur dans la bdd
                $user_id = $this->user->create(array($user_first_name, $user_last_name, $user_email, $user_password, $user_role, $id_address));

                if ($user_role == 3) {
                    $this->promo->addUserInPromo($_POST['promo'], $user_id);
                }

                //Rediriger l'utilisateur sur la page d'accueil
                $this->errorMsg = "L'utilisateur a bien été créé avec l'id : " . $user_id;
                header('Location: users.php');
            } else {
                $this->errorMsg = "L'adresse email est déjà utilisée";
            }
        } else {
            $this->errorMsg = 'Veuillez compléter tous les champs';
        }
    }


    function update()
    {
        if (!empty($_POST['first_password']) && !empty(['second_password'])) {
            if ($_POST['first_password'] == $_POST['second_password']) {
                $password = password_hash($_POST['first_password'], PASSWORD_DEFAULT);
                $this->user->updatePassword($_GET['id'], $password);
            } else {
                $this->errorMsg = 'Les mots de passe ne correspondent pas';
            }
        }
        $user_first_name = htmlspecialchars($_POST['first_name']);
        $user_last_name = htmlspecialchars($_POST['last_name']);
        $user_email = htmlspecialchars($_POST['email']);

        $address_id = htmlspecialchars($_POST['address_id']);
        $address_label = htmlspecialchars($_POST['label']);
        $address_postal_code = htmlspecialchars($_POST['postal_code']);
        $address_city = htmlspecialchars($_POST['city']);

        $this->user->update(array($_GET['id'], $user_first_name, $user_last_name, $user_email));

        $this->address->update(array($address_label, $address_postal_code, $address_city, $address_id));
        //header('Location:companies.php?id=' . $_GET['id']);
    }

    function delete()
    {
        $this->user->delete(array($_GET['id']));
        header('Location: users.php');
    }

    function displayOne()
    {
        $oneUser = $this->user->get(array($_GET['id']));
        $this->display->displayUser($this->errorMsg, $oneUser);
    }

    function displayAll()
    {
        if ($_SESSION['id_role'] == '1') {  //Si l'utilisateur est un admin
            $allUsers = $this->user->getStudentsAndPilots();    // On s'intéressera aux pilotes et aux étudiants
        } elseif ($_SESSION['id_role'] == '2') {    //Si l'utilisateur est un pilote
            $allUsers = $this->promo->getStudentsOfPilot($_SESSION['id_user']); // On s'intéressera aux étudiants qui ont comme pilote l'utilisateur
        } else {
            $allUsers = array();    // On s'intéressera à personne
        }

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = strtolower(htmlspecialchars($_GET['search'])); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newusers = array();    // Initialisation d'une vartiable temporaire
            foreach ($allUsers as $user) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (strpos(strtolower($user['first_name']), $search) !== false || strpos(strtolower($user['last_name']), $search) !== false || strpos(strtolower($user['email']), $search) !== false) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newusers[] = $user;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allUsers = $newusers; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (isset($_GET['role']) && !empty($_GET['role'])) {
            $role = intval($_GET['role']);
            if ($role == 2 || $role == 3) {
                $newusers = array();
                foreach ($allUsers as $user) {
                    if ($user['id_role'] == $role) {
                        $newusers[] = $user;
                    }
                }
                $allUsers = $newusers;
            } else {
                $role = 0;
            }
        } else {
            if ($_SESSION['id_role'] == '1') {
                $role = 0;
            } else {
                $role = 3;
            }
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allUsers)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allUsers);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allUsers) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newusers = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allUsers[$i])) {
                $newusers[] = $allUsers[$i];
            }
        }
        $users = $newusers; // La varialbe users contiendra donc nos utilisateurs de la page




        $promos = $this->promo->getPilotPromos($_SESSION['id_user']);
        $campuses = array();
        if ($_SESSION['id_role'] == '2') {
            foreach ($promos as $promo_id) {
                $onecampus = $this->campus->getCampusByPromo($promo_id)[0];
                if (!in_array($onecampus, $campuses)) {
                    $onecampus['promos'] = $this->promo->getPromoByIDcampusAndPilot($onecampus['id_campus'], $_SESSION['id_user']);
                    array_push($campuses, $onecampus);
                }
            }
        } else {
            $campuses = $this->campus->get(0);
            $newcampuses = array();
            foreach ($campuses as $onecampus) {
                $onecampus['promos'] = $this->promo->getByCampusID($onecampus['id_campus']);
                $newcampuses[] = $onecampus;
            }
            $campuses = $newcampuses;
        }

        $this->display->displayallUsers($this->errorMsg, $campuses, $users, $maxPage, $page, $nbByPage, $search, $role);
    }
}


$users = new ControlUsers();




if (isset($_POST['create']) && $_SESSION['id_role'] != 3) {
    $users->create();
}

if (isset($_GET['id'])) {


    if (isset($_POST['update'])  && ((in_array($_GET['id'], array_column($users->user->getStudents(), 'id_user')) && $_SESSION['id_user'] != 3) || ($_GET['id'] == $_SESSION['id_user']) || $_SESSION['id_role'] == 1)) {
        $users->update();
    }

    if (isset($_POST['delete'])  && ((in_array($_GET['id'], array_column($users->user->getStudents(), 'id_user')) && $_SESSION['id_user'] != 3) || $_SESSION['id_role'] == 1)) {
        $users->delete();
    }
    if ((in_array($_GET['id'], array_column($users->user->getStudents(), 'id_user')) && $_SESSION['id_user'] != 3) || ($_GET['id'] == $_SESSION['id_user']) || $_SESSION['id_role'] == 1) {
        $users->displayOne();
    }
} else {
    if ($_SESSION['id_role'] != 3) {
        $users->displayAll();
    } else {
        header('Location: ../view/index.php');
    }
}
