<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require '../includes/head.php'; ?>
</head>
<?php
require('../controller/securityAction.php');
require_once '../model/CRUD_postulate.php';
require_once '../model/CRUD_user.php';
require_once '../model/CRUD_offer.php';
require_once '../model/CRUD_promo.php';
require_once '../view/postulate.php';

class ControlPostulate
{
    public $CRUD_postulate, $CRUD_offer, $CRUD_user, $CRUD_promo;
    public $postulate, $offer, $user;
    private $display, $errorMsg;

    function __construct()
    {
        $this->CRUD_postulate = new \MODELE\CRUD_postulate;
        $this->CRUD_offer = new \MODELE\CRUD_offer;
        $this->CRUD_user = new \MODELE\CRUD_user;
        $this->CRUD_promo = new \MODELE\CRUD_promo;

        $this->display = new ViewPostulate;
        $this->errorMsg = "0";
    }

    function create()
    {
        if (isset($_POST['offer_id']) &&  isset($_POST['user_id'])  && isset($_POST['infos'])) {
            $offer_id = htmlspecialchars($_POST['offer_id']);
            $user_id = htmlspecialchars($_POST['user_id']);
            $infos = htmlspecialchars($_POST['infos']);

            if (count($this->CRUD_postulate->getByIDs($user_id, $offer_id)) == 0) {

                $extension_cv = strtolower(pathinfo($_FILES['file']['name'][0], PATHINFO_EXTENSION));
                $file_name_cv = 'cv_offer_' . $offer_id . '_user_' . $user_id . '.' . $extension_cv;
                $path_cv = '../assets/users/cv/' . $file_name_cv;
                move_uploaded_file($_FILES['file']['tmp_name'][0], $path_cv);

                $extension_lm = strtolower(pathinfo($_FILES['file']['name'][1], PATHINFO_EXTENSION));
                $file_name_lm = 'lm_offer_' . $offer_id . '_user_' . $user_id . '.' . $extension_lm;
                $path_lm = '../assets/users/lm/' . $file_name_lm;
                move_uploaded_file($_FILES['file']['tmp_name'][1], $path_lm);

                $this->CRUD_postulate->create(array($offer_id, $user_id, $infos, $file_name_cv, $file_name_lm));
            }
        }
    }

    function update()
    {
        $offer_id = htmlspecialchars($_POST['offer_id']);
        $user_id = htmlspecialchars($_POST['user_id']);
        $progress = htmlspecialchars($_POST['progress']);
        if (count($this->CRUD_postulate->getByIDs($user_id, $offer_id)) != 0) {

            $this->CRUD_postulate->update(array($user_id, $offer_id, $progress));
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
                            $postulate = $this->CRUD_postulate->getByIDs($user_id, $offer_id);

                            if (!isset($_GET['postulate']) && count($postulate) != 0) {
                                $this->display->displayCandid($this->errorMsg, $offer, $user, $postulate[0]);
                            } elseif (count($postulate) == 0) {
                                $this->display->displayPostulate($this->errorMsg, $offer, $user);
                            } else {
                                echo 'Non accessible';
                            }
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

    function displayUserOffers()
    {
        $user_id = intval($_GET['user']);
        if (!empty($user_id) && $user_id != 0) {
            if ($_SESSION['id_role'] == 1 || ($_SESSION['id_role'] == 3 && $_SESSION['id_user'] == $user_id) || (in_array($user_id, array_column($this->CRUD_promo->getStudentsOfPilot($_SESSION['id_user']), 'id_user')))) {
                $users = $this->CRUD_user->getStudents();
                $user = array();
                foreach ($users as $oneuser) {
                    if ($oneuser['id_user'] == $user_id) {
                        $user = $oneuser;
                    }
                }
                if (count($user) != 0) {
                    $alloffers = $this->CRUD_offer->get(0);
                    $userOffers = $this->CRUD_postulate->getByUser($user['id_user']);
                    $offers = array();
                    foreach ($alloffers as $offer) {
                        if (in_array($offer['id_offer'], array_column($userOffers, 'id_offer'))) {

                            $offers[] = $offer;
                        }
                    }
                    $this->display->displayOffersByUser($this->errorMsg, $user, $offers);
                }
            }
        }
    }

    function displayOfferUsers()
    {
        $offer_id = intval($_GET['offer']);
        if (!empty($offer_id) && $offer_id != 0) {
            if ($_SESSION['id_role'] == 1 ) {
                $offers = $this->CRUD_offer->get(0);
                $offer = array();
                foreach ($offers as $oneoffer) {
                    if ($oneoffer['id_offer'] == $offer_id  || ($_SESSION['id_role'] == 2 && $_SESSION['id_user'] == $oneoffer['id_user'])) {
                        $offer = $oneoffer;
                    }
                }
                
                if (count($offer) != 0) {
                    $allusers = $this->CRUD_user->getStudents();
                    $offerUsers = $this->CRUD_postulate->getByOffer($offer['id_offer']);
                    $users = array();
                    foreach ($allusers as $user) {
                        if (in_array($user['id_user'], array_column($offerUsers, 'id_user'))) {

                            $users[] = $user;
                        }
                    }
                    $this->display->displayUsersByOffer($this->errorMsg, $offer, $users);
                }
            }
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



if (isset($_GET['offer']) && isset($_GET['user'])) {
    if (isset($_POST['create'])) {
        $controlPostulate->create();
    }
    if (isset($_POST['update'])) {
        $controlPostulate->update();
    }
    $controlPostulate->displayPostulate();
} elseif (isset($_GET['user'])) {
    $controlPostulate->displayUserOffers();
} elseif (isset($_GET['offer'])) {
    $controlPostulate->displayOfferUsers();
}






include '../includes/footer.php';
