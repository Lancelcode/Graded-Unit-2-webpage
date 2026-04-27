[README (1).md](https://github.com/user-attachments/files/27137946/README.1.md)<div align="center">

<img src="assets/images/logo.png" alt="GreenScore Logo" width="120" height="120" />

# 🌱 GreenScore

**Sustainability Tracking & Certification Web Application**

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-11.5-366488?style=for-the-badge&logo=php&logoColor=white)](https://phpunit.de/)
[![Tests](https://img.shields.io/badge/Tests-10%20Passing-2ea44f?style=for-the-badge)](#-testing)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

*Empowering organisations to measure, track, and improve their environmental impact — with structured scoring, certifications, and community engagement.*

[🚀 Getting Started](#%EF%B8%8F-installation) · [📖 Features](#-key-features) · [🧪 Tests](#-testing) · [🛡️ Security](#%EF%B8%8F-security) · [🗄️ Database](#%EF%B8%8F-database-schema)

</div>

---

## 📌 About the Project

**GreenScore** is a full-stack sustainability platform built with PHP and MySQL. Organisations complete a structured environmental assessment across **10 categories**, earn progressive **badge levels**, and receive official downloadable **certificates** (Gold, Silver, Bronze, or Participation) based on their cumulative performance.

The platform also includes a community tip board, a user feedback system, a secure payment contribution flow, and a comprehensive admin dashboard — all built with a strong emphasis on security best practices.

> 🎓 Developed as part of the **Graded Unit 2 Software Development** assessment at **Edinburgh College** — Academic Year 2024/2025.

---

## ✨ Key Features

### 🔐 Authentication & Access Control
- Secure user registration, login, logout, and password reset
- Role-based session management with HTTP 403 enforcement on admin routes
- CSRF token protection on all state-changing forms

### 🧮 Green Calculator
- Sustainability assessment across **10 categories**
- Each category rated **RED / AMBER / GREEN**
- Produces a cumulative score out of **100**
- Submission history tracked per user

### 🏅 Badge & Certificate System
- **14 progressive badge levels** unlocked by cumulative green answers
- Auto-generated award certificates at four tiers: **Gold, Silver, Bronze, Participation**
- Certificates are **printable** and **PDF-exportable**

### 💳 Buy Points / Contribute
- Users can close their score gap through a contribution page
- Simulated payment flow with declined-card handling
- Supports certificate tier upgrades

### 📝 Community Board
- Paginated tip-sharing board
- Full **CRUD** (create, read, update, delete) per user
- Personal and community-scoped views

### 📬 Feedback System
- Users submit feedback messages
- Admin response panel with visibility control
- Public / private feedback toggle

### 👥 Admin Dashboard
- Full user management: roles, statuses, deletion
- Feedback moderation and response
- Public submission review panel

### 📊 My Impact Dashboard
- Personal submission history and score timeline
- Total green answers, donations, and current badge level at a glance

---

## 🧩 Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8.2 |
| **Database** | MySQL / MariaDB (via XAMPP) |
| **Frontend** | HTML5, CSS3, JavaScript |
| **UI Framework** | Bootstrap 5.3 |
| **Icons** | Font Awesome 6.4 |
| **Animations** | Animate.css |
| **Testing** | PHPUnit 11.5 |
| **Dev Environment** | XAMPP, phpMyAdmin, PHPStorm |

---

## 📁 Project Structure

```
/
├── index.php                        ← Home page
├── style.css                        ← Global stylesheet
│
├── includes/                        ← Shared PHP components
│   ├── init.php                     ← Session bootstrap & ROOT_PATH constant
│   ├── connect_db.php               ← Database connection
│   ├── nav.php                      ← Navigation bar
│   ├── footer.php                   ← Footer
│   ├── head.php                     ← Common <head> meta and stylesheet links
│   ├── login_tools.php              ← Authentication helpers
│   ├── login_action.php             ← Login POST handler
│   └── modals.php                   ← Reusable modal components
│
├── pages/
│   ├── auth/                        ← login, logout, register, forgot_password
│   ├── admin/                       ← admin_feedback, manage_users, edit_user, public_feedback
│   ├── calculator/                  ← green_calculator, certificate_history, certificate_preview, buy_points
│   ├── community/                   ← community, post_tip, edit_tip, delete_tip, clear_tips
│   ├── user/                        ← user_account, my_impact, view_cards, manage_credit_card
│   └── info/                        ← about, partner, privacy, terms, green_resources, feedback, copyright
│
├── assets/
│   ├── images/                      ← Photos, badge illustrations, partner logos
│   └── documents/                   ← Downloadable PDF guides
│
├── database/
│   └── gradedunit.sql               ← Full database schema and seed data
│
└── tests/                           ← PHPUnit test suite
    ├── LoginTest.php
    ├── GreenCalculatorTest.php
    ├── CommunityTipsTest.php
    ├── PaymentTest.php
    └── fake_login_tools.php         ← Session simulation helper for protected route testing
```

---

## ⚙️ Installation

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)
- PHP 8.2+
- A modern web browser

### 1. Clone the repository

```bash
git clone https://github.com/Lancelcode/Graded-Unit-2-webpage.git
```

### 2. Set up XAMPP

- Start **Apache** and **MySQL** from the XAMPP control panel
- Copy the project folder into your `htdocs` directory:

```
C:/xampp/htdocs/Graded-Unit-2-webpage/
```

### 3. Set up the database

- Open **phpMyAdmin** at [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Create a new database named `gradedunit`
- Import `database/gradedunit.sql`
- Update credentials in `includes/connect_db.php` if needed (default: `root` / no password)

### 4. Launch the application

```
http://localhost/Graded-Unit-2-webpage/
```

---

## 🧪 Testing

GreenScore uses both **automated** and **manual** testing strategies.

### ✅ Automated — PHPUnit

**10 tests · 11 assertions · All passing**

| Test Class | Coverage |
|---|---|
| `LoginTest` | Valid login flow, CSRF token rejection |
| `GreenCalculatorTest` | All-green scoring, mixed selections, all-red scoring |
| `CommunityTipsTest` | Create, update and delete tip operations |
| `PaymentTest` | Successful payment simulation, declined payment handling |

> A `fake_login_tools.php` helper simulates authenticated session state for testing protected routes without a live database connection.

Run the full test suite from the project root:

```bash
php phpunit.phar --testdox
```

### 🖥️ Manual

All user-facing flows were tested end-to-end, including:
- Registration, login, and password reset
- Calculator submission and certificate generation
- Community board interactions (create, edit, delete)
- Feedback submission and admin moderation
- Full admin panel (user management, feedback responses)
- Form validation, navigation, and responsive layout across multiple screen sizes

---

## 🛡️ Security

Security was a core design priority throughout development. The following measures are implemented:

| Measure | Implementation |
|---|---|
| **Password Hashing** | `password_hash()` with `PASSWORD_DEFAULT` (bcrypt) |
| **SQL Injection Prevention** | MySQLi prepared statements with bound parameters throughout |
| **CSRF Protection** | Per-session tokens validated on every state-changing form |
| **Role-Based Access Control** | Admin routes return HTTP 403 if accessed without correct session role |
| **Output Sanitisation** | All user-supplied data escaped with `htmlspecialchars()` before rendering |
| **Authentication Enforcement** | Protected pages redirect to login if no valid session is present |

---

## 🗄️ Database Schema

Six relational tables power the application:

| Table | Purpose |
|---|---|
| `new_users` | User accounts, roles, statuses, and company details |
| `green_calculator_results` | Assessment submissions, scores, award levels, and donation records |
| `community_tips` | User-submitted sustainability tips |
| `feedback` | User feedback messages and admin responses |
| `credit_cards` | Saved payment card details per user |
| `success_stories` | Reserved for future community success story submissions |

The full schema with seed data is available at [`database/gradedunit.sql`](database/gradedunit.sql).

---

## 🗺️ Roadmap

Potential future enhancements:

- [ ] Success stories community section (table already scaffolded)
- [ ] Email notifications for admin responses
- [ ] Organisation comparison leaderboard
- [ ] REST API for third-party integrations
- [ ] OAuth / SSO login support
- [ ] Dark mode UI

---

## 👤 Author

**Djiby Sow Rebollo**

[![GitHub](https://img.shields.io/badge/GitHub-@Lancelcode-181717?style=for-the-badge&logo=github)](https://github.com/Lancelcode)

Edinburgh College — Software Development
Graded Unit 2 — Academic Year 2024/2025

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<div align="center">

*Built with 💚 to make sustainability measurable.*

</div>
