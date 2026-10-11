-- Database Schema for User Management System
CREATE DATABASE IF NOT EXISTS `ai_antigaravity_crud` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ai_antigaravity_crud`;

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    `phone` VARCHAR(25) DEFAULT NULL,
    `gender` ENUM('male', 'female', 'other') DEFAULT 'other',
    `bio` TEXT DEFAULT NULL,
    `avatar` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Remember Me Tokens Table (Secure Selector + Hashed Validator)
CREATE TABLE IF NOT EXISTS `user_tokens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `selector` VARCHAR(64) NOT NULL,
    `hashed_validator` VARCHAR(64) NOT NULL,
    `expiry` DATETIME NOT NULL,
    INDEX `idx_selector` (`selector`),
    CONSTRAINT `fk_user_tokens_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Sample Admin and Users
-- Passwords:
-- admin@example.com -> admin123
-- john@example.com  -> password123
-- jane@example.com  -> password123
-- robert@example.com -> password123
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `phone`, `gender`, `bio`, `avatar`, `status`, `created_at`) VALUES
(1, 'Admin', 'User', 'admin@example.com', '$2y$10$unPqv5c4J.vul.azZK0se.vDRU2wgtmVtrtoDdXvQEuFRTV2ZYcL6', 'admin', '+1 555-0199', 'other', 'System Administrator and Lead Developer.', NULL, 'active', NOW()),
(2, 'John', 'Doe', 'john@example.com', '$2y$10$e6H8t9QltPPp6BI2f7Qb7.A676kICPW682u6j4sLGNMpydbj9DQFK', 'user', '+1 555-0142', 'male', 'Full-stack software developer passionate about PHP and web tech.', NULL, 'active', NOW()),
(3, 'Jane', 'Smith', 'jane@example.com', '$2y$10$e6H8t9QltPPp6BI2f7Qb7.A676kICPW682u6j4sLGNMpydbj9DQFK', 'user', '+1 555-0188', 'female', 'UI/UX Designer who loves Bootstrap and clean designs.', NULL, 'active', NOW()),
(4, 'Robert', 'Taylor', 'robert@example.com', '$2y$10$e6H8t9QltPPp6BI2f7Qb7.A676kICPW682u6j4sLGNMpydbj9DQFK', 'user', '+1 555-0177', 'male', 'QA Engineer and automation enthusiast.', NULL, 'inactive', NOW())
ON DUPLICATE KEY UPDATE `email`=`email`;
