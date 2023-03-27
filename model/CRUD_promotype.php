<?php

namespace MODELE;

require_once 'database.php';

class CRUD_promotype extends Database
{

    function create($array)
    {
        $type_name = $array[0];

        $request = $this->pdo->prepare('CALL promo_type_create (?)');
        $request->execute(array($type_name));

        return $request->fetchAll()[0][0];
    }
    function update($array)
    {
        $type_name = $array[0];
        $type_id = $array[1];

        $request = $this->pdo->prepare('CALL promo_type_update (?,?)');
        $request->execute(array($type_name, $type_id));
    }
    function delete($array)
    {
        $type_id = $array[0];

        $request = $this->pdo->prepare('CALL promo_type_delete (?)');
        $request->execute(array($type_id));
    }
    function get($array)
    {
        $request = $this->pdo->prepare('CALL promo_type_select ()');
        $request->execute();

        return $request->fetchAll();
    }
    function getByName($type_name)
    {
        $request = $this->pdo->prepare('SELECT * FROM promo_type where type_name = ?');
        $request->execute(array($type_name));

        return $request->fetchAll();
    }

    function addToOffer($offer_id, $type_id)
    {
        $request = $this->pdo->prepare('INSERT INTO which_promo(id_offer, id_type) values (?,?)');
        $request->execute(array($offer_id, $type_id));
    }

    function removeFromOffer($offer_id, $type_id)
    {
        $request = $this->pdo->prepare('DELETE FROM which_promo where id_offer = ? and id_type = ?');
        $request->execute(array($offer_id, $type_id));
    }

    function getFromOffer($offer_id) {
        $request = $this->pdo->prepare('SELECT * from which_promo join promo_type on which_promo.id_type = promo_type.id_type where id_offer = ?');
        $request->execute(array($offer_id));

        return $request->fetchAll();
    }

    function getRelation($offer_id, $type_id) {
        $request = $this->pdo->prepare('SELECT * from which_promo where id_offer = ? and id_type = ?');
        $request->execute(array($offer_id, $type_id));

        return $request->fetchAll();
    }
}
