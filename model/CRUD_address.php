<?php

namespace MODELE;

require_once 'database.php';



class CRUD_address extends Database
{

    function create($array)
    {
        $array = $this->securityCheck($array);

        $address_label = $array[0];
        $address_postal_code = $array[1];
        $address_city = $array[2];

        $request = $this->pdo->prepare('CALL address_create (?, ?, ?)');
        $request->execute(array($address_label, $address_postal_code, $address_city));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $array = $this->securityCheck($array);

        $address_label = $array[0];
        $address_postal_code = $array[1];
        $address_city = $array[2];
        $address_id = $array[3];

        $request = $this->pdo->prepare('CALL address_update (?, ?, ? ,?)');
        $request->execute(array($address_label, $address_postal_code, $address_city, $address_id));
    }
    function delete($array)
    {
        $array = $this->securityCheck($array);

        $address_id = $array[0];
        $request = $this->pdo->prepare('CALL address_delete (?)');
        $request->execute(array($address_id));
    }
    function get($array)
    {
    }

    function getByInfos($address_label, $address_postal_code, $address_city)
    {
        $address_label = $this->securityCheck($address_label);
        $address_postal_code = $this->securityCheck($address_postal_code);
        $address_city = $this->securityCheck($address_city);

        $request = $this->pdo->prepare('CALL address_getByInfos (?, ?, ?)');
        $request->execute(array($address_label, $address_postal_code, $address_city));
        
        return $request->fetchAll();
    }

    function getFromCompanyAndInfos($company_id, $address_label, $address_postal_code, $address_city) {
        
        $company_id = $this->securityCheck($company_id);
        $address_label = $this->securityCheck($address_label);
        $address_postal_code = $this->securityCheck($address_postal_code);
        $address_city = $this->securityCheck($address_city);

        $request = $this->pdo->prepare('CALL address_getFromCompanyAndInfos (?, ?, ?, ?)');
        $request->execute(array($company_id, $address_label, $address_postal_code, $address_city));
        
        return $request->fetchAll();
    }


}
