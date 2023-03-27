<?php

namespace MODELE;

require_once 'database.php';

class CRUD_skills extends Database
{

    function create($array)
    {
        $array = $this->securityCheck($array);

        $skill_name = $array[0];

        $request = $this->pdo->prepare('INSERT INTO skills(skill_name) VALUES (?)');
        $request->execute(array($skill_name));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
    
        $array = $this->securityCheck($array);
        
        $skill_id = $array[0];
        $skill_name = $array[1];

        $request = $this->pdo->prepare('UPDATE skills SET skill_name = ? WHERE id_skill = ?');
        $request->execute(array($skill_name, $skill_id));
    }
    function delete($array)
    {
        $skill_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM skills where id_skill = ?');
        $request->execute(array($skill_id));
    }
    function get($array)
    {
        
        $array = $this->securityCheck($array);
        
        $request = $this->pdo->prepare('SELECT * FROM skills');
        $request->execute();

        return $request->fetchAll();
    }
    function getByName($skill_name)
    {
        $request = $this->pdo->prepare('SELECT * FROM skills where skill_name = ?');
        $request->execute(array($skill_name));

        return $request->fetchAll();
    }
}
