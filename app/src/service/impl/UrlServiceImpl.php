<?php 

namespace App\Src\Service\Impl;

use App\Src\Dao\URLDao;
use App\Src\Model\URL;
use App\Src\Service\UrlService;
use Exception;

class UrlServiceImpl implements UrlService {

    private URLDao $urlDao;
    
    public function __construct(URLDao $urlDao) {
        $this -> urlDao = $urlDao;
    }

    public function getOriginByCode(string $code): URL {
        $cachedUrl = apcu_fetch($code);

        if ($cachedUrl) {
            return $cachedUrl;
        }

        $url = $this -> urlDao -> getOriginUrlByCode($code);
        apcu_store($code, $url, 3600);
        return $url;
    }

    public function create(string $origin_url): string {
        if (!$this -> isValidUrl($origin_url)) {
            throw new Exception("The URL is either invalid or not reachable.");
        }

        try {

            $url = $this -> urlDao -> getCodeByOriginUrl($origin_url);
            if ($url -> getCode() != null) {
                return $url -> getCode();
            }

        } catch (Exception $e) {
            $hash = md5($origin_url);
            $randomLength = rand(6,15);
            $code = substr($hash, 0, $randomLength);

            return $this->urlDao->createShortenedUrl($origin_url, $code);
        }
    }
    
    private function isValidUrl(string $origin): bool {

        if (!filter_var($origin, FILTER_VALIDATE_URL)) {
            return false;
        }

        $checkIsValid = curl_init($origin);
        curl_setopt($checkIsValid, CURLOPT_NOBODY, true);
        curl_setopt($checkIsValid, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($checkIsValid, CURLOPT_TIMEOUT, 10);
        curl_setopt($checkIsValid, CURLOPT_FOLLOWLOCATION, true);
        
        curl_exec($checkIsValid);
        $httpCode = curl_getinfo($checkIsValid, CURLINFO_HTTP_CODE);
        curl_close($checkIsValid);

        return ($httpCode === 200);
    }
}
?>