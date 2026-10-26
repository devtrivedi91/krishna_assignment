<?php
/**
 * DevPortfolio - Admin Route Dispatcher
 * 
 * Directs authenticated administrators to the dashboard, 
 * or unauthenticated visitors to the login page.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

if (is_admin_logged_in()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
