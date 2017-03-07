<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Connection
{


    private static $conn = null;

    private $serveur;
    private $dbname;
    private $user;
    private $password;

    private function __construct()
    {

       /*$this->serveur = "mysql.info.unicaen.fr";
        $this->dbname = "21416699_4";
        $this->user = "21416699";
        $this->password = "xohtheghooghohku";


        $this->serveur = "localhost";
        $this->dbname = "azan";
        $this->user = "root";
        $this->password = "Serge1992";*/

       $this->serveur = "91.216.107.164";
        $this->dbname = "calen738121";
        $this->user = "calen738121";
        $this->password = "Serge1992";

        try {
            if (is_null(self::$conn)) {
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
                self::$conn = new PDO('mysql:host=' . $this->serveur . ';dbname=' . $this->dbname . '', $this->user, $this->password, $pdo_options);
            }
        }catch (PDOException $ex) {
            die('Connection échouée :' . $ex->getMessage());
        }

    }

    public static function getConnexion()
    {
        new Connection();
        return self::$conn;
    }


}