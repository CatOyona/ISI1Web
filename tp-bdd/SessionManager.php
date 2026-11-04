<?php
    declare(strict_types=1);
    final class SessionManager {
        private static ?self $instance = null;

        private function __construct() {
            if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        }

        public static function getInstance(): self {
            return self::$instance ??= new self();
        }

        public function set(string $cle, mixed $valeur): void {
            $_SESSION[$cle] = $valeur;
        }

        public function get(string $cle): mixed {
            return $_SESSION[$cle] ?? null;
        }

        public function has(string $cle): bool {
            return isset($_SESSION[$cle]);
        }

        /** À appeler juste après une connexion réussie (contre la fixation de session). */
        public function regenerer(): void {
            session_regenerate_id(true);
        }

        public function setFlash(string $message): void {
            $_SESSION['flash'] = $message;
        }

        /** Lit le message puis le supprime : il ne s'affiche qu'une fois. */
        public function popFlash(): ?string {
            $message = $_SESSION['flash'] ?? null;
            unset($_SESSION['flash']);
            return is_string($message) ? $message : null;
        }

        public function detruire(): void {
            $_SESSION = [];
            session_destroy();
        }

        private function __clone() {}

        public function __wakeup(): void {
            throw new LogicException('Un singleton ne peut pas être désérialisé.');
        }
    }