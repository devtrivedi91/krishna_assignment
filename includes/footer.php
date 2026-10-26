<?php
/**
 * DevPortfolio - Shared Footer Template
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$baseUrl = get_base_url();
$year = date('Y');
?>
    </main>

    <!-- Global Footer -->
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row g-4 align-items-center">
                <!-- Brand Summary -->
                <div class="col-lg-5 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="brand-icon" style="width: 30px; height: 30px; font-size: 0.95rem;">
                            <i class="bi bi-code-slash"></i>
                        </div>
                        <span class="fs-5 fw-bold gradient-text">DevPortfolio</span>
                    </div>
                    <p class="text-muted small mb-2">
                        A dynamic, responsive developer portfolio powered by <strong>PHP 8</strong>, <strong>MySQL</strong>, and <strong>Bootstrap 5</strong>. Built for the Advanced Web Development in PHP college curriculum.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="https://github.com" target="_blank" rel="noopener noreferrer" class="social-link-btn" title="GitHub" style="width: 34px; height: 34px; font-size: 1rem;">
                            <i class="bi bi-github"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-link-btn" title="LinkedIn" style="width: 34px; height: 34px; font-size: 1rem;">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="mailto:alex.rivera@example.com" class="social-link-btn" title="Email" style="width: 34px; height: 34px; font-size: 1rem;">
                            <i class="bi bi-envelope-at"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Quick Links -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="text-light fw-bold text-uppercase small mb-3">Quick Navigation</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                        <li><a href="<?= $baseUrl ?>/index.php" class="footer-link"><i class="bi bi-chevron-right small me-1"></i> Home</a></li>
                        <li><a href="<?= $baseUrl ?>/about.php" class="footer-link"><i class="bi bi-chevron-right small me-1"></i> About Developer</a></li>
                        <li><a href="<?= $baseUrl ?>/skills.php" class="footer-link"><i class="bi bi-chevron-right small me-1"></i> Technical Skills</a></li>
                        <li><a href="<?= $baseUrl ?>/projects.php" class="footer-link"><i class="bi bi-chevron-right small me-1"></i> Projects Showcase</a></li>
                        <li><a href="<?= $baseUrl ?>/contact.php" class="footer-link"><i class="bi bi-chevron-right small me-1"></i> Contact &amp; Inquiries</a></li>
                    </ul>
                </div>

                <!-- Architecture & Security Badge -->
                <div class="col-lg-4 col-md-12 col-6">
                    <h6 class="text-light fw-bold text-uppercase small mb-3">System Specifications</h6>
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        <span class="tech-badge"><i class="bi bi-filetype-php me-1"></i>PHP 8+</span>
                        <span class="tech-badge"><i class="bi bi-database me-1"></i>MySQL PDO</span>
                        <span class="tech-badge"><i class="bi bi-bootstrap me-1"></i>Bootstrap 5</span>
                        <span class="tech-badge"><i class="bi bi-shield-check me-1"></i>CSRF Protection</span>
                        <span class="tech-badge"><i class="bi bi-lock me-1"></i>Bcrypt Hashing</span>
                    </div>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-check2-circle text-success me-1"></i> Prepared Statements Only
                    </p>
                </div>
            </div>

            <hr class="my-4" style="border-color: var(--border-subtle);">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <p class="text-muted small mb-0">
                    &copy; <?= $year ?> DevPortfolio. Designed for B.Tech Computer Engineering Coursework.
                </p>
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= $baseUrl ?>/admin/login.php" class="footer-link small">
                        <i class="bi bi-shield-lock me-1"></i> Admin Login
                    </a>
                    <a href="#top" class="footer-link small" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
                        <i class="bi bi-arrow-up-circle me-1"></i> Back to Top
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Client-Side Script -->
    <script src="<?= $baseUrl ?>/assets/js/script.js"></script>
</body>
</html>
