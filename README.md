# DevPortfolio — Dynamic Developer Portfolio Website Using PHP and MySQL

> **Course:** Advanced Web Development in PHP (Assignment 2)  
> **Target Audience:** College Faculty Evaluation & Academic Submission  
> **Student Persona:** B.Tech Computer Engineering Undergraduate  

---

## 1. Project Title & Overview

**DevPortfolio** is a production-ready, dynamic developer portfolio web application built with native **PHP 8**, **MySQL**, and **Bootstrap 5**. Designed specifically for a Computer Engineering undergraduate, the platform combines a modern aesthetic (dark navy and violet accents, glassmorphic navigation, accessible UI components) with an enterprise-grade backend architecture.

Unlike static portfolios, DevPortfolio is entirely database-driven:
- Project showcases are dynamically queried from MySQL tables using **PDO prepared statements**.
- Contact inquiries are validated on both client and server sides, inspected for spam bot traps, and persisted into the database.
- An administrative control panel permits privileged management of inquiries (mark read/unread, inspect details, delete) and showcase projects (create, edit, delete).

---

## 2. Problem Statement

Aspiring software engineering students require a central, credible platform to display their technical proficiencies, open-source repositories, and academic projects to recruiters and faculty. Static HTML websites lack interactive inquiry management, dynamic updates, and server-side validation. Conversely, complex JavaScript frameworks (React/Next.js) often obscure foundational web protocols and require heavy build tools.

**DevPortfolio** addresses this challenge by implementing a pure, accessible, and secure PHP/MySQL web architecture that adheres strictly to core web standards, demonstrates relational database modeling, and provides a clear separation of concerns.

---

## 3. Technology Stack

| Layer | Technologies & Specifications |
| :--- | :--- |
| **Frontend** | HTML5, CSS3, JavaScript (ES6+), Bootstrap 5.3.3 |
| **Styling & Theme** | Custom Dark Navy (`#0b1120`), Electric Cyan (`#38bdf8`), Deep Violet (`#8b5cf6`), Glassmorphism |
| **Icons & Typography** | Bootstrap Icons v1.11.3, Google Fonts (*Plus Jakarta Sans* & *JetBrains Mono*) |
| **Backend** | Native PHP 8+ (Strict Typing, OOP principles, Modular architecture) |
| **Database** | MySQL 5.7+ / 8.0+ or MariaDB 10.3+ |
| **Database Connectivity**| PHP Data Objects (PDO) with prepared statements and parameter binding |
| **Security Standards** | CSRF Tokens, Bcrypt Password Hashing (`cost 12`), Output Escaping (`htmlspecialchars`), Honeypot Bot Trap |
| **Local Environment** | XAMPP, WAMP, Docker, or native Apache + PHP 8 + MySQL |
| **Production Target** | SmarterASP.NET or any PHP/MySQL-compatible shared or VPS web host |

---

## 4. Key Features & Modules

### A. Public-Facing Portal
1. **Home (`index.php`)**
   - Dynamic Hero section with interactive terminal snippet, developer avatar, and status indicator.
   - Quick statistics counters (Years of coding, projects built, core technologies).
   - Dynamic Featured Projects retrieved from MySQL with fallback database health banners.
   - Professional calls-to-action to review projects and initiate contact.
2. **About Me (`about.php`)**
   - Detailed educational trajectory (B.Tech in Computer Engineering coursework, GPA).
   - Structured timeline of academic milestones.
   - Technical research interests (Backend Architecture, Database Optimization, Security).
   - Academic achievements and verifiable certifications.
3. **Skills & Expertise (`skills.php`)**
   - Categorized technology matrices:
     - **Languages:** Java, Python, C/C++, JavaScript, PHP 8+.
     - **Backend:** PHP OOP, PDO, Node.js & Express, Session Authentication.
     - **Frontend:** Bootstrap 5, HTML5 Semantics, CSS3 Glassmorphism, Client Validation.
     - **Databases:** MySQL (relational schemas, indexing, PDO), MongoDB.
     - **Tools:** Git, GitHub, VS Code, phpMyAdmin, XAMPP, SmarterASP.NET.
   - Animated visual progress indicators and skill level percentages.
