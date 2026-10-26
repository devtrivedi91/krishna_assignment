<?php
/**
 * DevPortfolio - Administrator Dashboard Overview
 * 
 * Displays aggregate metrics for contact inquiries and projects,
 * previews recent submissions, and provides quick management shortcuts.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$adminTitle = 'Dashboard Overview';

require_once __DIR__ . '/admin_header.php';

// Retrieve aggregate stats & recent messages
$stats = get_dashboard_stats();
$recentMessages = get_contact_messages('all');
$recentMessages = array_slice($recentMessages, 0, 5);
$allProjects = get_all_projects();
?>

<!-- Dashboard Top Banner -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Administrative <span class="gradient-text">Dashboard</span></h1>
        <p class="text-muted small mb-0">Overview of portfolio inquiries, database health, and project showcase contents.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $baseUrl ?>/admin/messages.php" class="btn btn-sm btn-primary-custom">
            <i class="bi bi-inbox-fill"></i> View Inquiries (<?= (int)$stats['unread_messages'] ?> unread)
        </a>
        <a href="<?= $baseUrl ?>/admin/add_project.php" class="btn btn-sm btn-secondary-custom">
            <i class="bi bi-plus-circle"></i> Add New Project
        </a>
    </div>
</div>

<!-- Metrics Cards Row -->
<div class="row g-3 mb-4">
    <!-- Unread Messages Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="portfolio-card p-3 p-xl-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Unread Inquiries</span>
                <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem; background: rgba(245, 158, 11, 0.2); color: #f59e0b;">
                    <i class="bi bi-envelope-exclamation-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="display-6 fw-bold <?= ($stats['unread_messages'] > 0) ? 'text-warning' : 'text-light' ?>">
                    <?= (int)$stats['unread_messages'] ?>
                </span>
                <span class="text-muted small">pending review</span>
            </div>
        </div>
    </div>

    <!-- Total Inquiries Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="portfolio-card p-3 p-xl-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Total Inquiries</span>
                <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem; background: rgba(56, 189, 248, 0.2); color: #38bdf8;">
                    <i class="bi bi-chat-left-text-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="display-6 fw-bold text-light">
                    <?= (int)$stats['total_messages'] ?>
                </span>
                <span class="text-muted small">received</span>
            </div>
        </div>
    </div>

    <!-- Total Showcase Projects -->
    <div class="col-sm-6 col-xl-3">
        <div class="portfolio-card p-3 p-xl-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Active Projects</span>
                <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem; background: rgba(139, 92, 246, 0.2); color: #a855f7;">
                    <i class="bi bi-folder-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="display-6 fw-bold text-light">
                    <?= (int)$stats['total_projects'] ?>
                </span>
                <span class="text-muted small">in database</span>
            </div>
        </div>
    </div>

    <!-- Database Status -->
    <div class="col-sm-6 col-xl-3">
        <div class="portfolio-card p-3 p-xl-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Database Health</span>
                <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem; background: <?= $stats['db_connected'] ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' ?>; color: <?= $stats['db_connected'] ? '#10b981' : '#ef4444' ?>;">
                    <i class="bi bi-hdd-network-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="h4 fw-bold mb-0 <?= $stats['db_connected'] ? 'text-success' : 'text-danger' ?>">
                    <?= $stats['db_connected'] ? 'Online &amp; Active' : 'Disconnected' ?>
                </span>
            </div>
            <span class="text-muted small" style="font-size: 0.75rem;">MySQL via PDO Prepared</span>
        </div>
    </div>
</div>

<!-- Recent Messages Table -->
<div class="portfolio-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="h5 fw-bold mb-1"><i class="bi bi-clock-history me-2 text-info"></i>Recent Contact Inquiries</h2>
            <p class="text-muted small mb-0">Latest visitor submissions received through the contact form.</p>
        </div>
        <a href="<?= $baseUrl ?>/admin/messages.php" class="btn btn-sm btn-outline-violet">
            View All (<?= (int)$stats['total_messages'] ?>)
        </a>
    </div>

    <?php if (!empty($recentMessages)): ?>
        <div class="table-responsive">
            <table class="table custom-table-dark align-middle mb-0">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sender</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentMessages as $msg): ?>
                        <tr>
                            <td>
                                <?php if ($msg['status'] === 'unread'): ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-envelope-fill me-1"></i>Unread</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-light"><i class="bi bi-envelope-open me-1"></i>Read</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold text-light"><?= e($msg['name']) ?></td>
                            <td>
                                <a href="mailto:<?= e($msg['email']) ?>" class="text-info small text-decoration-none">
                                    <?= e($msg['email']) ?>
                                </a>
                            </td>
                            <td class="text-truncate" style="max-width: 250px;">
                                <?= e($msg['subject']) ?>
                            </td>
                            <td class="text-muted small font-monospace">
                                <?= format_date($msg['created_at']) ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <!-- View Modal Trigger Button -->
                                    <button type="button" 
                                            class="btn btn-sm btn-secondary-custom" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewMessageModal"
                                            data-id="<?= (int)$msg['id'] ?>"
                                            data-name="<?= e($msg['name']) ?>"
                                            data-email="<?= e($msg['email']) ?>"
                                            data-subject="<?= e($msg['subject']) ?>"
                                            data-message="<?= e($msg['message']) ?>"
                                            data-date="<?= e(format_date($msg['created_at'])) ?>"
                                            title="View message content">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Quick Toggle Read/Unread Form -->
                                    <form action="<?= $baseUrl ?>/admin/update_status.php" method="POST" class="d-inline">
                                        <?= csrf_input() ?>
                                        <input type="hidden" name="id" value="<?= (int)$msg['id'] ?>">
                                        <input type="hidden" name="status" value="<?= ($msg['status'] === 'unread') ? 'read' : 'unread' ?>">
                                        <input type="hidden" name="redirect" value="dashboard.php">
                                        <button type="submit" class="btn btn-sm btn-outline-violet" title="Mark as <?= ($msg['status'] === 'unread') ? 'Read' : 'Unread' ?>">
                                            <i class="bi <?= ($msg['status'] === 'unread') ? 'bi-check2' : 'bi-arrow-counterclockwise' ?>"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-4 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 text-dim"></i>
            <p class="mb-0">No contact messages received yet. Submit a message via the public contact form to test!</p>
        </div>
    <?php endif; ?>
</div>

<!-- Message Detail Modal (Shared) -->
<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content dark-modal">
            <div class="modal-header dark-modal-header">
                <h3 class="modal-title h5 fw-bold" id="viewMessageModalLabel">
                    <i class="bi bi-envelope-open-fill text-info me-2"></i> Message Details
                </h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="text-muted small fw-semibold text-uppercase">Sender Name</label>
                        <div id="modalMsgSender" class="fw-bold text-light"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-semibold text-uppercase">Email Address</label>
                        <div><a id="modalMsgEmail" href="#" class="text-info fw-semibold"></a></div>
                    </div>
                    <div class="col-sm-8">
                        <label class="text-muted small fw-semibold text-uppercase">Subject</label>
                        <div id="modalMsgSubject" class="text-light fw-semibold"></div>
                    </div>
                    <div class="col-sm-4">
                        <label class="text-muted small fw-semibold text-uppercase">Date Received</label>
                        <div id="modalMsgDate" class="text-muted small font-monospace"></div>
                    </div>
                </div>
                <hr style="border-color: var(--border-subtle);">
                <div>
                    <label class="text-muted small fw-semibold text-uppercase mb-2">Message Body</label>
                    <div id="modalMsgContent" class="p-3 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-subtle); white-space: pre-wrap; font-size: 0.95rem; line-height: 1.6;"></div>
                </div>
            </div>
            <div class="modal-footer dark-modal-footer">
                <button type="button" class="btn btn-secondary-custom btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
