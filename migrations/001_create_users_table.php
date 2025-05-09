<?php
require_once 'classes/Migration.php';

class CreateUsersTable extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB";
        
        $this->conn->exec($sql);
        $this->addMigration('001_create_users_table');
    }
    
    public function down() {
        $sql = "DROP TABLE IF EXISTS users";
        $this->conn->exec($sql);
        $this->removeMigration('001_create_users_table');
    }
} 