4. **Projects Showcase (`projects.php`)**
   - Real-time MySQL querying via PDO prepared statements.
   - Initial sample projects:
     - *RideShare Hub* — Dynamic carpooling and route coordination platform.
     - *EstateNexus* — Modern real estate listing and tenant inquiry portal.
     - *LibroFlow* — Digital library cataloging and borrowing tracker.
     - *DevPortfolio CMS* — Dynamic portfolio and inquiry management platform.
   - Filterable tech badges, direct GitHub repository links, and live demonstration buttons.
5. **Contact & Inquiry (`contact.php` & `process_contact.php`)**
   - Real-time client-side Bootstrap 5 form validation with visual feedback.
   - Strict server-side validation (email format, lengths, sanitization).
   - Reusable CSRF token protection with crypto-secure random bytes.
   - Hidden honeypot field (`website`) trapping automated spam bots.
   - Insertion into MySQL `contacts` table using parameterized PDO queries.
   - Session flash notifications ensuring success messages appear **only** when insertion succeeds.

### B. Secure Administrator Panel (`/admin`)
1. **Authentication Gateway (`admin/login.php` & `admin/logout.php`)**
   - Form-based login verifying passwords hashed with `password_hash($pwd, PASSWORD_BCRYPT)`.
   - `password_verify()` verification preventing timing leaks.
   - Session fixation mitigation via `session_regenerate_id(true)` upon successful authentication.
   - Server-side guard function `require_admin_login()` protecting all administrative endpoints.
2. **Admin Dashboard (`admin/dashboard.php`)**
   - Key performance indicators: Total Inquiries, Unread Inquiries, Active Projects, Database Health.
   - Recent message stream with quick-action toggles.
3. **Inquiries Moderation (`admin/messages.php`)**
   - Responsive tabular data layout with sender name, email, subject, and timestamp.
   - Filter messages by status (`all`, `unread`, `read`) and full-text keyword search.
   - Modal inspection viewing full message bodies.
   - State-changing actions (`update_status.php` and `delete_message.php`) protected by CSRF tokens and confirmation dialogs.
4. **Project Management (`admin/projects.php`, `add_project.php`, `edit_project.php`, `delete_project.php`)**
   - Create, edit, and delete portfolio showcase projects directly through the UI.

---

## 5. Database Schema & Architecture

The database is named `devportfolio` and contains three normalized tables:

```
+--------------------------------------------------------------+
|                     DATABASE: devportfolio                  |
+--------------------------------------------------------------+
                               |
       +-----------------------+-----------------------+
       |                                               |
+--------------+                               +---------------+
|   contacts   |                               |   projects    |
+--------------+                               +---------------+
| id (PK, AI)  |                               | id (PK, AI)   |
| name         |                               | title         |
| email        |                               | description   |
| subject      |                               | technologies  |
| message      |                               | github_url    |
| status       |                               | demo_url      |
| created_at   |                               | image         |
+--------------+                               | created_at    |
                                               +---------------+
                                                       |
                                               +---------------+
                                               |    admins     |
                                               +---------------+
                                               | id (PK, AI)   |
                                               | username (UQ) |
                                               | password_hash |
                                               | created_at    |
                                               +---------------+
```

### Table 1: `contacts`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | `AUTO_INCREMENT, PRIMARY KEY` | Unique inquiry identifier |
| `name` | `VARCHAR(100)` | `NOT NULL` | Sender's full name |
| `email` | `VARCHAR(150)` | `NOT NULL` | Sender's validated email address |
| `subject` | `VARCHAR(200)` | `NOT NULL` | Inquired topic / subject line |
| `message` | `TEXT` | `NOT NULL` | Detailed message content |
| `status` | `ENUM('unread','read')` | `DEFAULT 'unread'` | Inquiry moderation status |
| `created_at` | `TIMESTAMP` | `DEFAULT CURRENT_TIMESTAMP` | Submission timestamp |

### Table 2: `projects`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | `AUTO_INCREMENT, PRIMARY KEY` | Unique project identifier |
| `title` | `VARCHAR(150)` | `NOT NULL` | Project headline |
| `description` | `TEXT` | `NOT NULL` | Architectural & functional description |
| `technologies` | `VARCHAR(255)` | `NOT NULL` | Comma-separated list of tools/languages |
| `github_url` | `VARCHAR(255)` | `NULLABLE` | Repository URL |
| `demo_url` | `VARCHAR(255)` | `NULLABLE` | Live deployment link |
| `image` | `VARCHAR(255)` | `NULLABLE` | Relative path to SVG/PNG graphic |
| `created_at` | `TIMESTAMP` | `DEFAULT CURRENT_TIMESTAMP` | Project timestamp |

