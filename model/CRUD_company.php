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

        $request = $this->pdo->prepare('INSERT INTO company(name, active, email, nb_student, id_user) values (?, ?, ?, ?, ?)');
        $request->execute(array($company_name, true, $company_mail, $company_nb_student, $company_id_user));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
        $company_name = $array[0];
        $company_mail = $array[1];
        $company_nb_student = $array[2];
        $company_id = $array[3];

        $request = $this->pdo->prepare('UPDATE company SET name = ?, email = ?, nb_student = ? WHERE id_company = ?');
        $request->execute(array($company_name, $company_mail, $company_nb_student, $company_id));
    }

    function delete($array)
    {
        $company_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM company WHERE id_company =?');
        $request->execute(array($company_id));
    }
    
    function get($array)
    {
        $request = $this->pdo->prepare('SELECT * FROM company order by name');
        $request->execute();
        return $request->fetchAll();
    }

    function getByInfos($company_name, $company_mail)
    {
        $request = $this->pdo->prepare('SELECT name FROM company where name = ? or email = ?');
        $request->execute(array($company_name, $company_mail));
        return $request->fetchAll();
    }

    function getById($company_id)
    {
        $request = $this->pdo->prepare('SELECT * FROM company WHERE id_company =?');
        $request->execute(array($company_id));
        return $request->fetchAll();
    }

    function updateLogo($logo_name, $company_id) {

        $request = $this->pdo->prepare('UPDATE company SET logo =? WHERE id_company =?');
        $request->execute(array($logo_name, $company_id));
    }

    function getLogo($company_id) {

        $request = $this->pdo->prepare('SELECT logo from company where id_company =?');
        $request->execute(array($company_id));

        return $request->fetchAll();
    }
}
