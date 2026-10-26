<?php
/**
 * DevPortfolio - Core Security & Utility Functions
 * 
 * Includes XSS prevention, CSRF validation, session handling, 
 * flash messages, and database helper methods.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

/**
 * Initialize a secure PHP session if not already started
 */
function init_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        // Configure secure cookie parameters before starting session
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        session_start();
    }
}

// Auto-initialize session on include
init_session();

/**
 * Escape output for safe HTML rendering (XSS Protection)
 *
 * @param mixed $value
 * @return string
 */
function e($value): string
{
    if ($value === null) {
        return '';
    }
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitize user input strings
 *
 * @param string $data
 * @return string
 */
function sanitize_input(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return strip_tags($data);
}

/**
 * Generate or retrieve the current CSRF token
 *
 * @return string
 */
function generate_csrf_token(): string
{
    init_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify a submitted CSRF token
 *
 * @param string|null $token
 * @return bool
 */
function verify_csrf_token(?string $token): bool
{
    init_session();
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Render a hidden CSRF token input tag
 *
 * @return string
 */
function csrf_input(): string
{
    $token = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
}

/**
 * Set a session flash notification
 *
 * @param string $type success|danger|warning|info
 * @param string $message
 */
function set_flash_message(string $type, string $message): void
{
    init_session();
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    $_SESSION['flash_messages'][] = [
        'type'    => $type,
        'message' => $message
    ];
}

/**
 * Retrieve and clear all session flash notifications
 *
 * @return array
 */
function get_flash_messages(): array
{
    init_session();
    if (isset($_SESSION['flash_messages'])) {
        $messages = $_SESSION['flash_messages'];
        unset($_SESSION['flash_messages']);
        return $messages;
    }
    return [];
}

/**
 * Render flash messages as styled Bootstrap 5 alert components
 *
 * @return string
 */
function render_flash_messages(): string
{
    $messages = get_flash_messages();
    if (empty($messages)) {
        return '';
    }

    $html = '<div class="flash-messages-container mb-4">';
    foreach ($messages as $msg) {
        $type = e($msg['type']);
        $text = e($msg['message']);
        $icon = ($type === 'success') ? 'bi-check-circle-fill' : (($type === 'danger') ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill');
        $html .= <<<HTML
        <div class="alert alert-{$type} alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
            <i class="bi {$icon} me-2 fs-5"></i>
            <div>{$text}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
HTML;
    }
    $html .= '</div>';
    return $html;
}

/**
 * Determine dynamic base URL for root or subdirectory installations
 *
 * @return string
 */
function get_base_url(): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Script filename relative to DOCUMENT_ROOT
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    // Remove /admin if running from inside admin subfolder
    $baseDir = preg_replace('/\/admin$/', '', $scriptDir);
    $baseDir = rtrim($baseDir, '/\\');
    
    return $protocol . $host . $baseDir;
}

/**
 * Check if administrator is authenticated
 *
 * @return bool
 */
function is_admin_logged_in(): bool
{
    init_session();
    return !empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && !empty($_SESSION['admin_id']);
}

/**
 * Require administrator authentication or redirect to login page
 */
function require_admin_login(): void
{
    if (!is_admin_logged_in()) {
        set_flash_message('warning', 'Please sign in to access the administration panel.');
        header('Location: login.php');
        exit;
    }
}

/**
 * Retrieve all projects from the database using PDO prepared statement
 * Fallback to default sample data if database table is not yet reachable.
 *
 * @param int|null $limit
 * @return array
 */
function get_all_projects(?int $limit = null): array
{
    try {
        $pdo = getDbConnection();
        $sql = "SELECT id, title, description, technologies, github_url, demo_url, image, created_at FROM projects ORDER BY created_at DESC";
        if ($limit !== null && $limit > 0) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $projects = $stmt->fetchAll();
        return $projects ?: [];
    } catch (\Throwable $e) {
        error_log("Failed to fetch projects from database: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch a single project by ID
 *
 * @param int $id
 * @return array|null
 */
function get_project_by_id(int $id): ?array
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT id, title, description, technologies, github_url, demo_url, image, created_at FROM projects WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $project = $stmt->fetch();
        return $project ?: null;
    } catch (\Throwable $e) {
        error_log("Failed to fetch project ID {$id}: " . $e->getMessage());
        return null;
    }
}

/**
 * Retrieve contact messages from the database with optional status filter
 *
 * @param string $filter 'all'|'unread'|'read'
 * @param string $search
 * @return array
 */
function get_contact_messages(string $filter = 'all', string $search = ''): array
{
    try {
        $pdo = getDbConnection();
        $sql = "SELECT id, name, email, subject, message, status, created_at FROM contacts WHERE 1=1";
        $params = [];

        if ($filter === 'unread' || $filter === 'read') {
            $sql .= " AND status = :status";
            $params[':status'] = $filter;
        }

        if (!empty($search)) {
            $sql .= " AND (name LIKE :search_name OR email LIKE :search_email OR subject LIKE :search_subject OR message LIKE :search_msg)";
            $searchTerm = '%' . $search . '%';
            $params[':search_name'] = $searchTerm;
            $params[':search_email'] = $searchTerm;
            $params[':search_subject'] = $searchTerm;
            $params[':search_msg'] = $searchTerm;
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll() ?: [];
    } catch (\Throwable $e) {
        error_log("Failed to fetch contact messages: " . $e->getMessage());
        return [];
    }
}

/**
 * Get dashboard overview metrics
 *
 * @return array
 */
function get_dashboard_stats(): array
{
    $stats = [
        'total_messages'  => 0,
        'unread_messages' => 0,
        'read_messages'   => 0,
        'total_projects'  => 0,
        'db_connected'    => false,
    ];

    try {
        $pdo = getDbConnection();
        $stats['db_connected'] = true;

        // Total messages
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM contacts");
        $stats['total_messages'] = (int)($stmt->fetch()['total'] ?? 0);

        // Unread messages
        $stmt = $pdo->query("SELECT COUNT(*) AS unread FROM contacts WHERE status = 'unread'");
        $stats['unread_messages'] = (int)($stmt->fetch()['unread'] ?? 0);

        $stats['read_messages'] = $stats['total_messages'] - $stats['unread_messages'];

        // Total projects
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM projects");
        $stats['total_projects'] = (int)($stmt->fetch()['total'] ?? 0);
    } catch (\Throwable $e) {
        error_log("Failed to fetch dashboard stats: " . $e->getMessage());
    }

    return $stats;
}

/**
 * Format datetime into a friendly human-readable format
 *
 * @param string $datetime
 * @return string
 */
function format_date(string $datetime): string
{
    try {
        $dt = new DateTime($datetime);
        return $dt->format('M j, Y \a\t g:i A');
    } catch (\Exception $e) {
        return $datetime;
    }
}
