<?php
require_once 'config/database.php';
require_once 'classes/Migration.php';
require_once 'migrations/001_create_users_table.php';
require_once 'migrations/002_create_news_table.php';

$isRevert = in_array('--revert', $argv) || in_array('-r', $argv);

try {
    $conn->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->exec("USE " . DB_NAME);
} catch (PDOException $e) {
    die("Error creating database: " . $e->getMessage());
}

$migration = new Migration($conn);
$migration->createMigrationsTable();

$migrations = [
    ['file' => '001_create_users_table', 'instance' => new CreateUsersTable($conn)],
    ['file' => '002_create_news_table', 'instance' => new CreateNewsTable($conn)]
];

if ($isRevert) {
    $migrations = array_reverse($migrations);
    
    foreach ($migrations as $migration) {
        $fileName = $migration['file'];
        $instance = $migration['instance'];
        
        if ($instance->hasMigration($fileName)) {
            echo "Reverting migration: $fileName\n";
            $instance->down();
            echo "Migration reverted: $fileName\n";
        } else {
            echo "Migration not found: $fileName\n";
        }
    }
    
    echo "All migrations reverted successfully!\n";
} else {
    foreach ($migrations as $migration) {
        $fileName = $migration['file'];
        $instance = $migration['instance'];
        
        if (!$instance->hasMigration($fileName)) {
            echo "Running migration: $fileName\n";
            $instance->up();
            echo "Migration completed: $fileName\n";
        } else {
            echo "Migration already executed: $fileName\n";
        }
    }
    
    echo "All migrations completed successfully!\n";
}

if ($argc === 1) {
    echo "\nUsage:\n";
    echo "  php migrate.php            # Run all pending migrations\n";
    echo "  php migrate.php --revert   # Revert all migrations\n";
    echo "  php migrate.php -r         # Revert all migrations (short form)\n";
} 