<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<head>
    <?php require_once('../includes/head.php'); ?>
</head>
<?php
require('../controller/securityAction.php');
require_once '../model/CRUD_postulate.php';
require_once '../model/CRUD_user.php';
require_once '../model/CRUD_offer.php';
require_once '../view/postulate.php';


class ControlPostulate
{
    public $CRUD_postulate, $CRUD_offer, $CRUD_user;
    public $postulate, $offer , $user;
    private $display, $errorMsg;

    function __construct()
    {
        $this->postulate = new \MODELE\CRUD_postulate;
        $this->offer = new \MODELE\CRUD_offer;
        $this->user = new \MODELE\CRUD_user;

        $this->errorMsg = "0";
    }

    function create()
    {
        if(!(empty($_POST['id_user']) && empty($_POST['id_offer']) && empty($_POST['progress'])))
        {
            $postulate_progress = htmlspecialchars($_POST['progress']);

        } else {
            $this->errorMsg = 'Veuillez compléter tous les champs';
        }
    }


    function update()
    {
        if (!empty($_POST['first_password']) && !empty(['second_password'])) 
        {
            if ($_POST['first_progress'] == $_POST['second_progress']) {
                $progress = ($_POST['first_progress']);
                $this->user->updatePassword($_GET['id'], $progress);
            } else {
                $this->errorMsg = 'Les mots de passe ne correspondent pas';
            }
        }

        $postulate_progress = htmlspecialchars($_POST['progress']);
    }

    function delete()
    {
        $this->postulate->delete(array($_GET['id_user']));
        header('Location: users.php');
        $this->postulate->delete(array($_GET['id_offer']));
        //header('Location: offer.php');
    }

    function displayOne()
    {
        $onePostulate = $this->postulate->get(array($_GET['id']));
        $this->display->displayPostulate($this->errorMsg, $onePostulate);
    }

    function displayAll()
    {
        if ($_SESSION['id_role'] == '1' || $_SESSION['id_role'] == '3') {  //Si l'utilisateur est un admin
            $allUsers = $this->postulate->Postulate();    // On s'intéressera aux pilotes et aux étudiants
        } elseif ($_SESSION['id_role'] == '2') {    //Si l'utilisateur est un pilote
            $allUsers = $this->postulate->Postulate();
        } else {
            $allUsers = array();// On s'intéressera à personne
        }

        
    }
}


$controlPostulate = new ControlPostulate();

if (isset($_POST['create'])) {
    $controlPostulate->create();
}

if (isset($_POST['update'])) {
    $controlPostulate->update();
}

if (isset($_POST['delete'])) {
    $controlPostulate->delete();
}

$controlPostulate->displayOne();

include '../includes/footer.php';