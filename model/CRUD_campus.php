<?php

namespace MODELE;
require_once 'database.php';



class CRUD_campus extends Database
{

    function create($array)
    {
        $campus_name = $array[0];
        $address_id = $array[1];

        $request = $this->pdo->prepare('CALL campus_create (?,?)');
        $request->execute(array($campus_name, $address_id));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $campus_name = $array[0];
        $campus_id = $array[1];

        $request = $this->pdo->prepare('CALL campus_update (?,?)');
        $request->execute(array($campus_name, $campus_id));

    }
    function delete($array)
    {
        $campus_id = $array[0];

        $request = $this->pdo->prepare('CALL campus_delete (?)');
        $request->execute(array($campus_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare('CALL campus_select ()');
        $request->execute();

        return $request->fetchAll();
    }

    function getByInfos($campus_name)
    {
        $request = $this->pdo->prepare('CALL campus_getByInfos (?)');
        $request->execute(array($campus_name));

        return $request->fetchAll();
    }

    function getCampusByPromo($promo_id) {
        $request = $this->pdo->prepare('CALL campus_getCampusByPromo (?)');
        $request->execute(array($promo_id));

        return $request->fetchAll();
    }

    function getById($campus_id) {
        $request = $this->pdo->prepare('SELECT * FROM campus join address on campus.id_address = address.id_address where id_campus = ?');
        $request->execute(array($campus_id));

        return $request->fetchAll()[0];
    }
}
