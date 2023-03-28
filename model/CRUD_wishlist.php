<?php

namespace MODELE;

require_once 'database.php';

class CRUD_wishlist extends Database
{

    function create($array)
    {
        $array = $this->securityCheck($array);

        $user_id = $array[0];
        $offer_id = $array[1];

        $request = $this->pdo->prepare('INSERT INTO wish(id_user, id_offer) VALUES (?,?)');
        $request->execute(array($user_id, $offer_id));
    }
    function update($array)
    {
    }
    function delete($array)
    {
        $array = $this->securityCheck($array);

        $user_id = $array[0];
        $offer_id = $array[1];

        $request = $this->pdo->prepare('DELETE FROM wish where id_user = ? and id_offer = ?');
        $request->execute(array($user_id, $offer_id));
    }
    function get($array)
    {
        
        $array = $this->securityCheck($array);
        
        $request = $this->pdo->prepare('SELECT * FROM wish');
        $request->execute();

        return $request->fetchAll();
    }

    function getFromOffer($offer_id) {
        $request = $this->pdo->prepare('SELECT * from wish where id_offer = ?');
        $request->execute(array($offer_id));

        return $request->fetchAll();
    }

    function getFromUser($user_id) {
        $request = $this->pdo->prepare('SELECT * from wish where id_user = ?');
        $request->execute(array($user_id));

        return $request->fetchAll();
    }

    function getRelation($offer_id, $user_id) {
        $request = $this->pdo->prepare('SELECT * from wish where id_offer = ? and id_user = ?');
        $request->execute(array($offer_id, $user_id));

        return $request->fetchAll();
    }
}
