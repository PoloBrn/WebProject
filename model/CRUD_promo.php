<?php

namespace MODELE;

require_once 'database.php';

class CRUD_promo extends Database
{

    function create($array)
    {
        $promo_name = $array[0];
        $type_id = $array[1];
        $campus_id = $array[2];

        $request = $this->pdo->prepare("CALL promo_create (?,?,?)");
        $request->execute(array($promo_name, $type_id, $campus_id));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $promo_id = $array[0];
        $promo_name = $array[1];
        $type_id = $array[2];

        $request = $this->pdo->prepare("CALL promo_update (?,?, ?)");
        $request->execute(array($promo_name, $type_id, $promo_id));
    }
    function delete($array)
    {
        $promo_id = $array[0];

        $request = $this->pdo->prepare("CALL promo_delete (?)");
        $request->execute(array($promo_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare("CALL promo_select ()");
        $request->execute();

        return $request->fetchAll();
    }


    function getByCampusID($campus_id)
    {
        $request = $this->pdo->prepare("CALL promo_getByCampusID (?)");
        $request->execute(array($campus_id));

        return $request->fetchAll();
    }

    function getById($promo_id)
    {
        $request = $this->pdo->prepare('CALL promo_getById (?)');
        $request->execute(array($promo_id));
        return $request->fetchAll();
    }

    function getPilotsByPromo($promo_id)
    {
        $request = $this->pdo->prepare('CALL promo_getPilotsByPromo (?)');
        $request->execute(array($promo_id));
        return $request->fetchAll();
    }

    function getStudentsByPromo($promo_id)
    {
        $request = $this->pdo->prepare('CALL promo_getStudentsByPromo (?)');
        $request->execute(array($promo_id));
        return $request->fetchAll();
    }

    function addUserInPromo($promo_id, $user_id)
    {
        $request = $this->pdo->prepare('CALL promo_addUserInPromo (?,?)');
        $request->execute(array($user_id, $promo_id));
    }

    function getAffiliation($promo_id, $user_id)
    {
        $request = $this->pdo->prepare('CALL promo_getAffiliation (?,?)');
        $request->execute(array($promo_id, $user_id));

        return $request->fetchAll();
    }

    function deleteAffiliation($promo_id, $user_id)
    {
        $request = $this->pdo->prepare('CALL promo_deleteAffiliation (?,?)');
        $request->execute(array($promo_id, $user_id));
    }

    function getPilotPromos($pilot_id)
    {
        $request = $this->pdo->prepare("CALL promo_getPilotPromos (?) ");
        $request->execute(array($pilot_id));

        $array = array();

        foreach ($request->fetchAll() as $promo) {
            array_push($array, $promo['id_promo']);
        }

        return $array;
    }

    function getStudentsOfPilot($pilot_id)
    {
        $students = array();
        foreach ($this->getPilotPromos($pilot_id) as $promo_id) {
            foreach ($this->getStudentsByPromo($promo_id) as $student) {
                array_push($students, $student);
            }
        }
        return $students;
    }

    function getPromoByIDcampusAndPilot($campus_id, $pilot_id) {
        $request = $this->pdo->prepare("CALL promo_getPromoByIDcampusAndPilot (?,?)");
        $request->execute(array($campus_id, $pilot_id));

        return $request->fetchAll();
    }
}
