
# 🌱 GreenScore — Sustainability Tracking & Certification Web App

<p align="center">
  <img src="assets/favicon.svg" alt="GreenScore Logo" width="80">
</p>

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-11.5-6c757d?logo=php)
![Tests](https://img.shields.io/badge/Tests-42%20passing-198754)

> Empowering organisations to measure, track, and showcase their environmental impact — with structured scoring, digital certificates, and community engagement.

Developed as part of the **Graded Unit 2 Software Development** assessment at **Edinburgh College** (2024/2025).

---

## 🌍 What It Does

GreenScore lets businesses and organisations complete a **10-category sustainability assessment**, earning a score out of 100. Based on their score, they receive an award-level certificate — Gold, Silver, Bronze, or Participation — and unlock one of **14 progressive badge levels** tracked across all submissions. Organisations can contribute to close any score gap and upgrade their certificate to Gold.

---

## ✨ Key Features

| Feature | Description |
|---|---|
| 🔐 Authentication | Registration, login, logout, password reset, session-based role management |
| 🧮 Green Calculator | 10-category assessment rated RED / AMBER / GREEN — score out of 100 |
| 🏅 14 Badge Levels | Progressive badges from Green Starter to Champion of Sustainability |
| 📄 Certificates | Gold / Silver / Bronze / Participation — with real submission date, company name, certificate ref number, and print-to-PDF |
| 📜 Certificate History | Responsive card layout — colour-coded by award, score bar, filter by level, sort by date |
| 💸 Buy Points | Users can contribute to close their score gap and upgrade to Gold |
| 📊 My Impact | Personal dashboard — badge level, green answer count, contribution total, progress bar |
| 📝 Community Board | Paginated tip board with keyword search, character counter, create/edit/delete per user |
| 📬 Feedback System | User submission with admin response panel and public visibility toggle |
| 👥 Admin Dashboard | Role/status management, user editing, feedback moderation |
| 🌙 Dark Mode | Full dark mode with `localStorage` persistence across page navigation |
| 🔔 Toast Notifications | Dismissible floating toasts replace all inline alert divs sitewide |

---

## 🛡️ Security

| Protection | Implementation |
|---|---|
| Password hashing | `password_hash()` with bcrypt — auto-salted, unique per user |
| SQL injection | Prepared statements with bound parameters on every query across all 44 PHP files |
| CSRF protection | Token generated once per session in `init.php`, validated on every state-changing form |
| Session fixation | `session_regenerate_id(true)` immediately on login; periodic regeneration every 15 min |
| Idle timeout | Session destroyed after 30 minutes of inactivity |
| Login rate limiting | IP blocked after 5 failed attempts in 15 minutes — recorded in `login_attempts` table |
| Password complexity | Min 8 chars, uppercase + lowercase + number required, common passwords rejected |
| Cookie flags | `HttpOnly`, `SameSite=Strict` on session cookie |
| Security headers | `X-Frame-Options: DENY`, `X-Content-Type-Options`, `Referrer-Policy`, `X-XSS-Protection`, `Permissions-Policy` |
| Role-based access | Admin routes return HTTP 403 if accessed without the correct session role |
| Output sanitisation | All user data escaped with `htmlspecialchars()` before rendering |
| `.htaccess` | Blocks direct GET to `includes/`, blocks `.sql/.env/.log` files, custom 403/404 pages |

---

## 🧩 Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2 |
| Database | MySQL / MariaDB via XAMPP |
| Frontend | HTML5, CSS3, JavaScript (ES6) |
| UI Framework | Bootstrap 5.3 |
| Icons | Font Awesome 6.4 |
| Testing | PHPUnit 11.5 (via phar) |
| Dev Environment | XAMPP, phpMyAdmin, PHPStorm |

---

## 🗄️ Database

Six tables with foreign key constraints and cascading deletes:

| Table | Purpose |
|---|---|
| `new_users` | Accounts, roles (`admin`/`user`), statuses, company details |
| `green_calculator_results` | Scores, award levels, badge data, donation records |
| `community_tips` | User-submitted tips with ownership |
| `feedback` | Messages, admin responses, public visibility flag |
| `credit_cards` | Saved card details per user |
| `login_attempts` | IP-based rate limiting records |

---

## 📁 Project Structure

```
/
├── index.php                    ← Home page
├── style.css                    ← Global stylesheet (CSS variables, dark mode, responsive)
├── .htaccess                    ← Security rules, error routing
├── 403.php / 404.php            ← Custom error pages
├── assets/
│   ├── favicon.svg
│   ├── images/                  ← Backgrounds, 14 badge illustrations, partner logos
│   └── documents/               ← Downloadable PDF guides
├── includes/
│   ├── init.php                 ← Session bootstrap, security headers, CSRF, BASE_URL
│   ├── connect_db.php           ← Database connection
│   ├── nav.php                  ← Navigation (active highlighting, dark mode toggle)
│   ├── footer.php               ← Toast system, back-to-top, dark mode JS
│   ├── head.php                 ← Favicon, theme-color, stylesheet links
│   ├── helpers.php              ← isActive(), renderEditButton(), renderRoleStatusForms()
│   ├── login_tools.php          ← validate() with password_verify
│   ├── login_action.php         ← Login POST handler with rate limiting
│   └── modals.php               ← Register/login modal components
├── pages/
│   ├── auth/                    ← login, logout, register, register_action, forgot_password
│   ├── admin/                   ← admin_feedback, manage_users, edit_user, public_feedback, process_feedback_admin
│   ├── calculator/              ← green_calculator, certificate_history, certificate_preview, buy_points
│   ├── community/               ← community, post_tip, edit_tip, delete_tip, clear_tips
│   ├── user/                    ← user_account, my_impact, view_cards, manage_credit_card
│   └── info/                    ← about, partner, privacy, terms, green_resources, feedback, greenscore_copyright
├── database/
│   └── gradedunit.sql           ← Full schema with seed data
└── tests/
    ├── LoginTest.php
    ├── GreenCalculatorTest.php
    ├── CommunityTipsTest.php
    ├── PaymentTest.php
    └── fake_login_tools.php
```

---

## 🧪 Testing

**42 tests — 63 assertions — all passing**

| Test Class | What it covers |
|---|---|
| `LoginTest` | `password_verify()` path, correct session keys, wrong password, unknown email, admin role |
| `GreenCalculatorTest` | All 4 award thresholds by boundary value, all-green/amber/red scoring, shortfall and cost calculation |
| `CommunityTipsTest` | Message validation, trimming, HTML escaping, auth guard, ownership check, pagination |
| `PaymentTest` | Cost from shortfall, clamping (min/max), formatting, float conversion, post-payment state |

```bash
php phpunit.phar --testdox --colors=never
```

---

## ⚙️ Installation

### 1. Clone

```bash
git clone https://github.com/Lancelcode/Graded-Unit-2-webpage.git
```

### 2. XAMPP Setup

- Start **Apache** and **MySQL** in the XAMPP control panel
- Place the project folder in `C:/xampp/htdocs/`

### 3. Database

- Open **phpMyAdmin** → create database `gradedunit`
- Import `database/gradedunit.sql`
- Default credentials in `includes/connect_db.php`: host `localhost`, user `root`, password empty

### 4. Open

```
http://localhost/Graded-Unit-2-webpage/
```

### Demo credentials

| Role | Email | Password |
|---|---|---|
| Admin | `admin@greenscore.com` | *(set in your DB)* |
| User | `joe@joe.com` | *(set in your DB)* |

---

## 👤 Author

**Djiby Sow Rebollo** ([@Lancelcode](https://github.com/Lancelcode))  
Edinburgh College — Software Development  
Graded Unit 2 — Academic Year 2024/2025
