<?php

namespace App\Src\Dao\Impl;

use App\Config\Database;
use App\src\Dao\URLDao;
use App\Src\Model\URL;

use Exception;
use PDO;

require_once __DIR__ .'/../URLDao.php';
require_once __DIR__ .'/../../model/URL.php';

class UrlDaoImpl implements URLDao {

    private PDO $db;

    public function __construct() {
        $this -> db = Database::getInstance();
    }

    public function getOriginUrlByCode(string $code): URL {

        $sql = "SELECT id, origin_url, code FROM urls WHERE code = :code";
        $url = URL::create();

        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(':code', $code);
        $stmt -> execute();

        $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);


        if (!empty($results)) {

            $row = $results[0];
            $url -> setOriginUrl($row["origin_url"]);
            $url -> setId($row["id"]);
            $url -> setCode($row["code"]);

            $updated = "UPDATE urls SET active_count = active_count + 1 WHERE code = :code";
            $updatedStmt = $this -> db -> prepare($updated);
            $updatedStmt -> bindParam(":code", $row["code"]);
            $updatedStmt -> execute();

        } else {
            throw new Exception("Origin url not found with a code: " . $code);//TODO: Create a custom exception
        }

        return $url;

    }

    public function createShortenedUrl(string $origin_url, string $code): string {
        
        if ($this -> urlExsits($code)) {
            return $code;
        }
        
        $sql = "INSERT INTO urls(origin_url,code,active_count,created_at) VALUES (:origin_url,:code,1,NOW())";

        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":origin_url", $origin_url);
        $stmt -> bindParam(":code", $code);

        if ($stmt -> execute()) {
            return $code;
        } else {
            throw new Exception("Failed to insert URL into database.");
        }
    }

    public function getCodeByOriginUrl(string $origin_url): URL {
        
        $sql = "SELECT id, origin_url, code FROM urls WHERE origin_url = :origin_url";
        $url = URL::create();

        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(':origin_url', $origin_url);
        $stmt -> execute();

        $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);


        if (!empty($results)) {
            $row = $results[0];
            $url -> setOriginUrl($row["origin_url"]);
            $url -> setId($row["id"]);
            $url -> setCode($row["code"]);

            $updated = "UPDATE urls SET active_count = active_count + 1 WHERE origin_url = :origin_url";
            $updatedStmt = $this -> db -> prepare($updated);
            $updatedStmt -> bindParam(":origin_url", $row["origin_url"]);
            $updatedStmt -> execute();
        } else {
            throw new Exception("code not found with a origin url: " . $origin_url);//TODO: Create a custom exception
        }

        return $url;

    }

    public function urlExsits(string $code): bool {
        $sql = "SELECT EXISTS (SELECT 1 FROM urls WHERE code = :code)";

        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(':code',$code);
        $stmt -> execute();

        return (bool) $stmt -> fetchColumn();
    }

}  
?>