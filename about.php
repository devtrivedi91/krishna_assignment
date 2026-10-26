<?php
/**
 * DevPortfolio - About Developer Page
 * 
 * Education history, technical interests, career objectives,
 * academic achievements, certifications, and core competencies.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$pageTitle = 'About Me — Developer Profile';
$metaDescription = 'Educational background, technical interests, career goals, and academic achievements of Krishna, B.Tech Computer Engineering student.';

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-5">
    <!-- Page Header -->
    <div class="section-header">
        <span class="section-tag"><i class="bi bi-person-badge"></i> Background &amp; Profile</span>
        <h1 class="section-title">About <span class="gradient-text">Krishna</span></h1>
        <p class="section-subtitle">
            An overview of my academic trajectory, engineering philosophies, technical interests, and professional milestones.
        </p>
    </div>

    <div class="row g-5">
        <!-- Left Column: Biography & Career Objectives -->
        <div class="col-lg-7">
            <!-- Career Objective Card -->
            <div class="portfolio-card p-4 p-md-5 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon" style="width: 48px; height: 48px; font-size: 1.35rem;">
                        <i class="bi bi-compass"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-0">Career Objective</h2>
                        <span class="text-muted small">Professional Mission &amp; Engineering Focus</span>
                    </div>
                </div>
                <p class="text-light mb-3" style="line-height: 1.8;">
                    As a dedicated <strong>B.Tech Computer Engineering</strong> student, my objective is to leverage robust principles of software architecture, backend engineering, and database systems to design scalable web platforms that solve real-world problems.
                </p>
                <p class="text-muted mb-0" style="line-height: 1.8;">
                    I aim to collaborate with high-impact software engineering teams where I can contribute to mission-critical codebases, optimize query performance in relational databases like MySQL, and deliver secure, accessible, and user-centric web applications.
                </p>
            </div>

            <!-- Education Timeline -->
            <div class="portfolio-card p-4 p-md-5 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon" style="width: 48px; height: 48px; font-size: 1.35rem;">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-0">Education History</h2>
                        <span class="text-muted small">Academic Milestones &amp; Key Coursework</span>
                    </div>
                </div>

                <div class="timeline mt-4">
                    <!-- Degree -->
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 mb-1">
                            <h3 class="h5 fw-bold mb-0 text-light">Bachelor of Technology in Computer Engineering</h3>
                            <span class="badge bg-primary-subtle text-info border border-primary-subtle rounded-pill">2022 — 2026 (Expected)</span>
                        </div>
                        <p class="text-muted small mb-2">School of Engineering &amp; Technology • Cumulative GPA: 8.7 / 10.0</p>
                        <p class="text-light small mb-3">
                            Comprehensive study in software engineering principles, algorithm design, relational database modeling, and distributed web platforms.
                        </p>
                        <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle);">
                            <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">Key Coursework:</div>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="tech-badge">Advanced Web Dev in PHP</span>
                                <span class="tech-badge">Database Management Systems</span>
                                <span class="tech-badge">Data Structures &amp; Algorithms</span>
                                <span class="tech-badge">Operating Systems</span>
                                <span class="tech-badge">Computer Networks</span>
                                <span class="tech-badge">Object-Oriented Programming (Java/C++)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Senior Secondary / High School -->
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 mb-1">
                            <h3 class="h5 fw-bold mb-0 text-light">Higher Secondary Education (Science &amp; Mathematics)</h3>
                            <span class="badge bg-secondary-subtle text-light border border-secondary-subtle rounded-pill">2020 — 2022</span>
                        </div>
                        <p class="text-muted small mb-2">Pre-University Science College • Score: 92.4%</p>
                        <p class="text-muted small mb-0">
                            Focused curriculum in Physics, Chemistry, Higher Mathematics, and Computer Science Fundamentals (C++ and Python basics).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Technical Interests -->
            <div class="portfolio-card p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon" style="width: 48px; height: 48px; font-size: 1.35rem;">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-0">Technical Interests</h2>
                        <span class="text-muted small">Fields of Exploration &amp; Research</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-server text-info fs-5"></i>
                                <h3 class="h6 fw-bold mb-0">Backend Architecture</h3>
                            </div>
                            <p class="text-muted small mb-0">
                                Designing modular RESTful endpoints, clean MVC layouts, session management, and microservice communications.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-database-check text-warning fs-5"></i>
                                <h3 class="h6 fw-bold mb-0">Database Optimization</h3>
                            </div>
                            <p class="text-muted small mb-0">
                                Schema normalization, index design, query optimization in MySQL, and transaction safety with PDO prepared statements.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-shield-lock text-success fs-5"></i>
                                <h3 class="h6 fw-bold mb-0">Application Security</h3>
                            </div>
                            <p class="text-muted small mb-0">
                                XSS mitigation, CSRF verification tokens, SQL injection defense, and password hashing algorithms (Bcrypt/Argon2).
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-cloud-arrow-up text-primary fs-5"></i>
                                <h3 class="h6 fw-bold mb-0">Cloud &amp; Deployment</h3>
                            </div>
                            <p class="text-muted small mb-0">
                                Linux server configuration, Apache/Nginx web server tuning, and deployment workflows for production hosting environments.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Profile Summary & Academic Achievements -->
        <div class="col-lg-5">
            <!-- Profile Overview Card -->
            <div class="portfolio-card p-4 text-center mb-4">
                <div class="hero-avatar-wrapper mb-3">
                    <img src="<?= $baseUrl ?>/assets/images/avatar.svg" alt="Krishna" class="hero-avatar" style="width: 150px; height: 150px;">
                </div>
                <h2 class="h4 fw-bold mb-1">Krishna</h2>
                <p class="text-info small fw-semibold mb-3">B.Tech in Computer Engineering</p>
                <p class="text-muted small mb-4">
                    Based in Bangalore, India • Passionate learner, open-source contributor, and software engineering enthusiast.
                </p>

                <div class="d-grid gap-2">
                    <a href="<?= $baseUrl ?>/contact.php" class="btn btn-primary-custom justify-content-center">
                        <i class="bi bi-envelope"></i> Contact Developer
                    </a>
                    <a href="<?= $baseUrl ?>/projects.php" class="btn btn-secondary-custom justify-content-center">
                        <i class="bi bi-folder2-open"></i> Browse Projects
                    </a>
                </div>
            </div>

            <!-- Academic Achievements & Certifications -->
            <div class="portfolio-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon" style="width: 44px; height: 44px; font-size: 1.2rem;">
                        <i class="bi bi-award"></i>
                    </div>
                    <div>
                        <h2 class="h5 fw-bold mb-0">Academic Achievements</h2>
                        <span class="text-muted small">Recognitions &amp; Credentials</span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    <!-- Achievement 1 -->
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                        <i class="bi bi-trophy-fill text-warning fs-4 mt-1"></i>
                        <div>
                            <h3 class="h6 fw-bold mb-1 text-light">University Hackathon Finalist</h3>
                            <p class="text-muted small mb-0">
                                Built an emergency volunteer response portal using PHP and MySQL, recognized among top 10 finalist teams.
                            </p>
                            <span class="text-dim small" style="font-size: 0.75rem;">Annual TechFest 2024</span>
                        </div>
                    </div>

                    <!-- Achievement 2 -->
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                        <i class="bi bi-patch-check-fill text-info fs-4 mt-1"></i>
                        <div>
                            <h3 class="h6 fw-bold mb-1 text-light">Dean's List of Academic Excellence</h3>
                            <p class="text-muted small mb-0">
                                Maintained top percentile academic standing across semesters in core Computer Engineering coursework.
                            </p>
                            <span class="text-dim small" style="font-size: 0.75rem;">Semesters III, IV &amp; V</span>
                        </div>
                    </div>

                    <!-- Achievement 3 -->
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle);">
                        <i class="bi bi-file-earmark-check-fill text-success fs-4 mt-1"></i>
                        <div>
                            <h3 class="h6 fw-bold mb-1 text-light">Web Development Certification</h3>
                            <p class="text-muted small mb-0">
                                Completed advanced certification covering PHP 8, MySQL database design, PDO, and Bootstrap 5 responsive frameworks.
                            </p>
                            <span class="text-dim small" style="font-size: 0.75rem;">Certified Web Developer Track</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Competency Badges -->
            <div class="portfolio-card p-4">
                <h3 class="h6 fw-bold text-uppercase mb-3" style="letter-spacing: 0.05em; font-size: 0.8rem; color: var(--text-muted);">
                    Core Competencies
                </h3>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-dark border text-light py-2 px-3"><i class="bi bi-check-lg text-success me-1"></i> Object-Oriented PHP</span>
                    <span class="badge bg-dark border text-light py-2 px-3"><i class="bi bi-check-lg text-success me-1"></i> Relational MySQL</span>
                    <span class="badge bg-dark border text-light py-2 px-3"><i class="bi bi-check-lg text-success me-1"></i> PDO Prepared Queries</span>
                    <span class="badge bg-dark border text-light py-2 px-3"><i class="bi bi-check-lg text-success me-1"></i> Secure Authentication</span>
                    <span class="badge bg-dark border text-light py-2 px-3"><i class="bi bi-check-lg text-success me-1"></i> Git Version Control</span>
                    <span class="badge bg-dark border text-light py-2 px-3"><i class="bi bi-check-lg text-success me-1"></i> Responsive Layouts</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
