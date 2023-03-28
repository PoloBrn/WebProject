<?php

namespace MODELE;

use PDO;

require_once 'database.php';


class CRUD_postulate extends Database
{

    function create($array)
    {
        $offer_id = $array[0];
        $user_id = $array[1];
        $infos = $array[2];
        $file_name_cv = $array[3];
        $file_name_lm = $array[4];

        $request = $this->pdo->prepare('INSERT INTO postulate(id_user, id_offer, progress, lm, cv, infos) values (?,?,?,?,?,?)');
        $request->execute(array($user_id, $offer_id, 'Email Envoyé' ,$file_name_lm, $file_name_cv, $infos));
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

    function getByIDs($user_id, $offer_id) {
        $request = $this->pdo->prepare('SELECT * FROM postulate where id_user = ? AND id_offer = ?');
        $request->execute(array($user_id, $offer_id));

        return $request->fetchAll();
    }
}
