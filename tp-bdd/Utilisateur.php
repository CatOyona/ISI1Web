<?php
    declare(strict_types=1);
    enum Role: string {
        case Admin = 'admin';
        case User = 'user';
    }

    final readonly class Utilisateur {
        public function __construct(
        public int $id,
        public string $username,
        public Role $role) {}

        /** @param array<string, mixed> $ligne une ligne de la table users */
        public static function depuisLigne(array $ligne): self {
            return new self(
            id: (int) $ligne['id'],
            username: (string) $ligne['username'],
            role: Role::tryFrom((string) ($ligne['role'] ?? '')) ?? Role::User,
            );
        }

        public function estAdmin(): bool {
            return $this->role === Role::Admin;
        }
    }