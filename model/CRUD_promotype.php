<?php

namespace MODELE;

require_once 'database.php';

class CRUD_promotype extends Database
{

    function create($array)
    {
        $type_name = $array[0];

        $request = $this->pdo->prepare('INSERT INTO promo_type (name) VALUES (?)');
        $request->execute(array($type_name));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
        $type_name = $array[0];
        $type_id = $array[1];

        $request = $this->pdo->prepare('UPDATE promo_type SET name = ? WHERE id_type = ?');
        $request->execute(array($type_name, $type_id));
    }
    function delete($array)
    {
        $type_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM promo_type WHERE  id_type =?');
        $request->execute(array($type_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare('SELECT * FROM promo_type');
        $request->execute();

        return $request->fetchAll();
    }
}
