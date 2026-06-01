CREATE DATABASE IF NOT EXISTS cityalert CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cityalert;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS incident_history;
DROP TABLE IF EXISTS incidents;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('citoyen', 'agent', 'admin') NOT NULL DEFAULT 'citoyen',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE incidents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('voirie', 'eclairage', 'dechets', 'eau') NOT NULL,
    address VARCHAR(255) NOT NULL,
    status ENUM('Nouveau', 'En cours', 'Résolu', 'Rejeté') NOT NULL DEFAULT 'Nouveau',
    user_id INT NOT NULL,
    agent_id INT NULL,
    priority VARCHAR(50) DEFAULT 'Normal',
    resolution_deadline INT DEFAULT 7,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE incident_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incident_id INT NOT NULL,
    status_changed VARCHAR(50) NOT NULL,
    agent_id INT NOT NULL,
    comment TEXT NOT NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incident_id) REFERENCES incidents(id) ON DELETE CASCADE,
    FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incident_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incident_id) REFERENCES incidents(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Comptes de démonstration obligatoires (Mot de passe : password)
INSERT INTO users (name, email, password, role) VALUES 
('Agent Municipal', 'agent@cityalert.sn', '$2y$10$wK8f6mB7pYy5M2EubXG2G.A8GjW6rV1Gj7M3yO5Mhg1Zf8S1y2W1i', 'agent'),
('Directeur Admin', 'admin@cityalert.sn', '$2y$10$wK8f6mB7pYy5M2EubXG2G.A8GjW6rV1Gj7M3yO5Mhg1Zf8S1y2W1i', 'admin');