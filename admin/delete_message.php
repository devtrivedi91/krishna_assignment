<?php
/**
 * DevPortfolio - Delete Contact Message Handler
 * 
 * Safely removes a contact record from the MySQL database.
 * Enforces admin authorization, POST method, and CSRF token verification.
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

if ($id <= 0) {
    set_flash_message('danger', 'Invalid message identifier.');
    header('Location: messages.php');
    exit;
}

try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        set_flash_message('success', 'Contact inquiry # ' . $id . ' was permanently deleted.');
    } else {
        set_flash_message('warning', 'Message not found or already removed.');
    }
} catch (\Throwable $e) {
    error_log("Failed to delete contact message: " . $e->getMessage());
    set_flash_message('danger', 'Database error: Could not delete message.');
}

header('Location: messages.php');
exit;
