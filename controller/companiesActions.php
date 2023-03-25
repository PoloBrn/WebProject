<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');

require '../model/CRUD_company.php';
require '../model/CRUD_address.php';
require '../model/CRUD_localities.php';
require '../model/CRUD_activities.php';

require_once '../view/companies.php';



class ControlCompanies {

    private $errorMsg, $company, $address, $localities, $activity, $display;

    function __construct(){
        

        $this->address = new \MODELE\CRUD_address();
        $this->company = new \MODELE\CRUD_company();
        $this->localities = new \MODELE\CRUD_localities();
        $this->activity = new \MODELE\CRUD_activities();

        $this->display = new viewCompanies();

        $this->errorMsg="0";
    }

    function create(){


        // Vérifiersi l'user a bien complété tous les champs
        if (!(empty($_POST['company_name']) && empty($_POST['email']) && empty($_POST['nb_student']) && empty($_FILES['logo']['name']))) {


            // Les données que l'utilisateur a entré
            $company_name = htmlspecialchars($_POST['company_name']);
            $company_mail = htmlspecialchars($_POST['email']);
            $company_nb_student = $_POST['nb_student'];
            //$company_logo = htmlspecialchars($_POST['logo']);

            // Vérifier sur l'entreprise existe dèjà sur le site
            if (count($this->company->getByInfos($company_name, $company_mail)) == 0) {
                //Insérer l'entreprise dans la bdd
                $image_size = getimagesize($_FILES['logo']['tmp_name']);
                $company_id = $this->company->create(array($company_name, $company_mail, $company_nb_student, $_SESSION['id_user']));
                if ($image_size[0] != $image_size[1]) {
                    $errorMsg = 'Image pas bonne taille : ' . $image_size[0] . ' x ' . $image_size[1] . '.php';
                } else {
                    $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                    $file_name = 'company_' . $company_id . '_logo' . '.' . $extension;
                    $path = '../assets/company-logos/' . $file_name;
                    $result = move_uploaded_file($_FILES['logo']['tmp_name'], $path);

                    $this->company->updateLogo($file_name, $company_id);
                }

                //Rediriger l'utilisateur sur la page de l'entreprise
                header('Location:companies.php#company' . $company_id);
            } else {
                $errorMsg = "L'entreprise existe déjà";
            }
        } else {
            $errorMsg = 'Veuillez compléter tous les champs';
        }
    }

    function update() {

        $company_name = htmlspecialchars($_POST['company_name']);
        $company_mail = htmlspecialchars($_POST['email']);
        $company_nb_student = $_POST['nb_student'];
        //$company_logo = htmlspecialchars($_POST['logo']);
    
        $this->company->update(array($company_name, $company_mail, $company_nb_student, $_GET['id']));
    
        if (isset($_FILES['logo']) and !empty($_FILES['logo']['name'])) {
            // Si le logo est renvoyé
            $image_size = getimagesize($_FILES['logo']['tmp_name']);
    
    
            if ($image_size[0] != $image_size[1]) {
                $errorMsg = 'Image pas bonne taille : ' . $image_size[0] . ' x ' . $image_size[1] . '.php';
            } else {
                $old_file_name = '../assets/company-logos/' . $this->company->getLogo($_GET['id'])[0]['logo'];
                if (file_exists($old_file_name)) {
                    unlink($old_file_name);
                }
                $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                $file_name = 'company_' . $_GET['id'] . '_logo' . '.' . $extension;
                $path = '../assets/company-logos/' . $file_name;
                $result = move_uploaded_file($_FILES['logo']['tmp_name'], $path);
    
                $this->company->updateLogo($file_name, $_GET['id']);
            }
        }
    
        header('Location:companies.php#company' . $_GET['id']);
    }

    function delete(){

        $logo_file = '../assets/company-logos/' . $this->company->getLogo($_GET['id'])[0]['logo'];
        if (file_exists($logo_file)) {
            unlink($logo_file);
        }
        $this->company->delete(array($_GET['id']));
        header('Location: companies.php');
    }

    function createAddress(){

        $address_label = htmlspecialchars($_POST['label']);
        $address_postal_code = htmlspecialchars($_POST['postal_code']);
        $address_city = htmlspecialchars($_POST['city']);
    
        if (count($this->address->getFromCompanyAndInfos($_GET['id'], $address_label, $address_postal_code, $address_city)) == 0) {
    
            $address_id = $this->address->create(array($address_label, $address_postal_code, $address_city));
    
            $this->localities->create(array($address_id, $_GET['id']));
        }
    }

    function deleteAddress() {

        $address_id = htmlspecialchars($_POST['address']);

        $this->localities->delete(array($address_id, $_GET['id']));
    
        $this->address->delete(array($address_id));
    }

    function createActivity(){


        $activity_name = htmlspecialchars($_POST['create_activity_name']);

        if (count($this->activity->getByName($activity_name)) == 0) {
    
            $activity_id = $this->activity->create(array($activity_name));
    
            header('Location: companies.php?activity#activity' . $activity_id);
        }
    }

    function updateActivity(){
            
        $activity_id = htmlspecialchars($_POST['id_activity']);
        $activity_name = htmlspecialchars($_POST['name_activity']);

        $this->activity->update(array($activity_id, $activity_name));

        header('Location: companies.php?activity#activity' . $activity_id);
    }

    function delete_activity(){
            
        $activity_id = htmlspecialchars($_POST['id_activity']);

        $this->activity->delete(array($activity_id));

        header('Location: companies.php?activity');
    }

    function addActivity(){

        $activity_id = htmlspecialchars($_POST['activity']);
    
        if (count($this->activity->getRelation($activity_id, $_GET['id'])) == 0) {
            $this->activity->addToCompany($activity_id, $_GET['id']);
        }

    }

    function removeActivity(){


        $activity_id = htmlspecialchars($_POST['id_activity']);

        $this->activity->removeFromCompany($activity_id, $_GET['id']);
    }

    function displayOne(){
        
        if (isset($_GET['id'])) {
            $company_infos = $this->company->getById($_GET['id']);

            $addresses = $this->localities->get(array($_GET['id']));

            $company_activities = $this->activity->getCompanyActivities($_GET['id']);

            $this->display->displayCompany($this->errorMsg, $company_infos, $addresses, $company_activities);
        }
    }

    function displayAll(){

        $allCompanies = $this->company->get(0);

        $allActivities = $this->activity->get(0);

        $this->display->displayAllCompanies($this->errorMsg, $allCompanies, $allActivities);
    }
}

$companies = new ControlCompanies();

if (isset($_POST['create'])) {
    $companies->create();
}

if (isset($_POST['update'])) {
    $companies->update();
}


if (isset($_POST['delete'])) {
    $companies->delete();
}


if (isset($_POST['createAddress'])) {
    $companies->createAddress();
}

if (isset($_POST['deleteAddress']) && isset($_POST['address'])) {
    $companies->deleteAddress();
}

if (isset($_POST['create_activity'])) {
    $companies->createActivity();
}

if (isset($_POST['update_activity'])) {
    $companies->updateActivity();
}

if (isset($_POST['delete_activity'])) {
    $companies->delete_activity();
}

if (isset($_POST['add_activity'])) {
    $companies->addActivity();
}

if (isset($_POST['remove_activity'])) {
    $companies->removeActivity();
}


if (isset($_GET['id'])) {
    $companies->displayOne();
}

$companies->displayAll();