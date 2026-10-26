<?php
/**
 * DevPortfolio - Contact & Inquiry Page
 * 
 * Features client-side & server-side validated contact form,
 * CSRF protection, bot honeypot detection, and PDO database storage.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$pageTitle = 'Contact — Send a Message';
$metaDescription = 'Contact Krishna for software engineering opportunities, technical inquiries, and project collaborations. Secure PHP/MySQL message handling.';

require_once __DIR__ . '/includes/header.php';

// Retrieve any old input preserved across redirect if submission failed
$oldInput = $_SESSION['old_contact_input'] ?? [];
unset($_SESSION['old_contact_input']);
?>

<div class="container py-5">
    <!-- Page Header -->
    <div class="section-header">
        <span class="section-tag"><i class="bi bi-chat-square-text-fill"></i> Get In Touch</span>
        <h1 class="section-title">Contact <span class="gradient-text">Me</span></h1>
        <p class="section-subtitle">
            Have an internship inquiry, project collaboration idea, or question? Send a message below and it will be stored directly into the MySQL database.
        </p>
    </div>

    <div class="row g-5">
        <!-- Contact Form Column -->
        <div class="col-lg-7">
            <div class="portfolio-card p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon" style="width: 44px; height: 44px; font-size: 1.2rem;">
                        <i class="bi bi-send"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-0">Send a Direct Message</h2>
                        <span class="text-muted small">Validated &amp; Stored securely via PHP PDO</span>
                    </div>
                </div>

                <!-- Contact Form -->
                <form id="contactForm" action="<?= $baseUrl ?>/process_contact.php" method="POST" class="needs-validation" novalidate>
                    <!-- CSRF Token -->
                    <?= csrf_input() ?>

                    <!-- Spam Prevention Honeypot Field (Hidden from humans) -->
                    <div class="hp-field" aria-hidden="true">
                        <label for="website">Leave this field blank</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="row g-3">
                        <!-- Sender Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Your Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary border-opacity-25 text-muted">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="e.g. Jane Doe" 
                                       value="<?= e($oldInput['name'] ?? '') ?>" 
                                       required 
                                       minlength="2" 
                                       maxlength="100">
                                <div class="invalid-feedback">
                                    Please provide your name (at least 2 characters).
                                </div>
                            </div>
                        </div>

                        <!-- Sender Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary border-opacity-25 text-muted">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       placeholder="jane@example.com" 
                                       value="<?= e($oldInput['email'] ?? '') ?>" 
                                       required 
                                       maxlength="150">
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary border-opacity-25 text-muted">
                                    <i class="bi bi-chat-left-dots"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="subject" 
                                       name="subject" 
                                       placeholder="e.g. Software Engineering Opportunity / Academic Inquiry" 
                                       value="<?= e($oldInput['subject'] ?? '') ?>" 
                                       required 
                                       minlength="3" 
                                       maxlength="200">
                                <div class="invalid-feedback">
                                    Please provide a message subject (at least 3 characters).
                                </div>
                            </div>
                        </div>

                        <!-- Message Body -->
                        <div class="col-12">
                            <label for="message" class="form-label">Message Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                      id="message" 
                                      name="message" 
                                      rows="5" 
                                      placeholder="Write your message here... Share details about your query or proposal." 
                                      required 
                                      minlength="10" 
                                      maxlength="5000"><?= e($oldInput['message'] ?? '') ?></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <div class="invalid-feedback d-block text-muted small" style="display: none !important;">
                                    Message must be at least 10 characters.
                                </div>
                                <span class="text-muted small ms-auto">Min 10 characters</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary-custom w-100 justify-content-center py-3 fs-6">
                                <i class="bi bi-send-fill me-2"></i> Send Message Now
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Information & Quick Details Column -->
        <div class="col-lg-5">
            <!-- Information Card -->
            <div class="portfolio-card p-4 p-md-5 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon" style="width: 44px; height: 44px; font-size: 1.2rem;">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div>
                        <h2 class="h5 fw-bold mb-0">Contact Details</h2>
                        <span class="text-muted small">Location &amp; Communication Channels</span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-4">
                    <!-- Email Item -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="social-link-btn flex-shrink-0" style="color: var(--accent-cyan); background: rgba(56,189,248,0.1);">
                            <i class="bi bi-envelope-at-fill"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Direct Email</div>
                            <a href="mailto:krishna@example.com" class="text-light fw-semibold">krishna@example.com</a>
                            <div class="text-muted small">Replies typically within 24 hours</div>
                        </div>
                    </div>

                    <!-- Location Item -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="social-link-btn flex-shrink-0" style="color: var(--accent-violet); background: rgba(139,92,246,0.1);">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Campus Location</div>
                            <span class="text-light fw-semibold">Bangalore, Karnataka, India</span>
                            <div class="text-muted small">School of Computer Engineering</div>
                        </div>
                    </div>

                    <!-- Academic Hours -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="social-link-btn flex-shrink-0" style="color: #34d399; background: rgba(16,185,129,0.1);">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Availability</div>
                            <span class="text-light fw-semibold">Monday — Friday: 9:00 AM – 6:00 PM IST</span>
                            <div class="text-muted small">Open to engineering discussions</div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: var(--border-subtle);">

                <!-- Social Connect Links -->
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-3" style="letter-spacing: 0.05em;">Professional Profiles</div>
                    <div class="d-flex gap-2">
                        <a href="https://github.com" target="_blank" rel="noopener noreferrer" class="btn btn-secondary-custom btn-sm">
                            <i class="bi bi-github me-1"></i> GitHub
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="btn btn-secondary-custom btn-sm">
                            <i class="bi bi-linkedin me-1"></i> LinkedIn
                        </a>
                    </div>
                </div>
            </div>

            <!-- Security Notice Card -->
            <div class="portfolio-card p-4">
                <div class="d-flex align-items-center gap-2 mb-2 text-info">
                    <i class="bi bi-shield-check fs-5"></i>
                    <h3 class="h6 fw-bold mb-0">Secure Form Processing</h3>
                </div>
                <p class="text-muted small mb-0">
                    Submissions are verified against CSRF tokens, checked against spam honeypots, and persisted safely using <strong>PDO prepared statements</strong> with parameter binding to prevent SQL injection.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
