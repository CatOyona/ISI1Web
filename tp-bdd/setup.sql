CREATE DATABASE IF NOT EXISTS app_db
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE app_db;
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Compte réservé à l'application : il n'a pas le droit de modifier la structure de la base.
CREATE USER IF NOT EXISTS 'app_user'@'localhost' IDENTIFIED BY 'app_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON app_db.* TO 'app_user'@'localhost';
FLUSH PRIVILEGES;