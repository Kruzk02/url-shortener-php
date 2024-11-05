<?php

namespace App\Test\Dao;

use App\Config\Database;
use App\Src\Dao\Impl\UrlDaoImpl;
use PDO;

require_once __DIR__ . '/../../src/dao/impl/UrlDaoImpl.php';
require_once __DIR__ . '/../../src/model/URL.php';

class UrlDaoImplTest {
    private $urlDao;
    private $dbMock;

    public function __construct() {
        $this -> dbMock = Database::getInstance();
        $this -> urlDao = new UrlDaoImpl();
    }

    public function testCreateShortenedUrl() {
        $code = 'testCode';
        $origin_url = 'http://example.com';

        $result = $this -> urlDao -> createShortenedUrl($origin_url, $code);
        
        assert($result === $code, 'Failed asserting that the returned code is correct.');

        $stmt = $this -> dbMock -> prepare("SELECT * FROM urls WHERE code = :code");
        $stmt -> bindParam(':code', $code);
        $stmt -> execute();
        $urlData = $stmt -> fetch(PDO::FETCH_ASSOC);

        assert($urlData !== false, 'URL was not found in the database.');
        assert($urlData['origin_url'] === $origin_url, 'Origin URL does not match.');
    }

    public function testGetOriginUrlByCode() {
        $this-> urlDao -> createShortenedUrl('http://example.com', 'testCode');

        $url = $this-> urlDao-> getOriginUrlByCode('testCode');
        
        assert($url -> getCode() === 'testCode', 'Code does not match.');
        assert($url -> getOriginUrl() === 'http://example.com', 'Origin URL does not match.');
    }

    public function testUrlExists() {
        $this -> urlDao -> createShortenedUrl('http://example.com', 'testCode');

        $exists = $this -> urlDao -> urlExsits('testCode');

        assert($exists === true, 'URL should exist but returned false.');
        
        $exists = $this -> urlDao -> urlExsits('nonExistentCode');
        assert($exists === false, 'URL should not exist but returned true.');
    }

    public function runTests() {
        $this->testCreateShortenedUrl();
        $this->testGetOriginUrlByCode();
        $this->testUrlExists();
        echo "All tests passed.\n";
    }
}
?>
