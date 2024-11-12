<?php

namespace App\Src\Controller;

use App\Src\Service\UrlService;
use Exception;

class URLController {

    private UrlService $urlService;

    public function __construct(UrlService $urlService) {
        $this->urlService = $urlService;    
    }

    public function getOriginByCode(string $code) {
        try {
            $url = $this->urlService->getOriginByCode($code);
            header('Location: ' . $url->getOriginUrl());
            exit();
        } catch (Exception $e) {
            $this->renderView('CreateUrlView.php', ['error' => $e->getMessage()]);
        }
    }
    
    public function create(string $origin_url) {
        if (filter_var($origin_url, FILTER_VALIDATE_URL)) {
            try {
                $code = $this->urlService->create($origin_url);
                $this->renderView('UrlCodeView.php', ['code' => $code, 'origin_url' => $origin_url]);
            } catch (Exception $e) {
                $this->renderView('CreateUrlView.php', ['error' => $e->getMessage()]);
            }
        } else {
            $this->renderView('CreateUrlView.php', ['error' => "Invalid URL"]);
        }
    }

    private function renderView(string $view, array $data = []) {
        extract($data);
        include __DIR__ . "/../view/" . $view;
    }
}

?>