### Table 3: `admins`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | `AUTO_INCREMENT, PRIMARY KEY` | Unique administrator identifier |
| `username` | `VARCHAR(50)` | `UNIQUE, NOT NULL` | Administrator username |
| `password_hash`| `VARCHAR(255)` | `NOT NULL` | Bcrypt password hash |
| `created_at` | `TIMESTAMP` | `DEFAULT CURRENT_TIMESTAMP` | Account creation timestamp |

---

## 6. Directory Structure

```
devportfolio/
├── index.php                 # Home page (Hero, quick stats, featured projects)
├── about.php                 # About page (Education, timeline, achievements)
├── skills.php                # Technical skills matrix with visual bars
├── projects.php              # Dynamic projects showcase from MySQL
├── contact.php               # Contact form with CSRF & client-side validation
├── process_contact.php       # Server-side validation & PDO MySQL insertion
├── setup_admin.php           # Local admin initialization utility (delete in prod)
├── database.sql              # Complete database schema and initial seed data
├── README.md                 # Complete project documentation & guide
├── config/
│   └── database.php          # Reusable PDO singleton connection & env config
├── includes/
│   ├── header.php            # HTML head, typography, navigation, flash alerts
│   ├── footer.php            # Footer, system specs, Bootstrap bundle
│   └── functions.php         # Security, CSRF, escaping, sessions, PDO queries
├── assets/
│   ├── css/
│   │   └── style.css         # Dark navy & violet theme, glassmorphism, responsive
│   ├── js/
│   │   └── script.js         # Scroll effects, form validation, admin modals
│   └── images/
│       ├── avatar.svg        # Modern vector avatar for developer profile
│       └── projects/         # High-resolution vector preview cards
│           ├── project-rideshare.svg
│           ├── project-estate.svg
│           ├── project-library.svg
│           └── project-devportfolio.svg
└── admin/
    ├── index.php             # Route dispatcher (redirects to dashboard or login)
    ├── login.php             # Secure admin login with password_verify & CSRF
    ├── logout.php            # Session destruction & cookie invalidation
    ├── dashboard.php         # Aggregated metrics, recent messages preview
    ├── messages.php          # Inquiries manager: filter, search, view modal, delete
    ├── update_status.php     # POST handler: mark message read/unread
    ├── delete_message.php    # POST handler: delete inquiry with CSRF check
    ├── projects.php          # Project showcase manager table
    ├── add_project.php       # Add new project form & PDO handler
    ├── edit_project.php      # Edit existing project form & PDO handler
    └── delete_project.php    # Delete project handler
```

---

## 7. Step-by-Step Installation & Local Setup

### Option 1: Using XAMPP / WAMP (Recommended for College Lab)

