<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require('../controller/securityAction.php');
require_once '../model/CRUD_postulate.php';
require_once '../model/CRUD_user.php';
require_once '../model/CRUD_offer.php';
require_once '../view/postulate.php';

class ControlPostulate
{
    public $CRUD_postulate, $CRUD_offer, $CRUD_user;
    public $postulate, $offer, $user;
    private $display, $errorMsg;

    function __construct()
    {
        $this->CRUD_postulate = new \MODELE\CRUD_postulate;
        $this->CRUD_offer = new \MODELE\CRUD_offer;
        $this->CRUD_user = new \MODELE\CRUD_user;

        //$this->display = new \VIEW\postulate;
        $this->errorMsg = "0";
    }

    function create()
    {
        if (!empty($_POST['id_user']) && !empty($_POST['id_offer']) && !empty($_POST['progress'])) {
            $postulate_progress = htmlspecialchars($_POST['progress']);
            $id_user = htmlspecialchars($_POST['id_user']);
            $id_offer = htmlspecialchars($_POST['id_offer']);

            // Vérifier que l'utilisateur et l'offre existent
            $user = $this->user->get($id_user);
            $offer = $this->offer->get($id_offer);

            if ($user && $offer) {
                // Créer le postulant
                $postulate = array(
                    "id_user" => $id_user,
                    "id_offer" => $id_offer,
                    "progress" => $postulate_progress
                );
                $this->postulate->create($postulate);
            } else {
                $this->errorMsg = "L'utilisateur ou l'offre n'existe pas.";
            }
        } else {
            $this->errorMsg = 'Veuillez compléter tous les champs';
        }
    }

    function update()
    {
        if (isset($_POST['id_postulate']) && isset($_POST['progress'])) {
            $id_postulate = htmlspecialchars($_POST['id_postulate']);
            $postulate_progress = htmlspecialchars($_POST['progress']);

            // Update the progress of the postulate in the database
            $updated = $this->postulate->update(array($id_postulate, $postulate_progress));

            if (!$updated) {
                $this->errorMsg = 'Une erreur est survenue lors de la mise à jour';
            }
        } else {
            $this->errorMsg = 'Veuillez renseigner tous les champs';
        }
    }

    function delete()
    {
        if (isset($_POST['id_postulate'])) {
            $id_postulate = $_POST['id_postulate'];
            $postulate = $this->postulate->get(array($id_postulate));
            if ($postulate) {
                $this->postulate->delete(array($id_postulate));
            } else {
                $this->errorMsg = "Postulate introuvable";
            }
        } else {
            $this->errorMsg = "Veuillez sélectionner un postulate";
        }
    }

    function display()
    {
        if (isset($_GET['id_user']) && isset($_GET['id_offer'])) {
            $postulate = $this->postulate->get(array($_GET['id_user'], $_GET['id_offer']));
            if ($postulate) {
                $this->display->displayPostulate($this->errorMsg, $postulate);
            } else {
                echo "Postulate not found";
            }
        } else {
            echo "Missing parameters";
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

$controlPostulate->display();

include '../includes/footer.php';
