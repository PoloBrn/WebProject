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

        $this->display = new ViewPostulate;
        $this->errorMsg = "0";
    }

    function create()
    {
        if (isset($_POST['offer_id']) &&  isset($_POST['user_id']) && isset($_FILES['cv']) && isset($_FILES['lm']) && isset($_POST['infos'])) {
            $offer_id = htmlspecialchars($_POST['offer_id']);
            $user_id = htmlspecialchars($_POST['user_id']);
            $infos = htmlspecialchars($_POST['infos']);

            if (count($this->CRUD_postulate->getByIDs($user_id, $offer_id)) == 0) {

                $extension_cv = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
                $file_name_cv = 'cv_offer_' . $offer_id . '_user_' . $user_id . '.' . $extension_cv;
                $path_cv = '../assets/users/cv/' . $file_name_cv;
                

                if( move_uploaded_file($_FILES['cv']['tmp_name'], $path_cv) ) {
                         
                  } else {
                    header('Location: Not uploaded because of error #'.$_FILES["cv"]["error"]);
                  }

                $extension_lm = strtolower(pathinfo($_FILES['lm']['name'], PATHINFO_EXTENSION));
                $file_name_lm = 'lm_offer_' . $offer_id . '_user_' . $user_id . '.' . $extension_lm;
                $path_lm = '../assets/users/lm/' . $file_name_lm;
                
                if( move_uploaded_file($_FILES['lm']['tmp_name'], $path_lm) ) {
                     
                  } else {
                    header('Location: Not uploaded because of error #'.$_FILES["lm"]["error"]);
                  }
                $this->CRUD_postulate->create(array($offer_id, $user_id, $infos, $file_name_cv, $file_name_lm));
            }
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

    function displayPostulate()
    {

        $offer_id = intval($_GET['offer']);
        if (!empty($offer_id) && $offer_id != 0) {
            $offers = $this->CRUD_offer->get(0);
            $offer = array();
            foreach ($offers as $oneoffer) {
                if ($oneoffer['id_offer'] == $offer_id) {
                    $offer = $oneoffer;
                }
            }
            if (count($offer) != 0) {
                $user_id = intval($_GET['user']);
                if (!empty($user_id) && $user_id != 0) {
                    if ($_SESSION['id_role'] == 1 || ($_SESSION['id_role'] == 3 && $_SESSION['id_user'] == $user_id)) {
                        $users = $this->CRUD_user->getStudents();
                        $user = array();
                        foreach ($users as $oneuser) {
                            if ($oneuser['id_user'] == $user_id) {
                                $user = $oneuser;
                            }
                        }
                        if (count($user) != 0) {
                            $this->display->displayPostulate($this->errorMsg, $offer, $user);
                        } else {
                            echo 'Etudiant introuvable';
                        }
                    } else {
                        echo "Vous n'avez pas l'autorisation d'accéder à cette page";
                    }
                } else {
                    echo 'Etudiant introuvable';
                }
            } else {
                echo "Offre introuvable";
            }
        } else {
            echo "Offre introuvable";
        }
    }
}


$controlPostulate = new ControlPostulate();

/*


if (isset($_POST['update'])) {
    $controlPostulate->update();
}

if (isset($_POST['delete'])) {
    $controlPostulate->delete();
}
*/
if (isset($_GET['postulate'])) {
    if (isset($_POST['create'])) {
        $controlPostulate->create();
    }
    $controlPostulate->displayPostulate();
}





include '../includes/footer.php';
