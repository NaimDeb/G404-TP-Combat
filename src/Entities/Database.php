<?php

// Singleton
class Database {
    private static ?PDO $instance = null;

    private function __construct() {} // Empêche l'instanciation directe

    public static function getInstance(): PDO{
        if (self::$instance === null) {

            $host = "localhost";
            $dbname = "combat";
            $login = "root";
            $password = "";

            self::$instance = new PDO("mysql:host={$host};dbname={$dbname}", $login, $password);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return self::$instance;
    }    



}


?>