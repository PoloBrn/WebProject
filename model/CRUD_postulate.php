<?php

namespace MODELE;

use PDO;

require_once 'database.php';


class CRUD_postulate extends Database
{

    function create($array)
    {
        $progress = $array[2];

        $request = $this->pdo->prepare('INSERT INTO postulate(progress) values (?)');
        $request->execute(array($progress));
        $postulate_id = $this->pdo->lastInsertId();

        return $request->fetchAll()[0][0];
    }

    function update($array)
    {
        $user_id = $array[0];
        $offer_id = $array[1];
        $progress = $array[2];

        $request = $this->pdo->prepare('UPDATE postulate SET progress = ? WHERE id_user = ? AND id_offer = ?');
        $request->execute(array($progress, $user_id, $offer_id));
    }

    function delete($array)
    {
        $user_id = $array[0];
        $offer_id = $array[1];
        $progress = $array[2];

        $request = $this->pdo->prepare('DELETE FROM postulate WHERE id_user = ? AND id_offer = ?');
        $request->execute(array($user_id, $offer_id));
    }

    function get($array)
    {
        $user_id = $array[0];
        $offer_id = $array[1];
        $request = $this->pdo->prepare('SELECT * FROM postulate WHERE id_user = ? AND id_offer = ?');
        $request->execute(array($user_id, $offer_id));
        return $request->fetchAll();
    }
}
