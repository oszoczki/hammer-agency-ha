<?php
class Migration {
    protected $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function up() {
        // To be implemented by child classes
    }
    
    public function down() {
        // To be implemented by child classes
    }
    
    public function createMigrationsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB";
        
        $this->conn->exec($sql);
    }
    
    public function hasMigration($migration) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
        $stmt->execute([$migration]);

        return $stmt->fetchColumn() > 0;
    }
    
    public function addMigration($migration) {
        $stmt = $this->conn->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migration]);
    }
    
    public function removeMigration($migration) {
        $stmt = $this->conn->prepare("DELETE FROM migrations WHERE migration = ?");
        $stmt->execute([$migration]);
    }
} 