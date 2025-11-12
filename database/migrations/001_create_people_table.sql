-- Migration: Create people table
-- Created: 2025-11-11

CREATE TABLE IF NOT EXISTS `people` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `telefone` VARCHAR(20),
  `cpf` VARCHAR(14) UNIQUE,
  `dataNascimento` DATE,
  `endereco` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_nome` (`nome`),
  INDEX `idx_email` (`email`),
  INDEX `idx_cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
