<?php
    namespace App\Src\Utils;
    
    use App\Config\Database;

    use PDO;
    use PDOException;

    class SetupData {
        
        private bool $isSetup;
        private PDO $pdo;

        public function __construct() {
            $this -> pdo = Database::getInstance();
            $this -> isSetup = false;
        }

        public function setupTable(): bool {

            try {
                if (!$this -> isSetup) {
                    $this -> pdo -> beginTransaction();
                    $this -> pdo -> exec($this -> createURLTable());
                    $this -> pdo -> commit();
                    $this -> isSetup = true; 
                }
            } catch (PDOException $e) {
                $this -> pdo -> rollBack();
                error_log("Database setup failed: " . $e->getMessage());
            }
            
            return $this -> isSetup;
        }

        private function createURLTable(): string {
            return "CREATE TABLE IF NOT EXISTS urls (
                id SERIAL PRIMARY KEY,
                origin_url VARCHAR(255) NOT NULL UNIQUE,
                code VARCHAR(64) NOT NULL UNIQUE,
                active_count INT DEFAULT 0 CHECK (active_count >= 0),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );";
        }

        public function isSetup(): bool {
            return $this -> isSetup;
        }
    }
?>