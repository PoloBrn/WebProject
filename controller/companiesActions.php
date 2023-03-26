<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<head>
    <?php require '../includes/head.php'; ?>
</head>
<?php
require('../controller/securityAction.php');

require '../model/CRUD_company.php';
require '../model/CRUD_address.php';
require '../model/CRUD_localities.php';
require '../model/CRUD_activities.php';

require_once '../view/companies.php';





class ControlCompanies
{

    private $errorMsg, $CRUD_company, $CRUD_address, $CRUD_localities, $CRUD_activity, $display;

    function __construct()
    {


        $this->CRUD_address = new \MODELE\CRUD_address();
        $this->CRUD_company = new \MODELE\CRUD_company();
        $this->CRUD_localities = new \MODELE\CRUD_localities();
        $this->CRUD_activity = new \MODELE\CRUD_activities();
        $this->display = new viewCompanies();

        $this->errorMsg = "";
    }

    function create()
    {


        // Vérifiersi l'user a bien complété tous les champs
        if (!(empty($_POST['company_name']) && empty($_POST['email']) && empty($_POST['nb_student']) && empty($_FILES['logo']['name']))) {


            // Les données que l'utilisateur a entré
            $company_name = htmlspecialchars($_POST['company_name']);
            $company_mail = htmlspecialchars($_POST['email']);
            $company_nb_student = $_POST['nb_student'];
            //$company_logo = htmlspecialchars($_POST['logo']);

            // Vérifier sur l'entreprise existe dèjà sur le site
            if (count($this->CRUD_company->getByInfos($company_name, $company_mail)) == 0) {
                //Insérer l'entreprise dans la bdd
                $image_size = getimagesize($_FILES['logo']['tmp_name']);
                $company_id = $this->CRUD_company->create(array($company_name, $company_mail, $company_nb_student, $_SESSION['id_user']));
                if ($image_size[0] != $image_size[1]) {
                    $errorMsg = 'Image pas bonne taille : ' . $image_size[0] . ' x ' . $image_size[1] . '.php';
                } else {
                    $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                    $file_name = 'company_' . $company_id . '_logo' . '.' . $extension;
                    $path = '../assets/company-logos/' . $file_name;
                    $result = move_uploaded_file($_FILES['logo']['tmp_name'], $path);

                    $this->CRUD_company->updateLogo($file_name, $company_id);
                }

                //Rediriger l'utilisateur sur la page de l'entreprise
                header('Location:companiesActions.php#' . $company_id);
            } else {
                $errorMsg = "L'entreprise existe déjà";
            }
        } else {
            $errorMsg = 'Veuillez compléter tous les champs';
        }
    }

    function update()
    {

        $company_name = htmlspecialchars($_POST['company_name']);
        $company_mail = htmlspecialchars($_POST['email']);
        $company_nb_student = $_POST['nb_student'];
        $company_active = $_POST['active'][0];
        $company_description = htmlspecialchars($_POST['description']);
        //$company_logo = htmlspecialchars($_POST['logo']);

        $this->CRUD_company->update(array($company_name, $company_mail, $company_nb_student, $company_active, $company_description, $_GET['id']));

        if (isset($_FILES['logo']) and !empty($_FILES['logo']['name'])) {
            // Si le logo est renvoyé
            $image_size = getimagesize($_FILES['logo']['tmp_name']);


            if ($image_size[0] != $image_size[1]) {
                $this->errorMsg = 'Image pas bonne taille : ' . $image_size[0] . ' x ' . $image_size[1] . '.php';
            } else {
                $old_file_name = '../assets/company-logos/' . $this->CRUD_company->getLogo($_GET['id'])[0]['logo'];
                if (file_exists($old_file_name)) {
                    unlink($old_file_name);
                }
                $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                $file_name = 'company_' . $_GET['id'] . '_logo' . '.' . $extension;
                $path = '../assets/company-logos/' . $file_name;
                $result = move_uploaded_file($_FILES['logo']['tmp_name'], $path);

                $this->CRUD_company->updateLogo($file_name, $_GET['id']);
            }
        }

        header('Location:companiesActions.php?id=' . $_GET['id']);
    }

    function delete()
    {

        $logo_file = '../assets/company-logos/' . $this->CRUD_company->getLogo($_GET['id'])[0]['logo'];
        if (file_exists($logo_file)) {
            unlink($logo_file);
        }
        $this->CRUD_company->delete(array($_GET['id']));
        header('Location: companiesActions.php');
    }

    function createAddress()
    {

        $address_label = htmlspecialchars($_POST['label']);
        $address_postal_code = htmlspecialchars($_POST['postal_code']);
        $address_city = htmlspecialchars($_POST['city']);

        if (count($this->CRUD_address->getFromCompanyAndInfos($_GET['id'], $address_label, $address_postal_code, $address_city)) == 0) {

            $address_id = $this->CRUD_address->create(array($address_label, $address_postal_code, $address_city));

            $this->CRUD_localities->create(array($address_id, $_GET['id']));
        } else {
            $this->errorMsg = 'Addresse déjà existante';
        }
    }

    function deleteAddress()
    {

        $address_id = htmlspecialchars($_POST['address']);

        $this->CRUD_localities->delete(array($address_id, $_GET['id']));

        $this->CRUD_address->delete(array($address_id));
    }



    function addActivity()
    {

        $activity_id = htmlspecialchars($_POST['activity']);

        if (count($this->CRUD_activity->getRelation($activity_id, $_GET['id'])) == 0) {
            $this->CRUD_activity->addToCompany($activity_id, $_GET['id']);
        } else {
            $this->errorMsg = 'Activité déjà ajoutée';
        }
    }

