<?php

namespace MODELE;

require_once 'database.php';

class CRUD_offer extends Database
{

    function create($array)
    {
        $offer_name = $array[0];
        $offer_locality_id = $array[1];
        $offer_activity_id = $array[2];
        $offer_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $array[3])));
        $offer_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $array[4])));
        $offer_places = $array[5];
        $offer_salary = $array[6];
        $offer_description = $array[7];
        $offer_user_id = $array[8];

        $request = $this->pdo->prepare('INSERT INTO offer(offer_name, offer_active, start_date, 
        end_date, places, offer_description, salary, id_user, id_locality, id_activity) 
        values (?,?,?,?,?,?,?,?,?,?)');
        $request->execute(array($offer_name, 'on', $offer_start_date, $offer_end_date, $offer_places,
        $offer_description, $offer_salary, $offer_user_id, $offer_locality_id, $offer_activity_id));
        return $this->pdo->lastInsertId();

    }
    function update($array)
    {
        $offer_name = $array[0];
        $offer_locality_id = $array[1];
        $offer_activity_id = $array[2];
        $offer_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $array[3])));
        $offer_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $array[4])));
        $offer_places = $array[5];
        $offer_salary = $array[6];
        $offer_description = $array[7];
        $offer_active = $array[8];
        $offer_id = $array[9];

        $request = $this->pdo->prepare('UPDATE offer set offer_name = ?, offer_active = ?, start_date = ?, 
        end_date = ?, places = ?, offer_description = ?, salary = ?, id_locality = ?, id_activity = ? where id_offer = ?');
        $request->execute(array($offer_name, $offer_active, $offer_start_date, $offer_end_date, $offer_places,
        $offer_description, $offer_salary, $offer_locality_id, $offer_activity_id, $offer_id));
        
    }
    function delete($array)
    {
        $offer_id = $array[0];

        $request = $this->pdo->prepare('DELETE FROM offer where id_offer = ?');
        $request->execute(array($offer_id));
        
    }
    function get($array)
    {
        $request = $this->pdo->prepare('SELECT * FROM offer join localities 
        on offer.id_locality = localities.id_locality join company 
        on localities.id_company = company.id_company join activity 
        on activity.id_activity = offer.id_activity join address 
        on address.id_address = localities.id_address');
        $request->execute(array());
        return $request->fetchAll();
    }
}
