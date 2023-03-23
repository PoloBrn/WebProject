<?php

namespace MODELE;

require_once 'database.php';


class CRUD_user extends Database
{

    function create($array)
    {
        $user_first_name = $array[0];
        $user_last_name = $array[1];
        $user_email = $array[2];
        $user_password = $array[3];
        $user_role = $array[4];
        $address_id = $array[5];

        $request = $this->pdo->prepare('CALL users_create (?, ?, ?)');
        $request->execute(array($user_email, $user_password, $user_role));
        //$user_id = $this->pdo->lastInsertId();
        $user_id = $request->fetchAll()[0][0];

        $request = $this->pdo->prepare('CALL infos_create (?, ?, ?, ?)');
        $request->execute(array($user_id, $user_first_name, $user_last_name, $address_id));

        return $request->fetchAll()[0][0];
    }

    function update($array)
    {
        $user_id = $array[0];
        $user_first_name = $array[1];
        $user_last_name = $array[2];
        $user_email = $array[3];

        $request = $this->pdo->prepare('CALL users_update (?, ?)');
        $request->execute(array($user_email, $user_id));

        $request = $this->pdo->prepare('CALL infos_update (?, ?, ?)');
        $request->execute(array($user_first_name, $user_last_name, $user_id));
    }

    function delete($array)
    {
        $user_id = $array[0];

        $request = $this->pdo->prepare('CALL users_delete (?)');
        $request->execute(array($user_id));
    }

    function get($array)
    {
        $user_id = $array[0];
        $request = $this->pdo->prepare('CALL users_select (?)');
        $request->execute(array($user_id));
        return $request->fetchAll();
    }

    function updatePassword($user_id, $user_password){
        $request = $this->pdo->prepare('CALL users_updatePassword (?,?)');
        $request->execute(array($user_password, $user_id));
    }

    function getUserInfos($user_email)
    {
        $request = $this->pdo->prepare("CALL users_getUserInfos (?)");
        $request->execute(array($user_email));
        return $request->fetchAll();
    }

    function getStudents() {
        $request = $this->pdo->prepare("CALL users_getStudents ()");
        $request->execute();
        return $request->fetchAll();
    }

    function getPilots() {
        $request = $this->pdo->prepare("CALL users_getPilots ()");
        $request->execute();
        return $request->fetchAll();
    }

    function getStudentsAndPilots() {
        $request = $this->pdo->prepare("CALL users_getStudentsAndPilots ()");
        $request->execute();
        return $request->fetchAll();
    }

    
}
