<?php
/**
 * DevPortfolio - Shared Header & Navigation Template
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$baseUrl = get_base_url();
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '');
$isAdmin = is_admin_logged_in();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | DevPortfolio' : 'DevPortfolio — B.Tech Computer Engineering Portfolio' ?></title>
    <meta name="description" content="<?= isset($metaDescription) ? e($metaDescription) : 'Dynamic developer portfolio website built with PHP and MySQL for Advanced Web Development in PHP.' ?>">
    
    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons 1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom DevPortfolio Styles -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand" href="<?= $baseUrl ?>/index.php">
                <div class="brand-icon">
                    <i class="bi bi-code-slash"></i>
                </div>
                <div>
                    <span class="gradient-text">DevPortfolio</span>
                    <span class="d-none d-sm-block text-muted" style="font-size: 0.7rem; font-weight: 500; letter-spacing: 0.05em;">B.TECH COMPUTER ENG.</span>
                </div>
            </a>

            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#portfolioNavbar" aria-controls="portfolioNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-light fs-2"></i>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="portfolioNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'index.php' || $currentPage === '') ? 'active' : '' ?>" href="<?= $baseUrl ?>/index.php">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'about.php') ? 'active' : '' ?>" href="<?= $baseUrl ?>/about.php">
                            <i class="bi bi-person me-1"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'skills.php') ? 'active' : '' ?>" href="<?= $baseUrl ?>/skills.php">
                            <i class="bi bi-cpu me-1"></i> Skills
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'projects.php') ? 'active' : '' ?>" href="<?= $baseUrl ?>/projects.php">
                            <i class="bi bi-folder2 me-1"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>" href="<?= $baseUrl ?>/contact.php">
                            <i class="bi bi-envelope me-1"></i> Contact
                        </a>
                    </li>

                    <!-- Admin Portal Button -->
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <?php if ($isAdmin): ?>
                            <a class="btn btn-sm btn-outline-violet d-inline-flex align-items-center gap-1" href="<?= $baseUrl ?>/admin/dashboard.php">
                                <i class="bi bi-speedometer2"></i> Admin Panel
                            </a>
                        <?php else: ?>
                            <a class="btn btn-sm btn-outline-violet d-inline-flex align-items-center gap-1" href="<?= $baseUrl ?>/admin/login.php" title="Administrative Access">
                                <i class="bi bi-shield-lock"></i> Admin
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Global Flash Notification Messages -->
    <div class="container mt-3">
        <?= render_flash_messages() ?>
    </div>

    <!-- Main Content Wrapper -->
    <main>
