<?php

namespace MODELE;

require_once 'database.php';



class CRUD_activities extends Database
{

    function create($array)
    {
        $activity_name = $array[0];

        $request = $this->pdo->prepare('INSERT INTO activity (name) values (?)');
        $request->execute(array($activity_name));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
        $activity_id = $array[0];
        $activity_name = $array[1];

        $request = $this->pdo->prepare('UPDATE activity SET name =? WHERE id_activity =?');
        $request->execute(array($activity_name, $activity_id));
    }
    function delete($array)
    {
        $activity_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM activity WHERE id_activity =?');
        $request->execute(array($activity_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare('SELECT * FROM activity');
        $request->execute();

        return $request->fetchAll();
    }

    function getByName($activity_name)
    {
        $request = $this->pdo->prepare('SELECT * FROM activity WHERE name =?');
        $request->execute(array($activity_name));

        return $request->fetchAll();
    }

    function addToCompany($activity_id, $company_id)
    {
        $request = $this->pdo->prepare('INSERT into sector (id_company, id_activity) values (?,?)');
        $request->execute(array($company_id, $activity_id));
    }

    function removeFromCompany($activity_id, $company_id)
    {
        $request = $this->pdo->prepare('DELETE FROM sector WHERE id_company =? AND id_activity =?');
        $request->execute(array($company_id, $activity_id));
    }

    function getRelation($activity_id, $company_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM sector WHERE id_activity =? AND id_company =?');
        $request->execute(array($activity_id, $company_id));

        return $request->fetchAll();
    }

    function getCompanyActivities($company_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM sector join activity on activity.id_activity = sector.id_activity WHERE id_company =?');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }
}
