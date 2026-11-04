<?php
    declare(strict_types=1);
    final class Database {
        private static ?self $instance = null;
        private PDO $connection;

        private function __construct() {
            $this->connection = new PDO(
            'mysql:host=localhost;dbname=app_db;charset=utf8mb4',
            'app_user',
            'app_password',
            [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            ]
            );
        }

        public static function getInstance(): self {
            return self::$instance ??= new self();
        }

        public function getConnection(): PDO {
            return $this->connection;
        }

        private function __clone() {}

        public function __wakeup(): void {
            throw new LogicException('Un singleton ne peut pas être désérialisé.');
        }
    }