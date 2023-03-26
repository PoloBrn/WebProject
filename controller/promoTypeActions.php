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
        $promoTypes = $this->CRUD_promotype->get(0);

        $this->display->displayAll($this->errorMsg, $promoTypes);
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