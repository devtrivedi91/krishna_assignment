-- ==============================================================================
-- DevPortfolio Database Schema
-- Database Name: devportfolio
-- Target: MySQL 5.7+ / MySQL 8.0+ / MariaDB 10.3+
-- Author: B.Tech Computer Engineering Student
-- Course: Advanced Web Development in PHP (Assignment 2)
-- ==============================================================================

-- Create Database if not exists
CREATE DATABASE IF NOT EXISTS `devportfolio` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `devportfolio`;

-- ------------------------------------------------------------------------------
-- Table 1: contacts
-- Stores contact messages submitted by visitors
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read') NOT NULL DEFAULT 'unread',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_contacts_status` (`status`),
  INDEX `idx_contacts_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table 2: projects
-- Stores developer showcase projects loaded dynamically on the portfolio
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `technologies` VARCHAR(255) NOT NULL,
  `github_url` VARCHAR(255) DEFAULT NULL,
  `demo_url` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_projects_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table 3: admins
-- Stores administrator credentials for the secure admin control panel
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_admins_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Sample Projects Data
-- Initial realistic sample projects editable via admin panel or database
-- ------------------------------------------------------------------------------
INSERT INTO `projects` (`title`, `description`, `technologies`, `github_url`, `demo_url`, `image`) VALUES
(
  'RideShare Hub — Carpooling & Route Sharing Platform',
  'A full-featured carpooling web application designed for university students and commuters. Features vehicle seat availability tracking, route matching, fare-splitting calculations, driver verification, and secure trip booking workflows.',
  'PHP, MySQL, Bootstrap 5, JavaScript, OpenStreetMap API, PDO',
  'https://github.com/developer-portfolio/rideshare-hub',
  'https://rideshare-hub.example.com',
  'assets/images/projects/project-rideshare.svg'
),
(
  'EstateNexus — Modern Real Estate & Rental Portal',
  'A comprehensive property listing and tenant inquiry platform. Enables property owners to list residential and commercial units with interactive image galleries, pricing filters, amenity checklists, and direct client inquiry forms.',
  'PHP 8, MySQL, Bootstrap 5, CSS3 Glassmorphism, PDO Prepared Statements',
  'https://github.com/developer-portfolio/estatenexus',
  'https://estatenexus.example.com',
  'assets/images/projects/project-estate.svg'
),
(
  'LibroFlow — Digital Library & Member Management System',
  'An automated library management system handling catalog searches, ISBN book registrations, member borrowings, loan renewals, and automatic overdue fine calculations with administrative reporting dashboards.',
  'PHP, MySQL, Bootstrap 5, Chart.js, HTML5, AJAX',
  'https://github.com/developer-portfolio/libroflow',
  'https://libroflow.example.com',
  'assets/images/projects/project-library.svg'
),
(
  'DevPortfolio CMS — Dynamic Portfolio & Inquiry Management',
  'A responsive developer portfolio engine with dynamic MySQL project showcases, secure administrative message moderation, CSRF protection, and audit logs tailored for modern software engineers.',
  'PHP 8, MySQL, Bootstrap 5, JavaScript, PDO, Responsive UI',
  'https://github.com/developer-portfolio/devportfolio',
  '#',
  'assets/images/projects/project-devportfolio.svg'
);

-- ------------------------------------------------------------------------------
-- Initial Administrator Seed (For Local Development Only)
-- Username: admin
-- Default Password: Admin@123
-- NOTE: In production, change this password immediately or use setup_admin.php
-- ------------------------------------------------------------------------------
INSERT INTO `admins` (`username`, `password_hash`) VALUES
('admin', '$2y$12$KzPa7K/t3nwTnvlNTJ3.hOlZ5H9CChCZRmbPP/cdRCAX8VNMzzCoa')
ON DUPLICATE KEY UPDATE `username`=`username`;
