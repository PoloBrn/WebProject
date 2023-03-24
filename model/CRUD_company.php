<?php

namespace MODELE;

require_once 'database.php';

class CRUD_company extends Database
{

    function create($array)
    {
        $company_name = $array[0];
        $company_mail = $array[1];
        $company_nb_student = $array[2];
        $company_id_user = $array[3];

        $request = $this->pdo->prepare('CALL company_create (?, ?, ?, ?, ?)');
        $request->execute(array($company_name, true, $company_mail, $company_nb_student, $company_id_user));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $company_name = $array[0];
        $company_mail = $array[1];
        $company_nb_student = $array[2];
        $company_id = $array[3];

        $request = $this->pdo->prepare('CALL company_update (?,?,?,?)');
        $request->execute(array($company_name, $company_mail, $company_nb_student, $company_id));
    }

    function delete($array)
    {
        $company_id = $array[0];

        $request = $this->pdo->prepare('CALL company_delete (?)');
        $request->execute(array($company_id));
    }
    
    function get($array)
    {
        $request = $this->pdo->prepare('CALL company_select ()');
        $request->execute();
        return $request->fetchAll();
    }

    function getByInfos($company_name, $company_mail)
    {
        $request = $this->pdo->prepare('CALL company_getByInfos (?,?)');
        $request->execute(array($company_name, $company_mail));
        return $request->fetchAll();
    }

    function getById($company_id)
    {
        $request = $this->pdo->prepare('CALL company_getById (?)');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }

    function updateLogo($logo_name, $company_id) {

        $request = $this->pdo->prepare('CALL company_updateLogo (?,?)');
        $request->execute(array($logo_name, $company_id));
    }

    function getLogo($company_id) {

        $request = $this->pdo->prepare('CALL company_getLogo (?)');
        $request->execute(array($company_id));

        return $request->fetchAll();
    }
}
