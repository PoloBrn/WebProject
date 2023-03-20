<?php

namespace MODELE;

require_once 'database.php';



class CRUD_localities extends Database
{

    function create($array)
    {
        $address_id = $array[0];
        $company_id = $array[1];

        $request = $this->pdo->prepare('INSERT INTO localities(id_address, id_company) values (?,?)');
        $request->execute(array($address_id, $company_id));

        return $address_id;
    }
    function update($array)
    {
    }
    function delete($array)
    {
        $address_id = $array[0];
        $company_id = $array[1];

        $request = $this->pdo->prepare('DELETE FROM localities WHERE id_address =? and id_company =?');
        $request->execute(array($address_id, $company_id));
    }
    function get($array)
    {
        $company_id = $array[0];

        $request = $this->pdo->prepare('SELECT * FROM address join localities on address.id_address = localities.id_address WHERE localities.id_company = ?');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }

    function getByInfos($address_id, $company_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM localities WHERE id_address =? and id_company =?');
        $request->execute(array($address_id, $company_id));

        return $request->fetchAll();
    }
}
