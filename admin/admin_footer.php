<?php
/**
 * DevPortfolio - Admin Shared Footer
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$baseUrl = get_base_url();
?>
        </div>
    </main>

    <!-- Admin Footer -->
    <footer class="footer-custom mt-auto py-3">
        <div class="container-fluid px-lg-4 text-center text-sm-start d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <span class="text-muted small">
                DevPortfolio Administration Console &bull; Advanced Web Development in PHP
            </span>
            <span class="text-muted small">
                PHP <?= phpversion() ?> &bull; MySQL PDO &bull; Protected Session
            </span>
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Client-Side Script -->
    <script src="<?= $baseUrl ?>/assets/js/script.js"></script>
</body>
</html>
