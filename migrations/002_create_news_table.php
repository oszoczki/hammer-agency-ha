<?php
require_once 'classes/Migration.php';

class CreateNewsTable extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS news (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            author VARCHAR(100) NOT NULL,
            intro_text TEXT NOT NULL,
            full_text TEXT NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB";
        
        $this->conn->exec($sql);
        
        $this->conn->exec("CREATE INDEX IF NOT EXISTS idx_news_title ON news(title)");
        $this->conn->exec("CREATE INDEX IF NOT EXISTS idx_news_created_at ON news(created_at)");
        $this->conn->exec("CREATE INDEX IF NOT EXISTS idx_users_username ON users(username)");
        
        $this->addMigration('002_create_news_table');
    }
    
    public function down() {
        $sql = "DROP TABLE IF EXISTS news";
        $this->conn->exec($sql);
        $this->removeMigration('002_create_news_table');
    }
} 