1. **Install XAMPP**
   Download and install XAMPP with PHP 8.1+ and MySQL from [apachefriends.org](https://www.apachefriends.org/).

2. **Clone / Copy Files to Web Root**
   Copy the `devportfolio` directory into the XAMPP web root:
   - **Windows:** `C:\xampp\htdocs\devportfolio\`
   - **Linux:** `/opt/lampp/htdocs/devportfolio/`
   - **macOS:** `/Applications/XAMPP/htdocs/devportfolio/`

3. **Start Apache & MySQL**
   Launch the **XAMPP Control Panel** and click **Start** for both **Apache** and **MySQL**.

4. **Import the Database via phpMyAdmin**
   - Open your browser and navigate to `http://localhost/phpmyadmin/`.
   - Click on the **Databases** tab, enter database name `devportfolio`, and click **Create**.
   - Select `devportfolio` from the sidebar, then click the **Import** tab.
   - Click **Choose File**, select `database.sql` from the project directory, and click **Import** (or **Go**).
   - Confirm that three tables (`admins`, `contacts`, `projects`) were successfully created.

5. **Configure Database Credentials (if needed)**
   Open `config/database.php` in VS Code. Default credentials match standard XAMPP defaults:
   ```php
   $dbHost = '127.0.0.1';
   $dbPort = 3306;
   $dbName = 'devportfolio';
   $dbUser = 'root';
   $dbPass = ''; // Default XAMPP has no password
   ```

6. **Launch and Test the Application**
   Open your browser and navigate to:
   `http://localhost/devportfolio/`

---

### Option 2: Using the PHP Built-In Web Server

If you have PHP 8+ and MySQL installed locally:

```bash
# 1. Import database schema into MySQL
mysql -u root -p devportfolio < database.sql

# 2. Start PHP server from the project directory
php -S 127.0.0.1:8000
```
Open `http://localhost:8000/` in your browser.

---

## 8. Default Administrator Credentials

For local college evaluation and testing, the initial seed provides:

- **Login URL:** `http://localhost/devportfolio/admin/login.php`
- **Username:** `admin`
- **Password:** `Admin@123`

*(Password is securely stored as a cost-12 Bcrypt hash in the `admins` table).*

To create or reset an administrator account with custom credentials locally, navigate to `http://localhost/devportfolio/setup_admin.php`.

> [!WARNING]
> Prior to deploying the website to a public remote server (e.g., SmarterASP.NET), delete `setup_admin.php` to prevent unauthorized credential modification.

---

## 9. Comprehensive Testing Checklist

Execute these verification steps to ensure full functionality:

- [x] **Public Pages:** Navigate to Home, About, Skills, Projects, and Contact. Verify navbar active state highlighting and smooth scrolling.
- [x] **Dynamic Projects Query:** Confirm that project cards on `index.php` and `projects.php` are fetched directly from the MySQL `projects` table.
- [x] **Client-Side Form Validation:** Go to `contact.php`, leave fields empty, and click Submit. Confirm that HTML5/Bootstrap validation prevents submission and highlights invalid fields.
- [x] **Server-Side Validation:** Submit invalid email formats or short message strings to confirm server-side validation messages appear via session flash alerts.
- [x] **Database Insertion:** Fill valid inquiry details and submit. Confirm that the success banner appears and the new record is present in MySQL `contacts` table via phpMyAdmin.
- [x] **SQL Injection Defense:** Attempt entering `' OR '1'='1` or `admin'--` in the contact form or login form. Confirm PDO prepared statements treat these strictly as literal string parameters.
- [x] **Spam Trap (Honeypot):** Verify that the hidden `website` input prevents automated spam bot submissions.
- [x] **Admin Authentication:** Navigate to `admin/login.php`. Attempt incorrect password to observe failure notice; enter `admin` / `Admin@123` to enter the dashboard.
- [x] **Session Security:** Try navigating directly to `admin/dashboard.php` in an incognito/private window. Verify that you are redirected to `admin/login.php`.
- [x] **Message Moderation:** Mark a message as "Read" and verify status changes from warning pill to success pill. Delete a message and confirm the deletion prompt and removal.
- [x] **Project Management:** Add a new project through `admin/add_project.php` and confirm it immediately appears on the public `projects.php` showcase!

---

## 10. Remote Deployment Guide (e.g. SmarterASP.NET / cPanel)

Follow these steps to deploy DevPortfolio to SmarterASP.NET or any remote PHP/MySQL host:

### Step 1: Provision MySQL Database on Remote Host
1. Log into your hosting control panel (e.g. SmarterASP.NET Control Center).
2. Go to **Databases** &rarr; **MySQL Database** &rarr; **Add Database**.
3. Note your remote connection parameters:
   - Remote Hostname (e.g., `mysqlXXXX.smarterasp.net`)
   - Database Name (e.g., `db_xxxx_devportfolio`)
   - Database Username (e.g., `db_xxxx_user`)
   - Database Password

### Step 2: Import Database Schema
1. Open the remote phpMyAdmin instance provided by your web host.
2. Select your newly created remote database.
3. Open the **Import** tab, upload `database.sql`, and execute the import.
4. Verify that tables `contacts`, `projects`, and `admins` have populated.

### Step 3: Configure Database Credentials in PHP
Edit `config/database.php` to use the remote credentials:
```php
$dbHost = 'mysqlXXXX.smarterasp.net'; // Remote host
$dbPort = 3306;
$dbName = 'db_xxxx_devportfolio';     // Remote database name
$dbUser = 'db_xxxx_user';             // Remote username
$dbPass = 'YourStrongRemotePassword'; // Remote password
```
*(Alternatively, set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` as hosting environment variables).*

### Step 4: Upload Application Files via FTP
1. Connect via FTP/SFTP (e.g. using FileZilla) using your hosting FTP credentials.
2. Navigate to the remote web root (usually `wwwroot/` or `public_html/`).
3. Upload all project files and directories (`assets/`, `config/`, `includes/`, `admin/`, `*.php`).
4. **Important:** Delete `setup_admin.php` from the remote server after verifying the admin account.

### Step 5: Verification on Public URL
1. Access the public domain URL (e.g., `http://yourdomain.smarterasp.net/`).
2. Verify that homepage projects load dynamically.
3. Submit a test inquiry via `contact.php`.
4. Log into `admin/login.php` on the remote server and verify the inquiry was recorded.

---

## 11. Faculty Demonstration Script (Viva / Presentation Guide)

When presenting this project to course instructors:

1. **Step 1 — Architecture Overview (1 min):**
   - Explain the technology stack: PHP 8+, MySQL PDO, Bootstrap 5.
   - Emphasize that there is no React or Node.js backend; it is pure, high-performance PHP.

2. **Step 2 — Dynamic Projects Showcase (1 min):**
   - Open `projects.php` and show the project cards.
   - Open phpMyAdmin alongside, edit a project title in the `projects` table, refresh the webpage, and show the faculty that the changes reflect immediately.

3. **Step 3 — Contact Submission & Database Verification (2 mins):**
   - Navigate to `contact.php`.
   - Submit a test inquiry: *Name: Professor Sharma*, *Email: faculty@college.edu*, *Subject: Evaluation Inquiry*, *Message: Demonstrating dynamic PDO insertion.*
   - Show the success flash message.
   - Switch to phpMyAdmin, query `SELECT * FROM contacts ORDER BY id DESC LIMIT 1;`, and demonstrate that the message was securely stored.

4. **Step 4 — Secure Admin Dashboard & Moderation (2 mins):**
   - Navigate to `admin/login.php`.
   - Sign in using `admin` / `Admin@123`.
   - Point out the unread badge incrementing on the dashboard.
   - Click **Messages**, locate the newly submitted message from Professor Sharma, and click the **View** modal.
   - Click the checkmark to mark it as **Read**, showing the badge update.
   - Show `admin/projects.php` where projects can be created or updated directly without opening phpMyAdmin.
   - Sign out, verifying that the session is destroyed and unauthorized back-button navigation is blocked.

---

## 12. Conclusion & Future Enhancements

DevPortfolio successfully satisfies all requirements of Assignment 2 for Advanced Web Development in PHP. The project demonstrates:
- Clean modular design with reusable PHP includes.
- Secure data modeling and PDO prepared statements with strict parameter binding.
- Robust user input validation and sanitization.
- Scalable session authorization and password cryptography.

### Potential Future Enhancements:
- Direct email notifications via SMTP (PHPMailer) upon new inquiry submission.
- Multi-factor authentication (TOTP) for administrative sign-in.
- File upload support for project screenshots directly through the admin panel.
- RESTful JSON API endpoints for mobile client integration.

---

## 13. Live Deployment Status & Public Access

The website has been deployed, connected to a live MySQL database, and verified over an active public HTTPS endpoint:

- **Public Live Website:** [https://fuzzy-mini-waterproof-tent.trycloudflare.com](https://fuzzy-mini-waterproof-tent.trycloudflare.com)
- **Administrative Portal:** [https://fuzzy-mini-waterproof-tent.trycloudflare.com/admin/login.php](https://fuzzy-mini-waterproof-tent.trycloudflare.com/admin/login.php)
- **Default Admin Credentials:**
  - **Username:** `admin`
  - **Password:** `Admin@123`
- **Ready-to-Deploy ZIP Archive:** `devportfolio-deploy.zip` (Pre-packaged 64KB archive for 1-click FTP upload to SmarterASP.NET or cPanel).

### Verification Evidence:
1. Contact submission sent over the public HTTPS tunnel was validated and inserted into the MySQL `contacts` table (Record ID `#1`).
2. Administrative authentication via `password_verify()` was executed successfully over the public endpoint.
3. Message moderation action toggled status to `read` in the live database.

