<?php
/**
 * DevPortfolio - Local Admin Setup & Initialization Utility
 * 
 * Securely hashes passwords using PHP's password_hash() and registers 
 * the initial administrator account in the MySQL `admins` table.
 * 
 * IMPORTANT SECURITY NOTICE:
 * This script is intended strictly for local development setup (e.g. XAMPP).
 * YOU MUST DELETE THIS FILE BEFORE DEPLOYING TO A PRODUCTION SERVER.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$message = null;
$messageType = 'info';
$dbConnected = isDatabaseConnected();
$generatedSql = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? sanitize_input((string)$_POST['username']) : '';
    $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

    if (empty($username) || mb_strlen($username) < 3) {
        $message = 'Username must be at least 3 characters long.';
        $messageType = 'danger';
    } elseif (empty($password) || mb_strlen($password) < 6) {
        $message = 'Password must be at least 6 characters long.';
        $messageType = 'danger';
    } else {
        // Compute secure bcrypt hash with cost 12
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $generatedSql = "INSERT INTO `admins` (`username`, `password_hash`) VALUES ('" . addslashes($username) . "', '" . $passwordHash . "') ON DUPLICATE KEY UPDATE `password_hash` = VALUES(`password_hash`);";

        if ($dbConnected) {
            try {
                $pdo = getDbConnection();
                $stmt = $pdo->prepare(
                    "INSERT INTO admins (username, password_hash) 
                     VALUES (:username, :password_hash) 
                     ON DUPLICATE KEY UPDATE password_hash = :password_hash_update"
                );
                $stmt->execute([
                    ':username'             => $username,
                    ':password_hash'        => $passwordHash,
                    ':password_hash_update' => $passwordHash,
                ]);

                $message = "Admin account '{$username}' was created/updated successfully! You can now log into the admin portal.";
                $messageType = 'success';
            } catch (\Throwable $e) {
                $message = "Database error: " . $e->getMessage();
                $messageType = 'danger';
            }
        } else {
            $message = "Database is not currently reachable. However, your secure Bcrypt hash was computed successfully. You can run the SQL query below in phpMyAdmin.";
            $messageType = 'warning';
        }
    }
}

$baseUrl = get_base_url();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup Utility — DevPortfolio</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body class="py-5">

    <div class="container" style="max-width: 680px;">
        <div class="text-center mb-4">
            <div class="brand-icon mx-auto mb-2" style="width: 48px; height: 48px; font-size: 1.3rem;">
                <i class="bi bi-key-fill"></i>
            </div>
            <h1 class="h3 fw-bold gradient-text">DevPortfolio Admin Setup Utility</h1>
            <p class="text-muted small">Local configuration helper for initializing administrator credentials</p>
        </div>

        <!-- Security Warning Banner -->
        <div class="alert alert-warning border-0 p-3 mb-4 rounded-3 d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill fs-3 text-warning"></i>
            <div class="small">
                <strong>Deployment Caution:</strong> This file is intended for local initialization only. Delete <code>setup_admin.php</code> from your server prior to public web deployment.
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $messageType ?> alert-dismissible fade show mb-4 small" role="alert">
                <?= e($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Database Reachability Indicator -->
        <div class="portfolio-card p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted fw-semibold">MySQL Database Status:</span>
                <?php if ($dbConnected): ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i>Connected</span>
                <?php else: ?>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-x-circle me-1"></i>Not Connected (Check MySQL service)</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Setup Form -->
        <div class="portfolio-card p-4 p-md-5 mb-4">
            <h2 class="h5 fw-bold mb-3">Create or Reset Admin Account</h2>
            <form action="<?= $baseUrl ?>/setup_admin.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Administrator Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="admin" required minlength="3">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Administrator Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter secure password (min 6 characters)" required minlength="6">
                    <div class="form-text text-muted small">Will be hashed securely with <code>password_hash(..., PASSWORD_BCRYPT)</code>.</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-shield-lock me-1"></i> Generate &amp; Save Admin
                    </button>
                    <a href="<?= $baseUrl ?>/admin/login.php" class="btn btn-secondary-custom">
                        Go to Admin Login
                    </a>
                </div>
            </form>
        </div>

        <?php if (!empty($generatedSql)): ?>
            <!-- Generated SQL Query Output -->
            <div class="portfolio-card p-4 mb-4">
                <h3 class="h6 fw-bold mb-2 text-info"><i class="bi bi-terminal me-1"></i> Generated SQL Query</h3>
                <p class="text-muted small mb-2">If you prefer importing directly into phpMyAdmin:</p>
                <pre class="p-3 rounded-3 text-light bg-dark small" style="white-space: pre-wrap; word-break: break-all;"><?= e($generatedSql) ?></pre>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="<?= $baseUrl ?>/index.php" class="footer-link small">
                <i class="bi bi-arrow-left me-1"></i> Return to Public Homepage
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
