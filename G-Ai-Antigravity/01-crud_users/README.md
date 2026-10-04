# UserHub - Multi-Page CRUD & Authentication System

A complete, production-ready **User Management & Authentication System** built with **PHP 8**, **MySQL**, and **Bootstrap 5**.

---

## 🌟 Key Features

1. **Full CRUD Operations**:
   - **Create**: Add new user accounts with validation, role selection, and avatar photo uploads.
   - **Read**: Browse the users directory with search by name/email/phone, filter by role/status, and pagination.
   - **View Details**: Clean user profile overview with timestamps, contact info, and bio.
   - **Update**: Edit user profiles, roles, account status, optional password change, and profile pictures.
   - **Delete**: Secure deletion with CSRF token verification and confirmation modal (prevents self-deletion).

2. **Authentication System (Session & Cookies)**:
   - **Login**: Secure credential verification (`password_verify` with Bcrypt).
   - **Registration**: Self-registration with automatic login upon success.
   - **Remember Me (Cookie)**: Cryptographically secure token-based remember-me login using RFC-standard Selector + Validator pairs stored in `user_tokens`.
   - **Session Security**: Session fixation prevention (`session_regenerate_id`), `HttpOnly` and `SameSite=Lax` cookies.
   - **Access Control**: Role-based access control (Admin vs Standard User).

3. **Front-End & UI/UX**:
   - Built on **Bootstrap 5.3** and **Bootstrap Icons**.
   - Custom modern styles (`assets/css/style.css`) and responsive layout.
   - Reusable **Header** (`includes/header.php`) and **Footer** (`includes/footer.php`) templates.
   - Live client-side form validation (`needs-validation`).
   - Interactive password visibility toggle (eye icon).
   - Live avatar image preview before upload.
   - Auto-dismissing flash notification alerts.

---

## 📁 Project Structure

```text
01-crud_users/
├── assets/
│   ├── css/
│   │   └── style.css            # Custom CSS styles, badge colors & typography
│   ├── js/
│   │   └── main.js              # Password toggle, live preview, delete modal
│   └── uploads/
│       └── avatars/             # Directory for uploaded user profile pictures
├── config/
│   ├── config.php               # App settings, session config, dynamic BASE_URL
│   └── db.php                   # PDO MySQL connection handler
├── includes/
│   ├── auth.php                 # Authentication, remember-me cookies & permissions
│   ├── csrf.php                 # CSRF token generator & validator
│   ├── flash.php                # Flash message notification system
│   ├── helpers.php              # XSS escaping, date/time formatting, avatars
│   ├── header.php               # Reusable header with navbar & flash alerts
│   └── footer.php               # Reusable footer & script includes
├── database.sql                 # MySQL database schema and seed data
├── index.php                    # Dashboard / Home page with statistics & quick links
├── login.php                    # Login page with "Remember Me" cookie checkbox
├── register.php                 # Registration page
├── logout.php                   # Secure logout script
├── profile.php                  # User account settings & password change
├── setup.php                    # One-click web installer & database reset tool
├── users.php                    # Users directory (Search, Filter, Pagination, Delete)
├── user-create.php              # Create user form
├── user-view.php                # View single user profile
├── user-edit.php                # Edit user form
├── user-delete.php              # Delete user action (POST + CSRF)
└── README.md
```

---

## 🚀 Getting Started

### 1. Requirements
- Local web server (e.g., **XAMPP**, WAMP, or LAMP)
- **PHP 8.0+** with PDO MySQL enabled
- **MySQL 5.7+** or **MariaDB 10.4+**

### 2. Access the Application
Make sure Apache and MySQL are running in your XAMPP Control Panel.
Open your browser and navigate to:
```text
http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/
```

### 3. Default Login Credentials

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@example.com` | `admin123` |
| **User** | `john@example.com` | `password123` |
| **User** | `jane@example.com` | `password123` |
| **User** | `robert@example.com` | `password123` |

*(Quick Auto-fill buttons are also available directly on the login page for testing convenience).*

### 4. Database Setup & Reset Tool
If you ever want to re-seed or reset the database:
- Navigate to `http://localhost/git-2026-php/G-Ai-Antigravity/01-crud_users/setup.php`
- Click **"Run Setup / Re-seed Database"**

---

## 🔒 Security Features

- **SQL Injection Prevention**: All queries use PDO prepared statements with bound parameters.
- **XSS Prevention**: User inputs are escaped using `e()` (`htmlspecialchars`) before output.
- **CSRF Protection**: All state-changing forms (create, edit, delete, password update) require CSRF tokens.
- **Password Hashing**: Passwords stored using `password_hash()` with `PASSWORD_DEFAULT` (Bcrypt).
- **Secure Remember Me Cookies**: Uses cryptographic selector & hashed validator design (prevents cookie spoofing and timing attacks).
- **Self-Protection**: Users cannot delete their own active account while signed in.
