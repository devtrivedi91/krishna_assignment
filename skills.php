<?php
/**
 * DevPortfolio - Technical Skills & Stack Breakdown
 * 
 * Detailed breakdown of programming languages, frontend tools,
 * backend technologies, databases, and engineering workflows.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

declare(strict_types=1);

$pageTitle = 'Skills — Technical Stack';
$metaDescription = 'Explore technical skills across programming languages, frontend engineering, backend development with PHP & Node.js, MySQL databases, and developer tools.';

require_once __DIR__ . '/includes/header.php';

// Organized Skills Data Matrix
$skillCategories = [
    [
        'category' => 'Programming Languages',
        'icon'     => 'bi-terminal',
        'desc'     => 'Core algorithmic and procedural programming foundations built throughout Computer Engineering coursework.',
        'skills'   => [
            ['name' => 'PHP 8+', 'level' => 90, 'desc' => 'PDO, OOP, Session Security, Prepared Queries, REST APIs'],
            ['name' => 'Java', 'level' => 85, 'desc' => 'Core OOP, Collections, Multithreading, Exception Handling'],
            ['name' => 'Python', 'level' => 80, 'desc' => 'Scripting, Data Analysis, Automation, Flask basics'],
            ['name' => 'JavaScript (ES6+)', 'level' => 85, 'desc' => 'DOM Manipulation, Fetch API, Async/Await, Events'],
            ['name' => 'C / C++', 'level' => 75, 'desc' => 'Pointers, Memory Allocation, Data Structures, Algorithms'],
        ]
    ],
    [
        'category' => 'Backend Development',
        'icon'     => 'bi-server',
        'desc'     => 'Server-side application logic, database abstraction, authorization safeguards, and modular architecture.',
        'skills'   => [
            ['name' => 'PHP (Core & OOP)', 'level' => 92, 'desc' => 'Robust procedural & object-oriented backend programming'],
            ['name' => 'PDO (PHP Data Objects)', 'level' => 90, 'desc' => 'Parameter binding, transaction safety, error modes'],
            ['name' => 'Node.js & Express', 'level' => 75, 'desc' => 'Asynchronous event loops, REST services, npm modules'],
            ['name' => 'Authentication & Sessions', 'level' => 88, 'desc' => 'Bcrypt hashing, CSRF tokens, session regeneration'],
        ]
    ],
    [
        'category' => 'Frontend Engineering',
        'icon'     => 'bi-layout-text-window-reverse',
        'desc'     => 'Semantic HTML5 structures, accessible UI components, modern styling, and responsive viewport design.',
        'skills'   => [
            ['name' => 'Bootstrap 5', 'level' => 92, 'desc' => 'Grid layout, utilities, modals, toasts, responsive navbar'],
            ['name' => 'HTML5 & Semantic Markup', 'level' => 95, 'desc' => 'Accessibility (ARIA), clean DOM tree, SEO basics'],
            ['name' => 'CSS3 & Custom Properties', 'level' => 88, 'desc' => 'Flexbox, CSS Grid, Glassmorphism, animations'],
            ['name' => 'Client-Side Validation', 'level' => 85, 'desc' => 'Form constraints, interactive error indicators, regex'],
        ]
    ],
    [
        'category' => 'Databases & Storage',
        'icon'     => 'bi-database',
        'desc'     => 'Relational schema design, SQL queries, indexing, and NoSQL document persistence.',
        'skills'   => [
            ['name' => 'MySQL', 'level' => 90, 'desc' => 'Relational schemas, foreign keys, indexing, phpMyAdmin'],
            ['name' => 'SQL Queries & Optimization', 'level' => 88, 'desc' => 'JOINs, aggregates, prepared statements, subqueries'],
            ['name' => 'MongoDB', 'level' => 70, 'desc' => 'BSON documents, collections, aggregation pipelines'],
        ]
    ],
    [
        'category' => 'Tools & Development Workflows',
        'icon'     => 'bi-tools',
        'desc'     => 'Industry standard developer toolchains for source control, local debugging, and deployment.',
        'skills'   => [
            ['name' => 'Git & GitHub', 'level' => 88, 'desc' => 'Branching, commits, pull requests, collaborative versioning'],
            ['name' => 'VS Code', 'level' => 95, 'desc' => 'Integrated debugging, PHP linter extensions, shortcuts'],
            ['name' => 'phpMyAdmin & XAMPP', 'level' => 90, 'desc' => 'Local LAMP/WAMP development, SQL database exports'],
            ['name' => 'SmarterASP.NET / Hosting', 'level' => 82, 'desc' => 'FTP uploads, remote MySQL configuration, DNS setup'],
        ]
    ]
];
?>

<div class="container py-5">
    <!-- Page Header -->
    <div class="section-header">
        <span class="section-tag"><i class="bi bi-stack"></i> Expertise &amp; Toolchain</span>
        <h1 class="section-title">Technical <span class="gradient-text">Skills</span></h1>
        <p class="section-subtitle">
            A comprehensive overview of programming languages, frontend systems, backend architectures, and database technologies utilized in my engineering projects.
        </p>
    </div>

    <!-- Skills Grid -->
    <div class="row g-4">
        <?php foreach ($skillCategories as $cat): ?>
            <div class="col-lg-6">
                <div class="skill-category-card">
                    <div class="skill-cat-header">
                        <div class="skill-cat-icon">
                            <i class="bi <?= e($cat['icon']) ?>"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-1"><?= e($cat['category']) ?></h2>
                            <p class="text-muted small mb-0"><?= e($cat['desc']) ?></p>
                        </div>
                    </div>

                    <!-- Skills List -->
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($cat['skills'] as $skill): ?>
                            <div class="skill-item">
                                <div class="skill-info">
                                    <span class="text-light"><?= e($skill['name']) ?></span>
                                    <span class="text-info font-monospace small"><?= (int)$skill['level'] ?>%</span>
                                </div>
                                <div class="progress-custom mb-1" role="progressbar" aria-valuenow="<?= (int)$skill['level'] ?>" aria-valuemin="0" aria-valuemax="100" aria-label="<?= e($skill['name']) ?> proficiency">
                                    <div class="progress-bar-custom" style="width: <?= (int)$skill['level'] ?>%;"></div>
                                </div>
                                <div class="text-muted small" style="font-size: 0.78rem;">
                                    <?= e($skill['desc']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Practical Application Spotlight -->
    <div class="mt-5 portfolio-card p-4 p-md-5">
        <div class="row align-items-center g-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="brand-icon" style="width: 42px; height: 42px; font-size: 1.2rem;">
                        <i class="bi bi-code-square"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-0">Practical Application in Action</h2>
                </div>
                <p class="text-muted mb-0">
                    All technical skills shown above are continuously exercised in real web projects. Every project incorporates prepared PDO SQL statements, structured relational schemas, and responsive Bootstrap 5 interfaces.
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?= $baseUrl ?>/projects.php" class="btn btn-primary-custom">
                    <i class="bi bi-arrow-right-circle"></i> Inspect Project Source
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
