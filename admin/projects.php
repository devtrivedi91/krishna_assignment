<?php
/**
 * DevPortfolio - Administrator Projects Manager
 * 
 * Displays all showcase projects stored in MySQL database,
 * provides shortcuts to add, edit, preview, and delete projects.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$adminTitle = 'Manage Portfolio Projects';

require_once __DIR__ . '/admin_header.php';

$projects = get_all_projects();
?>

<!-- Header & Controls -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Portfolio <span class="gradient-text">Projects</span></h1>
        <p class="text-muted small mb-0">Manage project showcase entries rendered dynamically on the public portfolio.</p>
    </div>
    <div>
        <a href="<?= $baseUrl ?>/admin/add_project.php" class="btn btn-primary-custom btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Add New Project
        </a>
    </div>
</div>

<!-- Projects Table Card -->
<div class="portfolio-card p-4">
    <?php if (!empty($projects)): ?>
        <div class="table-responsive">
            <table class="table custom-table-dark align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Project Title</th>
                        <th>Technologies</th>
                        <th>Repository / Demo</th>
                        <th>Created</th>
                        <th class="text-end" style="min-width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $proj): ?>
                        <tr>
                            <td>
                                <img src="<?= !empty($proj['image']) ? e($baseUrl . '/' . ltrim($proj['image'], '/')) : e($baseUrl . '/assets/images/projects/project-devportfolio.svg') ?>" 
                                     alt="<?= e($proj['title']) ?>" 
                                     class="rounded" 
                                     style="width: 50px; height: 35px; object-fit: cover; border: 1px solid var(--border-subtle);"
                                     onerror="this.src='<?= $baseUrl ?>/assets/images/projects/project-devportfolio.svg'">
                            </td>
                            <td>
                                <div class="fw-bold text-light"><?= e($proj['title']) ?></div>
                                <div class="text-muted small text-truncate" style="max-width: 300px;"><?= e($proj['description']) ?></div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                    <?php 
                                    $techList = array_map('trim', explode(',', $proj['technologies']));
                                    foreach (array_slice($techList, 0, 3) as $t): 
                                    ?>
                                        <span class="tech-badge" style="font-size: 0.7rem;"><?= e($t) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1 small">
                                    <?php if (!empty($proj['github_url'])): ?>
                                        <a href="<?= e($proj['github_url']) ?>" target="_blank" class="text-info text-decoration-none">
                                            <i class="bi bi-github me-1"></i> GitHub
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($proj['demo_url']) && $proj['demo_url'] !== '#'): ?>
                                        <a href="<?= e($proj['demo_url']) ?>" target="_blank" class="text-success text-decoration-none">
                                            <i class="bi bi-box-arrow-up-right me-1"></i> Demo
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-muted small font-monospace">
                                <?= date('M j, Y', strtotime($proj['created_at'])) ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="<?= $baseUrl ?>/admin/edit_project.php?id=<?= (int)$proj['id'] ?>" class="btn btn-sm btn-secondary-custom" title="Edit Project">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form id="del-proj-<?= (int)$proj['id'] ?>" action="<?= $baseUrl ?>/admin/delete_project.php" method="POST" class="d-inline">
                                        <?= csrf_input() ?>
                                        <input type="hidden" name="id" value="<?= (int)$proj['id'] ?>">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="if(confirm('Are you sure you want to permanently delete the project \'<?= addslashes(e($proj['title'])) ?>\'?')) { document.getElementById('del-proj-<?= (int)$proj['id'] ?>').submit(); }"
                                                title="Delete Project">
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
            <i class="bi bi-folder-x fs-1 d-block mb-2 text-dim"></i>
            <h3 class="h5 fw-bold mb-1">No Projects Found</h3>
            <p class="small mb-3">No showcase records in the database. Add your first project below.</p>
            <a href="<?= $baseUrl ?>/admin/add_project.php" class="btn btn-sm btn-primary-custom">
                <i class="bi bi-plus-circle me-1"></i> Create Project
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