    function removeActivity()
    {


        $activity_id = htmlspecialchars($_POST['id_activity']);

        $this->CRUD_activity->removeFromCompany($activity_id, $_GET['id']);
    }

    function displayOne()
    {
        $company = $this->CRUD_company->getById($_GET['id'])[0];

        if (count($company) == 0) {
            $this->errorMsg = 'Entreprise introuvable ...';
            $this->displayAll();
        } else {
            $addresses = $this->CRUD_localities->get(array($_GET['id']));

            $activities = $this->CRUD_activity->get(0);

            $company_activities = $this->CRUD_activity->getCompanyActivities($_GET['id']);

            $edit = isset($_GET['edit']) && ($_SESSION['id_user'] == $company['id_user'] || $_SESSION['id_role'] == 1);

            $this->display->displayCompany($this->errorMsg, $company, $addresses, $company_activities, $activities, $edit);
        }
    }

    function displayAll()
    {

        $allCompanies = $this->CRUD_company->get(0);

        $companies = array();
        foreach ($allCompanies as $company) {
            $company['addresses'] = $this->CRUD_localities->get(array($company['id_company']));
            $companies[] = $company;
        }
        $allCompanies = $companies;

        $newcompanies = array();
        foreach ($allCompanies as $company) {
            if (($company['id_user'] == $_SESSION['id_user'] || $_SESSION['id_role'] == 1) || $company['active'] == 'on') {
                $newcompanies[] = $company;
            }
        }
        $allCompanies = $newcompanies;

        if (isset($_GET['search']) and !empty($_GET['search'])) {   // Si l'utilisateur recherche bien et que sa recherche n'est pas vide
            $search = htmlspecialchars($_GET['search']); // Nous gardons la recherche en mettant tout les caractères en minuscule
            $newcompanies = array();    // Initialisation d'une vartiable temporaire
            foreach ($allCompanies as $company) {  // Pour chaque utilisateur dans la liste des utilisateurs auquels nous nous intéressont
                if (strpos(strtolower($company['company_name']), strtolower($search)) !== false || 
                strpos(strtolower($company['email']), strtolower($search)) !== false || 
                strpos(strtolower(implode(array_column($company['addresses'], 'label'))), strtolower($search)) !== false ||
                strpos(strtolower(implode(array_column($company['addresses'], 'postal_code'))), strtolower($search)) !== false ||
                strpos(strtolower(implode(array_column($company['addresses'], 'city_name'))), strtolower($search)) !== false) {
                    // Si le recherche coincide avec le nom, le prénom ou l'adresse mail de l'utilisateur
                    $newcompanies[] = $company;    // Nous ajoutons l'utilisateur à la variable temporaire
                }
            }
            $allCompanies = $newcompanies; // Comme nous nous intéresseront qu'aux utilisateurs qui coincide avec la recherche nous pouvons écraser la dernière liste des utilisateurs
        } else {
            $search = ""; // Sinon la recherche est vide et nous gardons tous les utilisateurs
        }

        if (!isset($_GET['userNumberByPage']) || empty($_GET['userNumberByPage']) || $_GET['userNumberByPage'] < 1) {
            // Si la nombre donné d'utilisateur maximum par page n'est pas initialisé, est vide ou est inférieur à 1
            $nbByPage = 4;  // Nous donnons alors comme valeur initiale 4
        } else {
            $nbByPage = intval($_GET['userNumberByPage']); // Sinon on intègre le nombre demandé
        }

        if ($nbByPage > count($allCompanies)) { // Si le nombre de utilisateurs maximum par page est supérieur au nombre d'utilisateur dont on s'intéresse
            $nbByPage = count($allCompanies);   // On initialise le nombre de utilisateurs maximum par page au nombre d'utilisateur dont on s'intéresse
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

        $maxPage = ceil(count($allCompanies) / $nbByPage);
        // On affecte à une variable le nombre de page maximum on divisant le nombre d'utilisateur dont on s'intéresse par le nombre d'utilisateur par page maximum

        if ($page > $maxPage) { // Si la page demandé est supérieur au nombre de pages maximum
            $page = $maxPage;   // On remplace sa valeur par le nombre de pages maximum
        }

        // Nous allons maintenant nous intéresser aux utilisateurs de la page actuelle
        $newcompanies = array();    // On initialise une variable temporaire
        for ($i = $nbByPage * ($page - 1); $i < $nbByPage * $page; $i++) {
            // Pour i allant du nombre de utilisateurs maximum par page multiplié par la page en question moins 1
            // Jusqu'à le nombre de utilisateurs maximum par page multiplié par la page en question
            // Cette boucle va permettre de prendre seulement les utilisateurs concernés par la page et de les ajouter (s'il existent) dans la variable temporaire
            if (isset($allCompanies[$i])) {
                $newcompanies[] = $allCompanies[$i];
            }
        }
        $companies = $newcompanies; // La varialbe users contiendra donc nos utilisateurs de la page





        $this->display->displayAllCompanies($this->errorMsg, $companies, $search, $maxPage, $page, $nbByPage);
    }
}

$companies = new ControlCompanies();


if (isset($_GET['id'])) {

    if (isset($_POST['update'])) {
        $companies->update();
    }

    if (isset($_POST['delete'])) {
        $companies->delete();
    }

    if (isset($_POST['createAddress'])) {
        $companies->createAddress();
    }

    if (isset($_POST['deleteAddress'])) {
        $companies->deleteAddress();
    }

    if (isset($_POST['add_activity'])) {
        $companies->addActivity();
    }

    if (isset($_POST['remove_activity'])) {
        $companies->removeActivity();
    }

    $companies->displayOne();
} else {

    if (isset($_POST['create'])) {
        $companies->create();
    }

    $companies->displayAll();
}
