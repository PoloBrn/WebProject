<?php

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once '../model/CRUD_skills.php';
$skills = new \MODELE\CRUD_skills;

if (isset($_POST['skill_create'])) {

    if (!empty($_POST['skill_name'])) {
        $skill_id = $skills->create((array(htmlspecialchars($_POST['skill_name']))));

        header('Location: offer.php?skill#skill'.$skill_id);
    } else {
        $errorMsg = 'Veillez saisir le nom de la compétence';
    }
}

if (isset($_GET['skill'])) {
    $allSkills = $skills->get(0);
}