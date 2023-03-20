<?php

namespace MODELE;
require_once 'database.php';



class CRUD_campus extends Database
{

    function create($array)
    {
        $campus_name = $array[0];
        $address_id = $array[1];

        $request = $this->pdo->prepare('INSERT INTO campus(name, id_address) values (?,?)');
        $request->execute(array($campus_name, $address_id));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
        $campus_name = $array[0];
        $campus_id = $array[1];

        $request = $this->pdo->prepare('UPDATE campus set name =? where id_campus =?');
        $request->execute(array($campus_name, $campus_id));

    }
    function delete($array)
    {
        $campus_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM campus WHERE id_campus =?');
        $request->execute(array($campus_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare('SELECT * FROM campus join address on campus.id_address = address.id_address');
        $request->execute();

        return $request->fetchAll();
    }

    function getByInfos($campus_name)
    {
        $request = $this->pdo->prepare('SELECT * FROM campus where name = ?');
        $request->execute(array($campus_name));

        return $request->fetchAll();
    }

    function getCampusByPromo($promo_id) {
        $request = $this->pdo->prepare('SELECT campus.id_campus, campus.name FROM campus join promo on campus.id_campus = promo.id_campus where id_promo =? group by campus.id_campus');
        $request->execute(array($promo_id));

        return $request->fetchAll();
    }
}
