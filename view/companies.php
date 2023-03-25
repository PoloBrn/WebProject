<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once '../assets/smarty/Smarty.class.php';
include '../includes/head.php';
include '../includes/scripts.php';

$smarty = new Smarty();

Class viewCompanies{
    
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
    }

    function displayCompany($msg,$company, $addresses, $company_activities){
        //display an user documents
        
        if (count($company)!=0){
            $company = $company[0];
        }
    
        $this->smarty->assign('company', $company);
        $this->smarty->assign('addresses', $addresses);
        $this->smarty->assign('company_activities', $company_activities);
        
    }

    function displayAllCompanies($msg, $allCompanies, $allActivities) {
        //display users

        if ($msg !="0"){
            $this->smarty->assign('errorMsg', $msg) ;
        }

        

    $this->smarty->assign('allCompanies', $allCompanies);
    $this->smarty->assign('allActivities', $allActivities);

        $this->smarty->display('../view/templates/companies.tpl');
    }
}
