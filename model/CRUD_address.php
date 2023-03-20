<?php

namespace MODELE;

require_once 'database.php';



class CRUD_address extends Database
{

    function create($array)
    {
        $address_label = $array[0];
        $address_postal_code = $array[1];
        $address_city = $array[2];
        $request = $this->pdo->prepare('INSERT INTO address(name, postal_code, city_name) values (?, ?, ?)');
        $request->execute(array($address_label, $address_postal_code, $address_city));
        $address_id = $this->pdo->lastInsertId();
        return $address_id;
    }
    function update($array)
    {
        $address_label = $array[0];
        $address_postal_code = $array[1];
        $address_city = $array[2];
        $address_id = $array[3];

        $request = $this->pdo->prepare('UPDATE address SET name =?, postal_code =?, city_name =? WHERE id_address =?');
        $request->execute(array($address_label, $address_postal_code, $address_city, $address_id));
    }
    function delete($array)
    {
        $address_id = $array[0];
        $request = $this->pdo->prepare('DELETE FROM address WHERE id_address =?');
        $request->execute(array($address_id));
    }
    function get($array)
    {
    }

    function getByInfos($address_label, $address_postal_code, $address_city)
    {
        $request = $this->pdo->prepare('SELECT * FROM address WHERE name = ? and postal_code =? and city_name =?');
        $request->execute(array($address_label, $address_postal_code, $address_city));
        
        return $request->fetchAll();
    }


}
