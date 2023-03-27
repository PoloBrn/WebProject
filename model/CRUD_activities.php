<?php

namespace MODELE;

require_once 'database.php';



class CRUD_activities extends Database
{

    function create($array)
    {
        $array = $this->securityCheck($array);

        $activity_name = $array[0];

        $request = $this->pdo->prepare('CALL activity_create (?)');
        $request->execute(array($activity_name));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $array = $this->securityCheck($array);

        $activity_id = $array[0];
        $activity_name = $array[1];

        $request = $this->pdo->prepare('CALL activity_update (?,?)');
        $request->execute(array($activity_name, $activity_id));
    }
    function delete($array)
    {
        $array = $this->securityCheck($array);

        $activity_id = $array[0];

        $request = $this->pdo->prepare('CALL activity_delete (?)');
        $request->execute(array($activity_id));
    }
    function get($array)
    {
        $array = $this->securityCheck($array);

        $request = $this->pdo->prepare('CALL activity_select ()');
        $request->execute();

        return $request->fetchAll();
    }

    function getByName($activity_name)
    {
        $activity_name = $this->securityCheck($activity_name);

        $request = $this->pdo->prepare('CALL activity_getByName (?)');
        $request->execute(array($activity_name));

        return $request->fetchAll();
    }

    function addToCompany($activity_id, $company_id)
    {
        $activity_id = $this->securityCheck($activity_id);
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL sector_addToCompany (?,?)');
        $request->execute(array($company_id, $activity_id));
    }

    function removeFromCompany($activity_id, $company_id)
    {
        $activity_id = $this->securityCheck($activity_id);
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL sector_removeFromCompany (?,?)');
        $request->execute(array($company_id, $activity_id));
    }

    function getRelation($activity_id, $company_id)
    {
        $activity_id = $this->securityCheck($activity_id);
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL sector_getRelation (?,?)');
        $request->execute(array($activity_id, $company_id));

        return $request->fetchAll();
    }

    function getCompanyActivities($company_id)
    {
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL sector_getCompanyActivities (?)');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }
}
