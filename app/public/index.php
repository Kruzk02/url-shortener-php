<?php
namespace App\Public;

use App\Src\Dao\Impl\UrlDaoImpl;
use App\Src\Service\Impl\UrlServiceImpl;
use App\Src\Controller\URLController;

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ .'/../src/dao/impl/UrlDaoImpl.php';
require_once __DIR__ .'/../src/service/UrlService.php';
require_once __DIR__ .'/../src/service/impl/UrlServiceImpl.php';
require_once __DIR__ . '/../src/controller/URLController.php';

$code = isset($_GET['code']) ? htmlspecialchars(trim($_GET['code'],"/"), ENT_QUOTES, 'UTF-8') : null;
$origin_url = isset($_POST['origin_url']) ? filter_var($_POST['origin_url'], FILTER_SANITIZE_URL) : '';

$controller = new URLController(new UrlServiceImpl(new UrlDaoImpl()));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller -> create($origin_url);
} else {
    if ($code != null) {
        $controller -> getOriginByCode($code);
    } else {
        include __DIR__ . '/../src/view/CreateUrlView.php';
    }
}
?>
