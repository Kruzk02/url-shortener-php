<?php 

namespace App\Src\Model;

use DateTime;

class URL {
    
    private int $id;
    private string $origin_url;
    private string $code;
    private int $active_count;
    private DateTime $created_at;

    private function __construct() { }

    public static function create(): self {
        return new self();
    }

    public function getId(): int { return $this -> id; }
    public function setId(int $id): void { $this -> id = $id; }
    
    public function getOriginUrl(): string { return $this -> origin_url; }
    public function setOriginUrl(string $origin_url): void { $this -> origin_url = $origin_url; }

    public function getCode(): string { return $this -> code; }
    public function setCode(string $code): void { $this -> code = $code; }

    public function getActiveCount(): int { return $this -> active_count; }
    public function setActiveCount(int $active_count): void { $this -> active_count = $active_count; }

    public function getCreatedAt(): DateTime { return $this -> created_at; }
    public function setCreatedAt(DateTime $created_at): void { $this -> created_at = $created_at; }
}
?>
