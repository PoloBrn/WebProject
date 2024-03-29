<?php

namespace MODELE;

require_once 'database.php';

class CRUD_company extends Database
{

    function create($array)
    {
        $array = $this->securityCheck($array);

        $company_name = $array[0];
        $company_mail = $array[1];
        $company_nb_student = $array[2];
        $company_id_user = $array[3];

        $request = $this->pdo->prepare('CALL company_create (?, ?, ?, ?)');
        $request->execute(array($company_name, $company_mail, $company_nb_student, $company_id_user));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $array = $this->securityCheck($array);

        $company_name = $array[0];
        $company_mail = $array[1];
        $company_nb_student = $array[2];
        $company_active = $array[3];
        $company_description = $array[4];
        $company_id = $array[5];

        $request = $this->pdo->prepare('CALL company_update (?,?,?,?,?,?)');
        $request->execute(array($company_name, $company_mail, $company_nb_student, $company_active, $company_description, $company_id));
    }

    function delete($array)
    {
        $array = $this->securityCheck($array);

        $company_id = $array[0];

        $request = $this->pdo->prepare('CALL company_delete (?)');
        $request->execute(array($company_id));
    }

    function get($array)
    {
        $array = $this->securityCheck($array);

        $request = $this->pdo->prepare('CALL company_select ()');
        $request->execute();
        return $request->fetchAll();
    }

    function getByInfos($company_name, $company_mail)
    {
        $company_name = $this->securityCheck($company_name);
        $company_mail = $this->securityCheck($company_mail);

        $request = $this->pdo->prepare('CALL company_getByInfos (?,?)');
        $request->execute(array($company_name, $company_mail));
        return $request->fetchAll();
    }

    function getById($company_id)
    {
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL company_getById (?)');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }

    function updateLogo($logo_name, $company_id)
    {

        $logo_name = $this->securityCheck($logo_name);
        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL company_updateLogo (?,?)');
        $request->execute(array($logo_name, $company_id));
    }

    function getLogo($company_id)
    {

        $company_id = $this->securityCheck($company_id);

        $request = $this->pdo->prepare('CALL company_getLogo (?)');
        $request->execute(array($company_id));

        return $request->fetchAll();
    }

    function addFeedback($user_id, $company_id, $rate, $comment)
    {
        $request = $this->pdo->prepare('INSERT INTO feedback (id_user, id_company, rate, comment) values (?,?,?,?)');
        $request->execute(array($user_id, $company_id, $rate, $comment));

        return $this->pdo->lastInsertId();
    }

    function getFeedback($company_id)
    {
        $request = $this->pdo->prepare('SELECT * from feedback join infos on infos.id_user = feedback.id_user WHERE id_company = ?');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }

    function getFBfromIDs($user_id, $company_id)
    {
        $request = $this->pdo->prepare('SELECT * from feedback WHERE id_user = ? and id_company = ?');
        $request->execute(array($user_id, $company_id));
        return $request->fetchAll();
    }

    function editFeedback($user_id, $company_id, $rate, $comment) {
        $request = $this->pdo->prepare('UPDATE feedback SET rate = ?, comment = ? WHERE id_user = ? and id_company = ?');
        $request->execute(array($rate, $comment, $user_id, $company_id));
    }

    function deleteFeedback($user_id, $company_id) {
        $request = $this->pdo->prepare('DELETE FROM feedback WHERE id_user = ? and id_company = ?');
        $request->execute(array($user_id, $company_id));
    }
}
