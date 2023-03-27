<?php

namespace MODELE;

use PDO;

require_once 'database.php';


class CRUD_postulate extends Database
{

    function create($array)
    {
        $user_id = $array[0];
        $offer_id = $array[1];
        $progress = $array[2];

        $request = $this->pdo->prepare('INSERT INTO postulate(id_user, id_offer, postulate) values (id_user, id_offer, postulate);');
        $request->execute(array($progress));
        $user_id = $request->fetchAll()[0][0];

        return $request->fetchAll()[0][0];
    }

    function update($array)
    {
        $user_id = $array[0];
        $offer_id = $array[1];
        $progress = $array[2];

        $request = $this->pdo->prepare('UPDATE postulate SET id_user = _id_user WHERE id_offer = _id_offer;');
        $request->execute(array($user_id, $offer_id, $progress));
    }

    function delete($array)
    {
        $postulate_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM postulate WHERE id_user =  _id_user && id_offer = _id_offer; ');
        $request->execute(array($postulate_id));
    }

    function get($array)
    {
        $user_id = $array[0];
        $offer_id = $array[1];
        $request = $this->pdo->prepare('SELECT ');
        $request->execute(array($user_id, $offer_id));
        return $request->fetchAll();
    }

    function Postulate()
    {
        $request = $this->pdo->prepare("CALL users_getStudentsAndPilots()");
        $request->execute();
        return $request->fetchAll();
    }
}
