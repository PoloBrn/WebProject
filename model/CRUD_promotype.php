<?php

namespace MODELE;

require_once 'database.php';

class CRUD_promotype extends Database
{

    function create($array)
    {
        
        $array = $this->securityCheck($array);

        $type_name = $array[0];

        $request = $this->pdo->prepare('CALL promo_type_create (?)');
        $request->execute(array($type_name));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        
        $array = $this->securityCheck($array);

        $type_name = $array[0];
        $type_id = $array[1];

        $request = $this->pdo->prepare('CALL promo_type_update (?,?)');
        $request->execute(array($type_name, $type_id));
    }
    function delete($array)
    {
        
        $array = $this->securityCheck($array);

        $type_id = $array[0];

        $request = $this->pdo->prepare('CALL promo_type_delete (?)');
        $request->execute(array($type_id));
    }
    function get($array)
    {
        
        $array = $this->securityCheck($array);

        $request = $this->pdo->prepare('CALL promo_type_select ()');
        $request->execute();

        return $request->fetchAll();
    }
    function getByName($type_name) {
        
        $type_name = $this->securityCheck($type_name);

        $request = $this->pdo->prepare('SELECT * FROM promo_type where type_name = ?');
        $request->execute(array($type_name));

        return $request->fetchAll();
    }
}
