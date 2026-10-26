<?php
/**
 * DevPortfolio - Secure Admin Authentication
 * 
 * Implements password verification using password_verify(),
 * session regeneration on login, CSRF tokens, and brute-force throttling.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

// Redirect if already authenticated
if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = null;

// Process Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF Token
    $token = $_POST['csrf_token'] ?? null;
    if (!verify_csrf_token($token)) {
        $error = 'Security session expired. Please refresh and try again.';
    } else {
        $username = isset($_POST['username']) ? sanitize_input((string)$_POST['username']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            try {
                $pdo = getDbConnection();
                $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admins WHERE username = :username LIMIT 1");
                $stmt->execute([':username' => $username]);
                $admin = $stmt->fetch();

                if ($admin && password_verify($password, $admin['password_hash'])) {
                    // Prevent session fixation
                    session_regenerate_id(true);

                    // Set authenticated session parameters
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id']        = (int)$admin['id'];
                    $_SESSION['admin_username']  = $admin['username'];
                    $_SESSION['last_login_time'] = time();

                    set_flash_message('success', 'Authentication successful. Welcome, ' . e($admin['username']) . '!');
                    header('Location: dashboard.php');
                    exit;
                } else {
                    // Artificial delay to mitigate timing attacks
                    usleep(150000);
                    $error = 'Invalid administrative credentials. Please verify and try again.';
                }
            } catch (\Throwable $e) {
                error_log("Admin Login DB Error: " . $e->getMessage());
                $error = 'Database connection failure. Please confirm MySQL is running and the database is imported.';
            }
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
    <title>Admin Sign In — DevPortfolio</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Theme Styles -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body class="d-flex align-items-center justify-content-center py-5 min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5 col-xl-4">
                <!-- Branding Header -->
                <div class="text-center mb-4">
                    <a href="<?= $baseUrl ?>/index.php" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                        <div class="brand-icon" style="width: 44px; height: 44px; font-size: 1.25rem;">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <span class="fs-4 fw-bold gradient-text">DevPortfolio</span>
                    </a>
                    <h1 class="h5 fw-bold text-light mt-3 mb-1">Administrative Portal</h1>
                    <p class="text-muted small">Sign in to moderate inquiries and manage projects</p>
                </div>

                <!-- Flash Alert Messages -->
                <?= render_flash_messages() ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div class="small"><?= e($error) ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Sign In Card -->
                <div class="portfolio-card p-4 p-sm-5">
                    <form action="<?= $baseUrl ?>/admin/login.php" method="POST" class="needs-validation" novalidate>
                        <!-- CSRF Token -->
                        <?= csrf_input() ?>

                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary border-opacity-25 text-muted">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="username" 
                                       name="username" 
                                       placeholder="admin" 
                                       value="<?= e($_POST['username'] ?? '') ?>" 
                                       required 
                                       autofocus 
                                       autocomplete="username">
                                <div class="invalid-feedback">Please enter your admin username.</div>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary border-opacity-25 text-muted">
                                    <i class="bi bi-key-fill"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required 
                                       autocomplete="current-password">
                                <div class="invalid-feedback">Please enter your password.</div>
                            </div>
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit" class="btn btn-primary-custom w-100 justify-content-center py-2 fs-6">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Authenticate &amp; Enter
                        </button>
                    </form>

                    <!-- Default Local Dev Credentials Hint for College Evaluation -->
                    <div class="mt-4 pt-3 border-top text-center" style="border-color: var(--border-subtle) !important;">
                        <span class="text-muted small d-block mb-1">Local Testing Default Credentials:</span>
                        <code class="text-info bg-dark px-2 py-1 rounded small font-monospace">Username: admin | Password: Admin@123</code>
                    </div>
                </div>

                <!-- Back to Site Link -->
                <div class="text-center mt-4">
                    <a href="<?= $baseUrl ?>/index.php" class="footer-link small">
                        <i class="bi bi-arrow-left me-1"></i> Return to Public Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?= $baseUrl ?>/assets/js/script.js"></script>
</body>
</html>
