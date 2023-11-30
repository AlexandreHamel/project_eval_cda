<?php

namespace App\Utility;

use \PDO;
use \PDOException;

class DataBase
{
    private $dsn;
    private static $_instance;

    private function __construct() {

        $configData = parse_ini_file(__DIR__ . '/../Config/config.ini');

        try{
            $this->dsn = new PDO(
                "mysql:host={$configData['DBHOST']};dbname={$configData['DBNAME']};charset=utf8",
                $configData['DBUSER'],
                $configData['DBPASSWORD']
            );

        } catch (PDOException $e){          
            die("Erreur:".$e->getMessage());
        }
    }

    public static function connectPDO()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new DataBase();
            }
            return self::$_instance->dsn;
    }
}