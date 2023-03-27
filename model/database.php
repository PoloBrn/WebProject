<?php

namespace MODELE;

require_once 'CRUDinterface.php';

use \PDO;
use \Exception;

abstract class Database implements CRUD
{
    protected $pdo;

    function __construct()
    {
        $bdd_config = parse_ini_file('../config/config_db.ini');
        $dsn = 'mysql:host=' . $bdd_config['hostname'] . ';dbname=' . $bdd_config['db_name'] . ';charset=utf8;'; // Serveur Localhost

        try {
            //$pdo = new PDO($dsn, 'root' , 'cesi'); // Serveur Google Cloud
            $this->pdo = new PDO($dsn, $bdd_config['user'], $bdd_config['password']); // Serveur Localhost
        } catch (Exception $e) {
            die('Une erreur a été trouvée : ' . $e->getMessage());
        }
    }
    protected static function securityCheck($var) {
                                //additionnal security on entries in database
        if (is_array($var)){
            foreach($var as $data){
                $data = trim($data);    //deletes invsible characters at start and end of string
                $data = stripslashes($data);    //deletes slashes and unquotes quoted chars
                $data = htmlspecialchars($data);    //converts special chars to html
            }
        }

        else {
            $var = trim($var);
            $var = stripslashes($var);
            $var = htmlspecialchars($var);
        }
        return $var;
    }
}


/*
$bdd_config = parse_ini_file('./config.ini');


//$dsn = 'mysql:host=34.155.93.202;dbname=web-project-v0;charset=utf8;'; // Serveur Google Cloud
$dsn = 'mysql:host='.$bdd_config['hostname'].';dbname='.$bdd_config['db_name'].';charset=utf8;'; // Serveur Localhost
//$dsn = 'mysql:host=127.0.0.1;dbname=test_web;charset=utf8;'; // Serveur Localhost de test


try {
//$pdo = new PDO($dsn, 'root' , 'cesi'); // Serveur Google Cloud
$pdo = new PDO($dsn, $bdd_config['user'] , $bdd_config['password']); // Serveur Localhost
} catch(Exception $e) {
    die('Une erreur a été trouvée : '.$e->getMessage());
}

// $Eleve_Result= mysql_query ( SELECT * FROM users ) ;
*/