<?php

namespace MODELE;

require_once 'database.php';

class CRUD_promotype extends Database
{

    function create($array)
    {
        $type_name = $array[0];

        $request = $this->pdo->prepare('CALL promo_type_create (?)');
        $request->execute(array($type_name));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $type_name = $array[0];
        $type_id = $array[1];

        $request = $this->pdo->prepare('CALL promo_type_update (?,?)');
        $request->execute(array($type_name, $type_id));
    }
    function delete($array)
    {
        $type_id = $array[0];

        $request = $this->pdo->prepare('CALL promo_type_delete (?)');
        $request->execute(array($type_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare('CALL promo_type_select ()');
        $request->execute();

        return $request->fetchAll();
    }
}
