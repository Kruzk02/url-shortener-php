<?php

namespace App\Src\Controller;

use App\Src\Service\UrlService;

include __DIR__ . "/../view/UrlCodeView.php";

class URLController {

    private UrlService $urlService;

    public function __construct(UrlService $urlService) {
        $this -> urlService = $urlService;    
    }

    public function getOriginByCode(string $code) {
        $origin = $this->urlService->getOriginByCode($code);
        
        if ($origin) {
            $this->renderView('UrlOriginView.php', ['origin' => $origin]);
        } else {
            $this->renderView('UrlCodeNotFoundView.php');
        }
    }
    
    public function create(string $origin_url) {
        if (filter_var($origin_url, FILTER_VALIDATE_URL)) {
            $code = $this->urlService->create($origin_url);
            $this->renderView('UrlCodeView.php', ['code' => $code]);
        } else {
            echo "Invalid URL!";
        }
    }

    private function renderView(string $view, array $data = []) {
        extract($data);
        include __DIR__ . "/../view/" . $view;
    }
}

?>