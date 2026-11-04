<?php
    declare(strict_types=1);
    final class Logger {
        private static ?self $instance = null;
        private string $fichier;

        private function __construct() {
            $this->fichier = __DIR__ . '/app.log';
        }
        public static function getInstance(): self {
            return self::$instance ??= new self();
        }

        public function log(string $message): void {
            $message = str_replace(["\r", "\n"], ' ', $message);
            $date = date('Y-m-d H:i:s');
            file_put_contents($this->fichier, "[$date] $message\n", FILE_APPEND | LOCK_EX);
        }
        private function __clone() {}

        public function __wakeup(): void {
            throw new LogicException('Un singleton ne peut pas être désérialisé.');
        }
    }