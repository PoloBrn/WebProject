<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once '../assets/smarty/Smarty.class.php';
include '../includes/scripts.php';

$smarty = new Smarty();

class viewCompanies
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty();
    }

    function displayCompany($errorMsg, $company, $addresses, $company_activities, $activities, $edit)
    {
        //display an user documents

        $this->smarty->assign('errorMsg', $errorMsg);
        $this->smarty->assign('company', $company);
        $this->smarty->assign('addresses', $addresses);
        $this->smarty->assign('company_activities', $company_activities);
        $this->smarty->assign('activities', $activities);

        if ($edit) {
            $this->smarty->display('../view/templates/companies/oneCompanyEdit.tpl');
        } else {
            $this->smarty->display('../view/templates/companies/oneCompany.tpl');
        }
    }

    function displayAllCompanies($msg, $companies, $search, $maxPage, $page, $nbByPage)
    {
        //display users


        $this->smarty->assign('errorMsg', $msg);




        $this->smarty->assign('companies', $companies);
        $this->smarty->assign('search', $search);
        $this->smarty->assign('maxPage', $maxPage);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('nbByPage', $nbByPage);

        $this->smarty->display('../view/templates/companies/companies.tpl');
    }
}
