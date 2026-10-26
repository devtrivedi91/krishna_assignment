<?php
/**
 * DevPortfolio - Secure Admin Logout
 * 
 * Clears authentication session flags, destroys active session,
 * invalidates session cookie, and redirects to login portal.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

init_session();

// Clear all session variables
$_SESSION = [];

// Destroy session cookie on client browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session data on server
session_destroy();

// Start fresh temporary session to deliver logout flash message
init_session();
set_flash_message('info', 'You have been safely signed out from the administrative portal.');

header('Location: login.php');
exit;
