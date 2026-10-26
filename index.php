<?php
/**
 * DevPortfolio - Home Page
 * 
 * Developer introduction, hero section, dynamic featured projects,
 * quick stats, and primary calls-to-action.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$pageTitle = 'Home — Developer Portfolio';
$metaDescription = 'Professional developer portfolio for B.Tech Computer Engineering student featuring dynamic PHP/MySQL projects and modern responsive design.';

require_once __DIR__ . '/includes/header.php';

// Fetch top 3 featured projects dynamically from the database
$featuredProjects = get_all_projects(3);
$dbActive = isDatabaseConnected();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Hero Text Content -->
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 mb-3">
                    <span class="section-tag mb-0">
                        <i class="bi bi-mortarboard-fill"></i> B.Tech Computer Engineering
                    </span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 d-none d-sm-inline-flex align-items-center gap-1">
                        <span class="status-dot"></span> Available for Opportunities
                    </span>
                </div>

                <h1 class="display-4 fw-extrabold mb-3">
                    Hi, I'm <span class="gradient-text">Krishna</span>
                </h1>
                
                <h2 class="h4 text-light fw-semibold mb-3" style="color: #cbd5e1 !important;">
                    Full-Stack Web Developer &amp; Systems Enthusiast
                </h2>

                <p class="lead text-muted mb-4" style="font-size: 1.15rem; max-width: 620px;">
                    Passionate Computer Engineering undergraduate focused on architecting resilient backend systems with <strong>PHP 8</strong> &amp; <strong>MySQL</strong>, crafting dynamic web applications, and building clean, responsive user interfaces.
                </p>

                <!-- Hero CTA Buttons -->
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4">
                    <a href="<?= $baseUrl ?>/projects.php" class="btn btn-primary-custom">
                        <i class="bi bi-grid-fill"></i> Explore Projects
                    </a>
                    <a href="<?= $baseUrl ?>/contact.php" class="btn btn-secondary-custom">
                        <i class="bi bi-chat-dots-fill"></i> Get in Touch
                    </a>
                    <a href="<?= $baseUrl ?>/about.php" class="btn btn-outline-violet">
                        <i class="bi bi-person-lines-fill"></i> About Me
                    </a>
                </div>

                <!-- Social Proof & External Links -->
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3">
                    <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Connect:</span>
                    <a href="https://github.com" target="_blank" rel="noopener noreferrer" class="social-link-btn" title="GitHub Profile">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-link-btn" title="LinkedIn Profile">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="mailto:krishna@example.com" class="social-link-btn" title="Send Email">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            <!-- Hero Visual / Avatar -->
            <div class="col-lg-5 text-center">
                <div class="hero-avatar-wrapper">
                    <div class="hero-avatar-glow"></div>
                    <img src="<?= $baseUrl ?>/assets/images/avatar.svg" alt="Krishna - Developer Avatar" class="hero-avatar" width="220" height="220">
                    <div class="hero-badge-available d-sm-none">
                        <span class="status-dot"></span> Available
                    </div>
                </div>

                <!-- Code Terminal Snippet Card -->
                <div class="portfolio-card p-3 text-start mt-4 mx-auto" style="max-width: 380px; font-family: var(--font-mono); font-size: 0.85rem;">
                    <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom" style="border-color: var(--border-subtle) !important;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></span>
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b;"></span>
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></span>
                        <span class="text-muted ms-auto" style="font-size: 0.75rem;">engineer.php</span>
                    </div>
                    <div class="text-muted">$developer = [</div>
                    <div class="ps-3 text-light">'major' =&gt; <span class="text-info">'Computer Engineering'</span>,</div>
                    <div class="ps-3 text-light">'focus' =&gt; <span class="text-warning">'PHP, MySQL, Cloud'</span>,</div>
                    <div class="ps-3 text-light">'status' =&gt; <span class="text-success">'Ready to Build'</span></div>
                    <div class="text-muted">];</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats Section -->
<section class="py-4">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-number gradient-text">3+</div>
                    <div class="stat-label">Years of Coding</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-number text-info">10+</div>
                    <div class="stat-label">Academic Projects</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-number text-purple" style="color: var(--accent-violet);">8+</div>
                    <div class="stat-label">Core Technologies</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-number text-success">100%</div>
                    <div class="stat-label">Clean Code Focus</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects (Dynamically Queried from MySQL via PDO) -->
<section class="py-5">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><i class="bi bi-stars"></i> Portfolio Highlights</span>
            <h2 class="section-title">Featured <span class="gradient-text">Projects</span></h2>
            <p class="section-subtitle">
                A selection of full-stack web and database applications retrieved dynamically from the MySQL database.
            </p>
        </div>

        <?php if (!$dbActive): ?>
            <!-- Friendly Database Setup Banner -->
            <div class="alert alert-warning border-0 p-4 mb-4 rounded-4 shadow-sm" role="alert">
                <div class="d-flex align-items-start gap-3">
                    <i class="bi bi-database-exclamation fs-2 text-warning"></i>
                    <div>
                        <h5 class="alert-heading fw-bold mb-1">Database Not Connected Yet</h5>
                        <p class="mb-2 small">
                            The portfolio is ready, but MySQL is currently not connected or the database has not been imported.
                            Please import <code class="text-light bg-dark px-2 py-1 rounded">database.sql</code> into your MySQL server via phpMyAdmin or the MySQL CLI to load dynamic records.
                        </p>
                        <a href="<?= $baseUrl ?>/database.sql" download class="btn btn-sm btn-outline-dark fw-semibold">
                            <i class="bi bi-download me-1"></i> Download database.sql
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (!empty($featuredProjects)): ?>
                <?php foreach ($featuredProjects as $project): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="portfolio-card d-flex flex-column">
                            <div class="project-card-img-wrap">
                                <img src="<?= !empty($project['image']) ? e($baseUrl . '/' . ltrim($project['image'], '/')) : e($baseUrl . '/assets/images/projects/project-devportfolio.svg') ?>" 
                                     alt="<?= e($project['title']) ?>" 
                                     class="project-card-img"
                                     onerror="this.src='<?= $baseUrl ?>/assets/images/projects/project-devportfolio.svg'">
                                <div class="project-card-overlay"></div>
                            </div>
                            <div class="project-content">
                                <h3 class="project-title"><?= e($project['title']) ?></h3>
                                <p class="project-desc"><?= e(mb_strimwidth($project['description'], 0, 140, '...')) ?></p>
                                
                                <!-- Tech Stack Badges -->
                                <div class="mb-3">
                                    <?php 
                                    $techs = array_map('trim', explode(',', $project['technologies']));
                                    foreach (array_slice($techs, 0, 4) as $tech): 
                                    ?>
                                        <span class="tech-badge"><?= e($tech) ?></span>
                                    <?php endforeach; ?>
                                </div>

                                <div class="mt-auto d-flex gap-2">
                                    <?php if (!empty($project['github_url'])): ?>
                                        <a href="<?= e($project['github_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-secondary-custom flex-grow-1 text-center justify-content-center">
                                            <i class="bi bi-github"></i> Code
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($project['demo_url']) && $project['demo_url'] !== '#'): ?>
                                        <a href="<?= e($project['demo_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary-custom flex-grow-1 text-center justify-content-center">
                                            <i class="bi bi-box-arrow-up-right"></i> Live Demo
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback empty state -->
                <div class="col-12 text-center py-5">
                    <div class="portfolio-card p-5 mx-auto" style="max-width: 550px;">
                        <i class="bi bi-folder-x fs-1 text-muted mb-3 d-block"></i>
                        <h4 class="fw-bold mb-2">No Projects Found</h4>
                        <p class="text-muted small mb-4">
                            Connect your MySQL database and import <code>database.sql</code> or sign in as administrator to create project showcase items.
                        </p>
                        <a href="<?= $baseUrl ?>/admin/login.php" class="btn btn-sm btn-primary-custom">
                            <i class="bi bi-plus-circle me-1"></i> Add Project via Admin
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?= $baseUrl ?>/projects.php" class="btn btn-secondary-custom px-4">
                View All Projects <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5" style="background: var(--gradient-subtle); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container text-center py-3">
        <h2 class="fw-bold mb-3">Have a Project or Opportunity in Mind?</h2>
        <p class="text-muted mb-4 mx-auto" style="max-width: 550px;">
            I am currently open to engineering internships, technical collaborations, and academic discussions. Feel free to reach out via the secure contact portal.
        </p>
        <a href="<?= $baseUrl ?>/contact.php" class="btn btn-primary-custom px-4 py-2 fs-6">
            <i class="bi bi-send-fill me-1"></i> Send a Message
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
