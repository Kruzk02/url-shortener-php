<?php 

namespace App\Src\Service;

use App\Src\Model\URL;

interface UrlService {

    public function getOriginByCode(string $code): URL;
    public function create(string $origin_url): string;
    
}
?>