<?php
/**
 * DevPortfolio - Delete Project Handler
 * 
 * Safely removes a project showcase record from MySQL.
 * Enforces admin authorization, POST method, and CSRF token verification.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash_message('danger', 'Invalid request method.');
    header('Location: projects.php');
    exit;
}

// CSRF Validation
if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    set_flash_message('danger', 'Security verification failed. Please try again.');
    header('Location: projects.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    set_flash_message('danger', 'Invalid project identifier.');
    header('Location: projects.php');
    exit;
}

try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        set_flash_message('success', 'Project #' . $id . ' was removed successfully.');
    } else {
        set_flash_message('warning', 'Project record not found or already deleted.');
    }
} catch (\Throwable $e) {
    error_log("Failed to delete project: " . $e->getMessage());
    set_flash_message('danger', 'Database error: Could not delete project.');
}

header('Location: projects.php');
exit;
