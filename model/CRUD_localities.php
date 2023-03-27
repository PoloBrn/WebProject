<?php

namespace MODELE;

require_once 'database.php';



class CRUD_localities extends Database
{

    function create($array)
    {
        $array = $this->securityCheck($array);

        $address_id = $array[0];
        $company_id = $array[1];

        $request = $this->pdo->prepare('CALL localities_create (?,?)');
        $request->execute(array($address_id, $company_id));
    }

    function update($array)
    {
    }

    function delete($array)
    {
        $array = $this->securityCheck($array);

        $address_id = $array[0];
        $company_id = $array[1];

        $request = $this->pdo->prepare('CALL localities_delete (?,?)');
        $request->execute(array($address_id, $company_id));
    }

    function get($array)
    {
        $array = $this->securityCheck($array);

        $company_id = $array[0];

        $request = $this->pdo->prepare('CALL localities_select (?)');
        $request->execute(array($company_id));

        return $request->fetchAll();
    }

    function getByInfos($address_id, $company_id)
    {
        $address_id = $this->securityCheck($address_id);
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL localities_getByInfos (?,?)');
        $request->execute(array($address_id, $company_id));

        return $request->fetchAll();
    }
}
