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

        $request = $this->pdo->prepare("INSERT into promo (name, id_type, id_campus) values (?, ?, ?)");
        $request->execute(array($promo_name, $type_id, $campus_id));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
        $promo_id = $array[0];
        $promo_name = $array[1];
        $type_id = $array[2];

        $request = $this->pdo->prepare("UPDATE promo SET name = ?, id_type =?   WHERE id_promo =?");
        $request->execute(array($promo_name, $type_id, $promo_id));
    }
    function delete($array)
    {
        $promo_id = $array[0];

        $request = $this->pdo->prepare("DELETE FROM promo WHERE id_promo =?");
        $request->execute(array($promo_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare("SELECT * FROM promo");
        $request->execute();

        return $request->fetchAll();
    }


    function getByCampusID($campus_id)
    {
        $request = $this->pdo->prepare("SELECT * FROM promo join promo_type on promo.id_type = promo_type.id_type where id_campus =?");
        $request->execute(array($campus_id));

        return $request->fetchAll();
    }

    function getById($promo_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM promo join promo_type on promo.id_type = promo_type.id_type WHERE id_promo =?');
        $request->execute(array($promo_id));
        return $request->fetchAll();
    }

    function getPilotsByPromo($promo_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM affiliated join infos on affiliated.id_user = infos.id_user join users on affiliated.id_user = users.id_user WHERE id_promo = ? and id_role = 2');
        $request->execute(array($promo_id));
        return $request->fetchAll();
    }

    function getStudentsByPromo($promo_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM affiliated join infos on affiliated.id_user = infos.id_user join users on affiliated.id_user = users.id_user WHERE id_promo = ? and id_role = 3');
        $request->execute(array($promo_id));
        return $request->fetchAll();
    }

    function addUserInPromo($promo_id, $user_id)
    {
        $request = $this->pdo->prepare('INSERT into affiliated(id_user, id_promo) values (?, ?)');
        $request->execute(array($user_id, $promo_id));
    }

    function getAffiliation($promo_id, $user_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM affiliated where id_promo =? and id_user =?');
        $request->execute(array($promo_id, $user_id));

        return $request->fetchAll();
    }

    function deleteAffiliation($promo_id, $user_id)
    {
        $request = $this->pdo->prepare('DELETE FROM affiliated where id_promo =? and id_user =?');
        $request->execute(array($promo_id, $user_id));
    }

    function getPilotPromos($pilot_id)
    {
        $request = $this->pdo->prepare("SELECT id_promo FROM affiliated where id_user = ? ");
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
        $request = $this->pdo->prepare("SELECT * FROM promo join affiliated on promo.id_promo = affiliated.id_promo where id_campus =? and id_user =?");
        $request->execute(array($campus_id, $pilot_id));

        return $request->fetchAll();
    }
}
