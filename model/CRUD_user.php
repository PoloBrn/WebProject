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

        $request = $this->pdo->prepare('INSERT INTO users(email, password, id_role) values (?, ?, ?)');
        $request->execute(array($user_email, $user_password, $user_role));
        $user_id = $this->pdo->lastInsertId();

        $request = $this->pdo->prepare('INSERT INTO infos(id_user, first_name, last_name, id_address) values (?, ?, ?, ?)');
        $request->execute(array($user_id, $user_first_name, $user_last_name, $address_id));

        return $user_id;
    }

    function update($array)
    {
        $user_id = $array[0];
        $user_first_name = $array[1];
        $user_last_name = $array[2];
        $user_email = $array[3];

        $request = $this->pdo->prepare('UPDATE users SET email = ? WHERE id_user =?');
        $request->execute(array($user_email, $user_id));

        $request = $this->pdo->prepare('UPDATE infos SET first_name =?, last_name =? WHERE id_user =?');
        $request->execute(array($user_first_name, $user_last_name, $user_id));
    }

    function delete($array)
    {
        $user_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM users WHERE id_user = ?');
        $request->execute(array($user_id));
    }

    function get($array)
    {
        $user_id = $array[0];
        $request = $this->pdo->prepare('SELECT * FROM users join infos on users.id_user = infos.id_user join address on infos.id_address = address.id_address where users.id_user = ?');
        $request->execute(array($user_id));
        return $request->fetchAll();
    }

    function updatePassword($user_id, $user_password){
        $request = $this->pdo->prepare('UPDATE users SET password =? WHERE id_user =?');
        $request->execute(array($user_password, $user_id));
    }

    function getUserInfos($user_email)
    {
        $request = $this->pdo->prepare("SELECT * FROM users join infos on infos.id_user = users.id_user WHERE email = ?");
        $request->execute(array($user_email));
        return $request->fetchAll();
    }

    function getStudents() {
        $request = $this->pdo->prepare("SELECT * FROM users join infos on infos.id_user = users.id_user where id_role = 3");
        $request->execute();
        return $request->fetchAll();
    }

    function getPilots() {
        $request = $this->pdo->prepare("SELECT * FROM users join infos on infos.id_user = users.id_user where id_role = 2");
        $request->execute();
        return $request->fetchAll();
    }

    function getStudentsAndPilots() {
        $request = $this->pdo->prepare("SELECT * FROM users join infos on infos.id_user = users.id_user where id_role = 3 or id_role = 2");
        $request->execute();
        return $request->fetchAll();
    }

    
}
