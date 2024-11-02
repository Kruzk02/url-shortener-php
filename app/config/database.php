<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    private function __construct() {}

    public static function getInstance() {
        if (empty(self::$instance)) {
            $db_info = array(
                "host" => "mysql",
                "user" => "user",
                "password" => "Password",
                "name" => "db",
            );

            try {
                self::$instance = new PDO(
                    "mysql:host=".$db_info['host'].";dbname=".$db_info['name'].";charset=utf8",
                    $db_info['user'],
                    $db_info['password']
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$instance;
    }

    public static function setCharsetEncoding() {
        if (self::$instance == null) {
            self::getInstance();
        }
        self::$instance->exec(
            "SET NAMES 'utf8';
            SET character_set_connection=utf8;
            SET character_set_client=utf8;
            SET character_set_results=utf8"
        );
    }
}
?>