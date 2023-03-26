<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');

require '../model/CRUD_activities.php';
require_once '../view/activities.php';

class ControlActivities
{

    private $errorMsg, $CRUD_activities, $View_activities;

    function __construct()
    {
        $this->CRUD_activities = new \MODELE\CRUD_activities();

        $this->View_activities = new ViewActivities();
    }

    function createActivity()
    {


        $activity_name = htmlspecialchars($_POST['create_activity_name']);

        if (count($this->CRUD_activities->getByName($activity_name)) == 0) {

            $activity_id = $this->CRUD_activities->create(array($activity_name));

            header('Location: activitiesActions.php#' . $activity_id);
        }
    }

    function updateActivity()
    {

        $activity_id = htmlspecialchars($_POST['id_activity']);
        $activity_name = htmlspecialchars($_POST['name_activity']);

        $this->CRUD_activities->update(array($activity_id, $activity_name));

        header('Location: activitiesActions.php#' . $activity_id);
    }

    function delete_activity()
    {

        $activity_id = htmlspecialchars($_POST['id_activity']);

        $this->CRUD_activities->delete(array($activity_id));

        header('Location: activitiesActions.php');
    }

    function displayActivities() {

        $activities = $this->CRUD_activities->get(0);

        $this->View_activities->displayActivities($this->errorMsg, $activities);
    }
}

$Controller_activities = new ControlActivities();

if (isset($_POST['create_activity'])) {
    $Controller_activities->createActivity();
}

if (isset($_POST['update_activity'])) {
    $Controller_activities->updateActivity();
}

if (isset($_POST['delete_activity'])) {
    $Controller_activities->delete_activity();
}

$Controller_activities->displayActivities();