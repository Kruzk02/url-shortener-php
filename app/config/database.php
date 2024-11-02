<?php 
    namespace App\Config;
    use PDO;
    use PDOException;
    use Exception;

    class Database {
      private $conn; 

      public function __construct() {
        try {
          $this -> conn = new PDO("mysql:host=mysql;dbname=db", "user", "Password");
          $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
      }

      public function getConnect(): PDO {
        if ($this -> conn === null) {
          throw new Exception("Database connection is not established.");
        }
        return $this -> conn;
      }
    }
?>