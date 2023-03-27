<?php

namespace MODELE;

require_once 'database.php';

class CRUD_skills extends Database
{

    function create($array)
    {
        $skill_name = $array[0];

        $request = $this->pdo->prepare('INSERT INTO skills(skill_name) VALUES (?)');
        $request->execute(array($skill_name));

        return $this->pdo->lastInsertId();
    }
    function update($array)
    {
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

    function addToOffer($offer_id, $skill_id) {
        $request = $this->pdo->prepare('INSERT INTO need_skill(id_offer, id_skill) values (?,?)');
        $request->execute(array($offer_id, $skill_id));
    }

    function removeFromOffer($offer_id, $skill_id) {
        $request = $this->pdo->prepare('DELETE FROM need_skill where id_offer = ? and id_skill = ?');
        $request->execute(array($offer_id, $skill_id));
    }

    function getFromOffer($offer_id) {
        $request = $this->pdo->prepare('SELECT * from need_skill join skills on skills.id_skill = need_skill.id_skill where id_offer = ?');
        $request->execute(array($offer_id));

        return $request->fetchAll();
    }

    function getRelation($offer_id, $skill_id) {
        $request = $this->pdo->prepare('SELECT * from need_skill where id_offer = ? and id_skill = ?');
        $request->execute(array($offer_id, $skill_id));

        return $request->fetchAll();
    }
}
