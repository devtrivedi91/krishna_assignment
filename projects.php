<?php
/**
 * DevPortfolio - Projects Showcase Page
 * 
 * Dynamically queries all projects from the MySQL database using PDO.
 * Displays project cards with technology badges, descriptions, 
 * GitHub repository links, and live demonstration URLs.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$pageTitle = 'Projects — Dynamic MySQL Showcase';
$metaDescription = 'Explore dynamic software engineering projects powered by PHP and MySQL including carpooling platforms, real estate portals, and library management systems.';

require_once __DIR__ . '/includes/header.php';

// Dynamically retrieve all project records from MySQL database
$projects = get_all_projects();
$dbActive = isDatabaseConnected();
?>

<div class="container py-5">
    <!-- Page Header -->
    <div class="section-header">
        <span class="section-tag"><i class="bi bi-folder-fill"></i> Showcase &amp; Work</span>
        <h1 class="section-title">Dynamic <span class="gradient-text">Projects</span></h1>
        <p class="section-subtitle">
            All project records below are stored in the MySQL database and queried in real time via PHP PDO prepared statements.
        </p>
    </div>

    <!-- Database Connection State Alert (if not connected) -->
    <?php if (!$dbActive): ?>
        <div class="alert alert-warning border-0 p-4 mb-5 rounded-4 shadow-sm" role="alert">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-database-exclamation fs-2 text-warning"></i>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">Database Not Connected</h5>
                    <p class="mb-2 small">
                        The application is currently unable to reach the MySQL database server.
                        Ensure your database service is running and you have imported <code>database.sql</code> into database <code>devportfolio</code>.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="<?= $baseUrl ?>/database.sql" download class="btn btn-sm btn-outline-dark fw-semibold">
                            <i class="bi bi-download me-1"></i> Download database.sql
                        </a>
                        <a href="<?= $baseUrl ?>/admin/login.php" class="btn btn-sm btn-dark">
                            <i class="bi bi-shield-lock me-1"></i> Admin Portal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Projects Grid -->
    <div class="row g-4">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="col-lg-6">
                    <div class="portfolio-card d-flex flex-column h-100">
                        <!-- Project Image Preview -->
                        <div class="project-card-img-wrap" style="height: 240px;">
                            <img src="<?= !empty($project['image']) ? e($baseUrl . '/' . ltrim($project['image'], '/')) : e($baseUrl . '/assets/images/projects/project-devportfolio.svg') ?>" 
                                 alt="<?= e($project['title']) ?>" 
                                 class="project-card-img"
                                 onerror="this.src='<?= $baseUrl ?>/assets/images/projects/project-devportfolio.svg'">
                            <div class="project-card-overlay"></div>
                            
                            <!-- Creation Timestamp Badge -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-dark bg-opacity-75 text-light border border-secondary border-opacity-25 px-2 py-1 small font-monospace">
                                    <i class="bi bi-clock-history me-1"></i><?= date('M Y', strtotime($project['created_at'])) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Project Body -->
                        <div class="project-content flex-grow-1 d-flex flex-column p-4">
                            <h2 class="project-title h4"><?= e($project['title']) ?></h2>
                            <p class="project-desc mb-3">
                                <?= e($project['description']) ?>
                            </p>

                            <!-- Technology Tags -->
                            <div class="mb-4">
                                <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                    Technologies Used:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php 
                                    $techList = array_map('trim', explode(',', $project['technologies']));
                                    foreach ($techList as $tech): 
                                    ?>
                                        <span class="tech-badge"><?= e($tech) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Action Links -->
                            <div class="mt-auto pt-3 border-top d-flex gap-2" style="border-color: var(--border-subtle) !important;">
                                <?php if (!empty($project['github_url'])): ?>
                                    <a href="<?= e($project['github_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary-custom flex-grow-1 text-center justify-content-center">
                                        <i class="bi bi-github"></i> Source Code
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($project['demo_url']) && $project['demo_url'] !== '#'): ?>
                                    <a href="<?= e($project['demo_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary-custom flex-grow-1 text-center justify-content-center">
                                        <i class="bi bi-box-arrow-up-right"></i> Live Demo
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary-custom flex-grow-1 text-center justify-content-center disabled" opacity="0.6">
                                        <i class="bi bi-laptop"></i> Assignment Demo
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback Empty State -->
            <div class="col-12 text-center py-5">
                <div class="portfolio-card p-5 mx-auto" style="max-width: 600px;">
                    <div class="brand-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem;">
                        <i class="bi bi-database-x"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-2">No Projects Stored in Database</h3>
                    <p class="text-muted small mb-4">
                        The MySQL <code>projects</code> table is empty or currently unreachable.
                        Import the provided schema in <code>database.sql</code> to view initial projects, or log into the administrative control panel to add projects dynamically.
                    </p>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="<?= $baseUrl ?>/admin/login.php" class="btn btn-primary-custom">
                            <i class="bi bi-plus-circle me-1"></i> Add Project via Admin Panel
                        </a>
                        <a href="<?= $baseUrl ?>/index.php" class="btn btn-secondary-custom">
                            <i class="bi bi-house me-1"></i> Return Home
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Administrative Management Callout -->
    <div class="mt-5 text-center">
        <p class="text-muted small mb-2">
            Are you the administrator? You can add, edit, or remove project showcase cards through the admin dashboard.
        </p>
        <a href="<?= $baseUrl ?>/admin/projects.php" class="btn btn-sm btn-outline-violet">
            <i class="bi bi-gear-fill me-1"></i> Manage Projects in Admin Panel
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
