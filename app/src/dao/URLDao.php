<?php
    namespace App\Src\Dao;
    
    use App\Src\Model\URL;

    interface URLDao {
        
        public function getOriginUrlByCode(string $code): URL;
        public function createShortenedUrl(string $origin_url, string $code): string;
        public function getCodeByOriginUrl(string $origin_url): URL;
        public function urlExsits(string $code): bool;

    }
?>