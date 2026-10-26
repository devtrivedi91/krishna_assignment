<?php
/**
 * DevPortfolio - Administrator Inquiries / Messages Manager
 * 
 * Provides moderation for submitted contact inquiries: filter by status,
 * full text search, mark as read/unread, inspect full message details, 
 * and securely delete entries with confirmation prompts.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$adminTitle = 'Contact Inquiries & Moderation';

require_once __DIR__ . '/admin_header.php';

// Filter and Search inputs
$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['all', 'unread', 'read'], true) ? $_GET['filter'] : 'all';
$search = isset($_GET['search']) ? sanitize_input((string)$_GET['search']) : '';

// Retrieve matching messages
$messages = get_contact_messages($filter, $search);
?>

<!-- Header & Controls -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Contact <span class="gradient-text">Inquiries</span></h1>
        <p class="text-muted small mb-0">Review, moderate, and respond to messages submitted by visitors.</p>
    </div>
    
    <!-- Filter Pills -->
    <div class="btn-group shadow-sm" role="group" aria-label="Filter status">
        <a href="<?= $baseUrl ?>/admin/messages.php?filter=all<?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="btn btn-sm <?= ($filter === 'all') ? 'btn-primary-custom' : 'btn-secondary-custom' ?>">
            All
        </a>
        <a href="<?= $baseUrl ?>/admin/messages.php?filter=unread<?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="btn btn-sm <?= ($filter === 'unread') ? 'btn-primary-custom' : 'btn-secondary-custom' ?>">
            Unread
        </a>
        <a href="<?= $baseUrl ?>/admin/messages.php?filter=read<?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="btn btn-sm <?= ($filter === 'read') ? 'btn-primary-custom' : 'btn-secondary-custom' ?>">
            Read
        </a>
    </div>
</div>

<!-- Search Form Bar -->
<div class="portfolio-card p-3 mb-4">
    <form action="<?= $baseUrl ?>/admin/messages.php" method="GET" class="row g-2 align-items-center">
        <input type="hidden" name="filter" value="<?= e($filter) ?>">
        <div class="col-md-9 col-sm-8">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary border-opacity-25 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       name="search" 
                       class="form-control form-control-sm" 
                       placeholder="Search by sender name, email, subject, or message body..." 
                       value="<?= e($search) ?>">
            </div>
        </div>
        <div class="col-md-3 col-sm-4 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-primary-custom flex-grow-1 justify-content-center">
                Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= $baseUrl ?>/admin/messages.php?filter=<?= e($filter) ?>" class="btn btn-sm btn-secondary-custom" title="Clear Search">
                    <i class="bi bi-x-lg"></i>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Messages Table Card -->
<div class="portfolio-card p-4">
    <?php if (!empty($messages)): ?>
        <div class="table-responsive">
            <table class="table custom-table-dark align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 90px;">Status</th>
                        <th>Sender Name</th>
                        <th>Email Address</th>
                        <th>Subject</th>
                        <th>Date &amp; Time</th>
                        <th class="text-end" style="min-width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td>
                                <?php if ($msg['status'] === 'unread'): ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-envelope-fill me-1"></i>Unread</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-light"><i class="bi bi-envelope-open me-1"></i>Read</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold text-light"><?= e($msg['name']) ?></td>
                            <td>
                                <a href="mailto:<?= e($msg['email']) ?>" class="text-info text-decoration-none small">
                                    <i class="bi bi-envelope me-1"></i><?= e($msg['email']) ?>
                                </a>
                            </td>
                            <td class="text-truncate" style="max-width: 260px;">
                                <span class="fw-semibold text-light"><?= e($msg['subject']) ?></span>
                            </td>
                            <td class="text-muted small font-monospace">
                                <?= format_date($msg['created_at']) ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <!-- View Modal Trigger -->
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
                                            title="View message">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Status Toggle Form -->
                                    <form action="<?= $baseUrl ?>/admin/update_status.php" method="POST" class="d-inline">
                                        <?= csrf_input() ?>
                                        <input type="hidden" name="id" value="<?= (int)$msg['id'] ?>">
                                        <input type="hidden" name="status" value="<?= ($msg['status'] === 'unread') ? 'read' : 'unread' ?>">
                                        <input type="hidden" name="redirect" value="messages.php">
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-violet" 
                                                title="Mark as <?= ($msg['status'] === 'unread') ? 'Read' : 'Unread' ?>">
                                            <i class="bi <?= ($msg['status'] === 'unread') ? 'bi-check2' : 'bi-arrow-counterclockwise' ?>"></i>
                                        </button>
                                    </form>

                                    <!-- Delete Message Form -->
                                    <form id="delete-form-<?= (int)$msg['id'] ?>" action="<?= $baseUrl ?>/admin/delete_message.php" method="POST" class="d-inline">
                                        <?= csrf_input() ?>
                                        <input type="hidden" name="id" value="<?= (int)$msg['id'] ?>">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="if(confirm('Are you sure you want to permanently delete this message from <?= addslashes(e($msg['name'])) ?>?')) { document.getElementById('delete-form-<?= (int)$msg['id'] ?>').submit(); }"
                                                title="Delete Message">
                                            <i class="bi bi-trash3"></i>
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
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 text-dim"></i>
            <h3 class="h5 fw-bold mb-1">No Inquiries Found</h3>
            <p class="small mb-0">
                <?= !empty($search) ? 'No messages match your search query "' . e($search) . '".' : 'There are currently no messages in this category.' ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- Reusable View Message Modal -->
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
