<?php
/**
 * DevPortfolio - Database Configuration and PDO Connection Handler
 * 
 * Provides a secure, reusable PDO database connection using prepared statements.
 * Supports environment variables or default local credentials (e.g. XAMPP/WAMP/MAMP).
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

// Prevent direct execution if needed
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

// Database Connection Parameters
// Can be customized directly or overridden via environment variables
$dbHost = getenv('DB_HOST') !== false ? (string)getenv('DB_HOST') : '127.0.0.1';
$dbPort = getenv('DB_PORT') !== false ? (int)getenv('DB_PORT') : 3306;
$dbName = getenv('DB_NAME') !== false ? (string)getenv('DB_NAME') : 'devportfolio';
$dbUser = getenv('DB_USER') !== false ? (string)getenv('DB_USER') : 'root';
$dbPass = getenv('DB_PASS') !== false ? (string)getenv('DB_PASS') : '';
$dbCharset = 'utf8mb4';

// Global PDO instance holder (singleton pattern)
$pdoInstance = null;
$dbConnectionError = null;

/**
 * Get or initialize the PDO database connection
 * 
 * @return PDO
 * @throws PDOException if connection fails
 */
function getDbConnection(): PDO
{
    global $pdoInstance, $dbConnectionError, $dbHost, $dbPort, $dbName, $dbUser, $dbPass, $dbCharset;

    if ($pdoInstance instanceof PDO) {
        return $pdoInstance;
    }

    $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset={$dbCharset}";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$dbCharset} COLLATE utf8mb4_unicode_ci",
    ];

    try {
        $pdoInstance = new PDO($dsn, $dbUser, $dbPass, $options);
        return $pdoInstance;
    } catch (PDOException $e) {
        // Record sanitized error without leaking passwords
        $dbConnectionError = "Database connection failed. Please ensure MySQL is running and the database is imported.";
        // Log detailed error to system logger
        error_log("DevPortfolio DB Error: " . $e->getMessage());
        throw new PDOException($dbConnectionError, (int)$e->getCode());
    }
}

/**
 * Check if database is currently reachable and responsive
 * 
 * @return bool
 */
function isDatabaseConnected(): bool
{
    try {
        $pdo = getDbConnection();
        $pdo->query("SELECT 1");
        return true;
    } catch (\Throwable $e) {
        return false;
    }
}
