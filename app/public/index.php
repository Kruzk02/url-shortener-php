<?php
namespace App\Public;

use App\Config\Database;
use Exception;
require_once __DIR__ . '/../Config/database.php';

try {
    $db = Database::getInstance();
    Database::setCharsetEncoding();

    $sql = "SELECT VERSION();";
    $stm = $db -> prepare($sql);

    $stm -> execute();
    $result = $stm->fetchAll();
    echo $result[0][0]; 
} catch (Exception $e) {
    echo $e->getMessage();
}
?>