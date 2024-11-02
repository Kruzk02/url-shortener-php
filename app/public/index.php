<?php
namespace App\Public;

use App\Config\Database;
require __DIR__ . '/../Config/database.php';

    $db = new Database();
    $db -> getConnect();
?>