<?php
/**
 * DevPortfolio - Update Contact Message Status Handler
 * 
 * Safely toggles 'read' / 'unread' status using PDO prepared statements.
 * Enforces admin session checks, POST validation, and CSRF protection.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash_message('danger', 'Invalid request method.');
    header('Location: messages.php');
    exit;
}

// CSRF Validation
if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    set_flash_message('danger', 'Security verification failed. Please try again.');
    header('Location: messages.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$status = isset($_POST['status']) && in_array($_POST['status'], ['read', 'unread'], true) ? $_POST['status'] : null;
$redirect = isset($_POST['redirect']) && $_POST['redirect'] === 'dashboard.php' ? 'dashboard.php' : 'messages.php';

if ($id <= 0 || $status === null) {
    set_flash_message('danger', 'Invalid message identifier or status value.');
    header('Location: ' . $redirect);
    exit;
}

try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE contacts SET status = :status WHERE id = :id");
    $stmt->execute([
        ':status' => $status,
        ':id'     => $id
    ]);

    set_flash_message('success', 'Message status updated to "' . e(ucfirst($status)) . '" successfully.');
} catch (\Throwable $e) {
    error_log("Failed to update message status: " . $e->getMessage());
    set_flash_message('danger', 'Database error: Could not update message status.');
}

header('Location: ' . $redirect);
exit;
