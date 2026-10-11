# Bootstrap Sidebar Navigation Menu
All course files for the tutorial series on @chandraja2010

## #0 Important Note

## #1
[Video link](https://www.youtube.com/watch?v=oudzwpEXWPI)


- To run php code, you need to run it on a local server like XAMPP or WAMP. You can access the PHP file using the following link in your browser:
[Php link](https://localhost/git-2026-php/F-FrontEndFunn/bootstrap-v3-sidebar-main/index.php/)

-----------------------------------------
- create crud users multy page system 
- backend with php and mysql database
- front end with bootstrap 5 html css js
- login/register user system with session and cookies 
- header and footer needed

Ran command: `Get-ChildItem -Force`
Viewed README-My.md:1-20
Ran command: `php -v; Get-Command mysql -ErrorAction SilentlyContinue`

I will check the environment for PHP and MySQL availability.

Checked task Check PHP and MySQL
Ran command: `Test-Path "C:\xampp\mysql\bin\mysql.exe"; php -r "try { \$pdo = new PDO('mysql:host=localhost', 'root', ''); echo 'Connected to MySQL successfully'; } catch (PDOException \$e) { echo 'Connection failed: ' . \$e->getMessage(); }"`
Ran command: `php -r '$p = new PDO("mysql:host=localhost", "root", ""); echo "MySQL Connected!";'`
Ran command: `C:\xampp\mysql\bin\mysql.exe -u root -e "SHOW DATABASES;"`
Ran command: `New-Item -ItemType Directory -Force -Path "config", "includes", "assets\css", "assets\js", "assets\uploads\avatars"`
Ran command: `php -r "echo password_hash('admin123', PASSWORD_DEFAULT) . PHP_EOL . password_hash('password123', PASSWORD_DEFAULT);"`
Created database.sql
Ran command: `C:\xampp\mysql\bin\mysql.exe -u root < database.sql`
Ran command: `Get-Content database.sql | C:\xampp\mysql\bin\mysql.exe -u root`
Ran command: `C:\xampp\mysql\bin\mysql.exe -u root crud_users_db -e "SELECT id, first_name, last_name, email, role, status FROM users;"`
Created config.php
Created db.php
Created helpers.php
Created flash.php
Created csrf.php
Created auth.php
Created style.css
Created main.js
Created header.php
Created footer.php
Created setup.php
Created index.php
Created login.php
Created register.php
Created logout.php
Created users.php
Created user-create.php
Created user-view.php
Created user-edit.php
Created user-delete.php
Created profile.php
Ran command: `Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }`
Ran command: `php -r "require 'config/db.php'; \$db = get_db(); \$users = \$db->query('SELECT count(*) FROM users')->fetchColumn(); echo 'User count: ' . \$users;"`
Created test_app.php
Ran command: `php "C:\Users\ranji\.gemini\antigravity\brain\1290e0da-f380-4873-ab3b-dbbc59aa607b\scratch\test_app.php"`
Created test_debug.php
Ran command: `php "C:\Users\ranji\.gemini\antigravity\brain\1290e0da-f380-4873-ab3b-dbbc59aa607b\scratch\test_debug.php"`
Ran command: `curl.exe -i http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/index.php`
Ran command: `curl.exe -s -o NUL -w "%{http_code}\n" http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/login.php; curl.exe -s -o NUL -w "%{http_code}\n" http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/register.php; curl.exe -s -o NUL -w "%{http_code}\n" http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/users.php; curl.exe -s -o NUL -w "%{http_code}\n" http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/user-view.php?id=1; curl.exe -s -o NUL -w "%{http_code}\n" http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/setup.php`
Created test_e2e.php
Ran command: `php "C:\Users\ranji\.gemini\antigravity\brain\1290e0da-f380-4873-ab3b-dbbc59aa607b\scratch\test_e2e.php"`
Ran command: `C:\xampp\mysql\bin\mysql.exe -u root crud_users_db -e "SELECT id, first_name, last_name, email, role FROM users WHERE first_name = 'Alice';"`
Created test_delete.php
Ran command: `php "C:\Users\ranji\.gemini\antigravity\brain\1290e0da-f380-4873-ab3b-dbbc59aa607b\scratch\test_delete.php"`
Ran command: `C:\xampp\mysql\bin\mysql.exe -u root crud_users_db -e "SELECT id, first_name, last_name, email FROM users;"`
Created test_register.php
Ran command: `php "C:\Users\ranji\.gemini\antigravity\brain\1290e0da-f380-4873-ab3b-dbbc59aa607b\scratch\test_register.php"`
Ran command: `C:\xampp\mysql\bin\mysql.exe -u root crud_users_db -e "DELETE FROM users WHERE first_name = 'Charlie';"`
Created README.md
Ran command: `git status`
Ran command: `Get-ChildItem -Force`

A multi-page **User Management & Authentication System (CRUD)** has been created.

### 🌐 Access URL
If your XAMPP Apache and MySQL services are running, you can access the application in your browser at:
👉 **[http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/](http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/)**

---

### 🔑 Pre-seeded Login Credentials

| Role | Email | Password | Features |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@example.com` | `admin123` | Full access: View, Add, Edit, Delete users, Change user roles & status |
| **Standard User** | `john@example.com` | `password123` | View directory, Add users, Edit own profile |
| **Standard User** | `jane@example.com` | `password123` | View directory, Add users, Edit own profile |

> **Tip:** The [login page](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/login.php) includes 1-click **"Quick Demo Auto-Fill"** buttons for both Admin and User test accounts.

---

### 📂 Architecture & Files Overview

```text
01-crud_users/
├── assets/
│   ├── css/
│   │   └── style.css            # Custom responsive styles, badges & animations
│   ├── js/
│   │   └── main.js              # Password visibility toggle, live preview, delete modal
│   └── uploads/avatars/         # Uploaded user profile pictures
├── config/
│   ├── config.php               # App configuration, dynamic BASE_URL detection & sessions
│   └── db.php                   # Secure PDO MySQL connection handler
├── includes/
│   ├── auth.php                 # Session & Cookie Remember-Me authentication handler
│   ├── csrf.php                 # CSRF token generator & validator
│   ├── flash.php                # Bootstrap alert flash message system
│   ├── helpers.php              # XSS sanitization, formatters, avatar generator
│   ├── header.php               # Reusable header with responsive Bootstrap 5 navbar
│   └── footer.php               # Reusable footer with copyright & JS script includes
├── database.sql                 # MySQL schema with users & user_tokens tables + seed data
├── index.php                    # Dashboard / Home page with statistics & quick actions
├── login.php                    # User login with "Remember Me" cookie checkbox
├── register.php                 # Self-registration with automatic login
├── logout.php                   # Secure logout handler (clears session & cookie)
├── profile.php                  # User settings (edit profile, change password)
├── setup.php                    # 1-click database installer & reset tool
├── users.php                    # CRUD Read: Search, filter by role/status, pagination
├── user-create.php              # CRUD Create: Add user with avatar upload & validation
├── user-view.php                # CRUD Read Details: User profile overview
├── user-edit.php                # CRUD Update: Edit user details, status, password & avatar
├── user-delete.php              # CRUD Delete: Protected POST action with CSRF
└── README.md                    # Documentation & setup instructions
```

---

### 🛠️ Key Capabilities Implemented

1. **Full User CRUD**:
   - **Create** ([`user-create.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/user-create.php)): Add users with first name, last name, unique email, phone, gender, role (admin/user), status (active/inactive), bio, and profile picture upload (with live preview).
   - **Read** ([`users.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/users.php)): Users directory with real-time search (by name, email, phone), filters by role and status, and paginated table.
   - **View** ([`user-view.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/user-view.php)): Detailed user profile card with joined date and update timestamps.
   - **Update** ([`user-edit.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/user-edit.php)): Edit account details, avatar photo, role/status permissions, and optional password change.
   - **Delete** ([`user-delete.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/user-delete.php)): Secure deletion through POST + CSRF token confirmation modal. Prevents logged-in users from deleting their own active account.

2. **Authentication with Session & Cookies**:
   - **Session Authentication**: Managed via PHP sessions with secure cookies (`HttpOnly`, `SameSite=Lax`).
   - **"Remember Me" Cookie**: Built using the cryptographic standard **Selector + Hashed Validator** stored in the database (`user_tokens` table) for 30-day persistent login without storing plain credentials or predictable IDs.
   - **Secure Password Hashing**: Passwords stored using `password_hash()` (Bcrypt).
   - **Role-Based Access Control**: Prevents unauthorized modifications and limits administrative actions.

3. **Front-End Design**:
   - Built on **Bootstrap 5.3** and **Bootstrap Icons**.
   - Modular **Header** ([`includes/header.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/includes/header.php)) and **Footer** ([`includes/footer.php`](file:///c:/xampp/htdocs/git-2026-php/G-Ai-Antigravity/01-crud_users/includes/footer.php)).
   - Password reveal/hide toggle, live file preview, Bootstrap form validation (`needs-validation`), and animated dismissible flash alerts.