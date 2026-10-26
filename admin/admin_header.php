<?php
/**
 * DevPortfolio - Admin Shared Header & Navigation
 * 
 * Enforces admin authorization check and provides admin navigation bar.
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

// Strict server-side authorization check
require_admin_login();

$baseUrl = get_base_url();
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '');
$adminUser = $_SESSION['admin_username'] ?? 'Administrator';

// Get quick stats for badge notification
$stats = get_dashboard_stats();
$unreadCount = $stats['unread_messages'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($adminTitle) ? e($adminTitle) . ' | Admin Panel' : 'Control Panel | DevPortfolio' ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons 1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Admin Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top" aria-label="Admin Navigation">
        <div class="container-fluid px-lg-4">
            <a class="navbar-brand" href="<?= $baseUrl ?>/admin/dashboard.php">
                <div class="brand-icon" style="background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <span class="gradient-text">DevPortfolio</span>
                    <span class="badge bg-danger text-uppercase ms-1" style="font-size: 0.65rem;">Admin</span>
                </div>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-light fs-2"></i>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'dashboard.php') ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/dashboard.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'messages.php') ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/messages.php">
                            <i class="bi bi-envelope me-1"></i> Messages
                            <?php if ($unreadCount > 0): ?>
                                <span class="badge bg-warning text-dark rounded-pill ms-1"><?= $unreadCount ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (in_array($currentPage, ['projects.php', 'add_project.php', 'edit_project.php'])) ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/projects.php">
                            <i class="bi bi-folder-fill me-1"></i> Manage Projects
                        </a>
                    </li>
                </ul>

                <!-- Right Side User & Public Links -->
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="btn btn-sm btn-secondary-custom" href="<?= $baseUrl ?>/index.php" target="_blank" title="View live public site">
                            <i class="bi bi-box-arrow-up-right me-1"></i> View Website
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light d-flex align-items-center gap-2" href="#" id="adminProfileDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.85rem; font-weight: 700;">
                                <?= strtoupper(substr($adminUser, 0, 1)) ?>
                            </div>
                            <span class="small fw-semibold"><?= e($adminUser) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow" aria-labelledby="adminProfileDrop" style="background-color: var(--bg-card); border-color: var(--border-subtle);">
                            <li><span class="dropdown-header text-muted small">Signed in as <?= e($adminUser) ?></span></li>
                            <li><a class="dropdown-item small" href="<?= $baseUrl ?>/admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item small" href="<?= $baseUrl ?>/admin/messages.php"><i class="bi bi-envelope me-2"></i>Inquiries</a></li>
                            <li><a class="dropdown-item small" href="<?= $baseUrl ?>/admin/projects.php"><i class="bi bi-folder me-2"></i>Projects</a></li>
                            <li><hr class="dropdown-divider" style="border-color: var(--border-subtle);"></li>
                            <li>
                                <a class="dropdown-item small text-danger" href="<?= $baseUrl ?>/admin/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Global Flash Notification Messages for Admin -->
    <div class="container-fluid px-lg-4 mt-3">
        <?= render_flash_messages() ?>
    </div>

    <!-- Main Admin Body Content -->
    <main class="flex-grow-1 py-4">
        <div class="container-fluid px-lg-4">
