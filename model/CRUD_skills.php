<?php

namespace MODELE;

require_once 'database.php';

class CRUD_skills extends Database
{

    function create($array)
    {
        $skill_name = $array[0];

        $request = $this->pdo->prepare('INSERT INTO skills(name) VALUES (?)');
        $request->execute(array($skill_name));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
    }
    function delete($array)
    {
    }
    function get($array)
    {
        $request = $this->pdo->prepare('SELECT * FROM skills');
        $request->execute();

        return $request->fetchAll();
    }
}
