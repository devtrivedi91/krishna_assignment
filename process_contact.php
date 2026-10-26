<?php
/**
 * DevPortfolio - Contact Form Submission Handler
 * 
 * Validates submitted contact details, verifies CSRF tokens,
 * mitigates bot submissions via honeypot, and securely inserts 
 * records into the MySQL database via PDO prepared statements.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

// Only allow HTTP POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash_message('danger', 'Invalid request method.');
    header('Location: contact.php');
    exit;
}

// 1. Verify CSRF Token
$submittedCsrf = $_POST['csrf_token'] ?? null;
if (!verify_csrf_token($submittedCsrf)) {
    set_flash_message('danger', 'Security token expired or invalid. Please refresh the page and try again.');
    header('Location: contact.php');
    exit;
}

// 2. Bot Honeypot Check (Must remain empty)
if (!empty($_POST['website'])) {
    // Suspected spam submission - reject silently or show generic notice
    set_flash_message('danger', 'Spam detection triggered. Your submission was blocked.');
    header('Location: contact.php');
    exit;
}

// 3. Extract and Sanitize User Inputs
$name = isset($_POST['name']) ? sanitize_input((string)$_POST['name']) : '';
$email = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
$subject = isset($_POST['subject']) ? sanitize_input((string)$_POST['subject']) : '';
$message = isset($_POST['message']) ? sanitize_input((string)$_POST['message']) : '';

// Preserve input for re-filling form on error
$_SESSION['old_contact_input'] = [
    'name'    => $name,
    'email'   => $email,
    'subject' => $subject,
    'message' => $message,
];

// 4. Server-Side Validation
$errors = [];

if (empty($name) || mb_strlen($name) < 2 || mb_strlen($name) > 100) {
    $errors[] = 'Full name is required and must be between 2 and 100 characters.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
    $errors[] = 'A valid email address is required (maximum 150 characters).';
}

if (empty($subject) || mb_strlen($subject) < 3 || mb_strlen($subject) > 200) {
    $errors[] = 'Subject is required and must be between 3 and 200 characters.';
}

if (empty($message) || mb_strlen($message) < 10 || mb_strlen($message) > 5000) {
    $errors[] = 'Message is required and must contain at least 10 characters (up to 5,000 characters).';
}

// If validation errors exist, notify user and redirect
if (!empty($errors)) {
    set_flash_message('danger', implode('<br>', $errors));
    header('Location: contact.php');
    exit;
}

// 5. Database Insertion via PDO Prepared Statements
try {
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        "INSERT INTO `contacts` (`name`, `email`, `subject`, `message`, `status`, `created_at`) 
         VALUES (:name, :email, :subject, :message, 'unread', NOW())"
    );

    $success = $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message,
    ]);

    if ($success && $stmt->rowCount() > 0) {
        // Insertion confirmed! Clear preserved input
        unset($_SESSION['old_contact_input']);
        set_flash_message('success', 'Thank you, ' . e($name) . '! Your message has been sent successfully and saved to our database.');
    } else {
        // Did not insert properly
        set_flash_message('danger', 'We were unable to save your message. Please verify your details and try again.');
    }
} catch (\Throwable $e) {
    // Log actual database error internally
    error_log("Contact Form Insertion Failed: " . $e->getMessage());
    // Safe user-facing message without exposing internal credentials or server paths
    set_flash_message('danger', 'Database connectivity error: Message could not be saved at this moment. Please ensure the MySQL database is configured.');
}

// Redirect back to contact page
header('Location: contact.php');
exit;
