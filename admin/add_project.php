<?php
/**
 * DevPortfolio - Administrator Add Project
 * 
 * Creates a new project showcase record in the MySQL database via PDO.
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$adminTitle = 'Add New Project';

require_once __DIR__ . '/admin_header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Security token invalid or expired. Please try again.';
    } else {
        $title = isset($_POST['title']) ? sanitize_input((string)$_POST['title']) : '';
        $description = isset($_POST['description']) ? sanitize_input((string)$_POST['description']) : '';
        $technologies = isset($_POST['technologies']) ? sanitize_input((string)$_POST['technologies']) : '';
        $github_url = isset($_POST['github_url']) ? trim((string)$_POST['github_url']) : '';
        $demo_url = isset($_POST['demo_url']) ? trim((string)$_POST['demo_url']) : '';
        $image = isset($_POST['image']) ? trim((string)$_POST['image']) : '';

        if (empty($title) || mb_strlen($title) < 2 || mb_strlen($title) > 150) {
            $errors[] = 'Project title is required (between 2 and 150 characters).';
        }

        if (empty($description) || mb_strlen($description) < 10) {
            $errors[] = 'Project description is required (at least 10 characters).';
        }

        if (empty($technologies) || mb_strlen($technologies) < 2) {
            $errors[] = 'Technologies list is required (e.g. PHP, MySQL, Bootstrap 5).';
        }

        if (!empty($github_url) && !filter_var($github_url, FILTER_VALIDATE_URL)) {
            $errors[] = 'GitHub URL must be a valid URL format.';
        }

        if (!empty($demo_url) && $demo_url !== '#' && !filter_var($demo_url, FILTER_VALIDATE_URL)) {
            $errors[] = 'Live Demo URL must be a valid URL format or #.';
        }

        if (empty($image)) {
            $image = 'assets/images/projects/project-devportfolio.svg';
        }

        if (empty($errors)) {
            try {
                $pdo = getDbConnection();
                $stmt = $pdo->prepare(
                    "INSERT INTO projects (title, description, technologies, github_url, demo_url, image, created_at) 
                     VALUES (:title, :description, :technologies, :github_url, :demo_url, :image, NOW())"
                );
                $stmt->execute([
                    ':title'        => $title,
                    ':description'  => $description,
                    ':technologies' => $technologies,
                    ':github_url'   => !empty($github_url) ? $github_url : null,
                    ':demo_url'     => !empty($demo_url) ? $demo_url : null,
                    ':image'        => $image,
                ]);

                set_flash_message('success', 'Project "' . e($title) . '" was added to the showcase successfully.');
                header('Location: projects.php');
                exit;
            } catch (\Throwable $e) {
                error_log("Failed to insert project: " . $e->getMessage());
                $errors[] = 'Database insertion error: ' . $e->getMessage();
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Add New <span class="gradient-text">Project</span></h1>
                <p class="text-muted small mb-0">Record will be saved to MySQL and displayed dynamically on the public site.</p>
            </div>
            <a href="<?= $baseUrl ?>/admin/projects.php" class="btn btn-sm btn-secondary-custom">
                <i class="bi bi-arrow-left me-1"></i> Back to Projects
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0 small ps-3">
                    <?php foreach ($errors as $err): ?>
                        <li><?= e($err) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="portfolio-card p-4 p-md-5">
            <form action="<?= $baseUrl ?>/admin/add_project.php" method="POST" class="needs-validation" novalidate>
                <?= csrf_input() ?>

                <div class="mb-3">
                    <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g. HealthTracker — Patient Portal" value="<?= e($_POST['title'] ?? '') ?>" required>
                    <div class="invalid-feedback">Please enter a project title.</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Project Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Comprehensive summary of project objectives, architecture, and features..." required><?= e($_POST['description'] ?? '') ?></textarea>
                    <div class="invalid-feedback">Please enter a project description.</div>
                </div>

                <div class="mb-3">
                    <label for="technologies" class="form-label">Technologies Used <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="technologies" name="technologies" placeholder="e.g. PHP 8, MySQL, Bootstrap 5, PDO, JavaScript" value="<?= e($_POST['technologies'] ?? '') ?>" required>
                    <div class="form-text text-muted small">Separate technologies with commas.</div>
                    <div class="invalid-feedback">Please specify technologies used.</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="github_url" class="form-label">GitHub Repository URL</label>
                        <input type="url" class="form-control" id="github_url" name="github_url" placeholder="https://github.com/username/project" value="<?= e($_POST['github_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="demo_url" class="form-label">Live Demo URL</label>
                        <input type="text" class="form-control" id="demo_url" name="demo_url" placeholder="https://demo.example.com or #" value="<?= e($_POST['demo_url'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Image or Vector Asset Path</label>
                    <input type="text" class="form-control" id="image" name="image" placeholder="assets/images/projects/project-devportfolio.svg" value="<?= e($_POST['image'] ?? 'assets/images/projects/project-devportfolio.svg') ?>">
                    <div class="form-text text-muted small">Relative path to image, e.g. <code>assets/images/projects/project-rideshare.svg</code></div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-check2-circle me-1"></i> Save Project to Database
                    </button>
                    <a href="<?= $baseUrl ?>/admin/projects.php" class="btn btn-secondary-custom">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
