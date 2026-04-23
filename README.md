# 🌱 GreenScore — Sustainability Tracking Web App

GreenScore is a full-stack web application that enables organisations to measure, track, and improve their environmental impact through a structured scoring and certification system. Users complete a sustainability assessment across ten key categories, earn badge levels based on their cumulative performance, and receive downloadable certificates reflecting their achievement level. The platform additionally supports community engagement, user feedback, and an administrative management panel.

Developed as part of the **Graded Unit 2 Software Development** assessment at **Edinburgh College**.

---

## 🌍 Key Features

| Feature | Description |
|---|---|
| 🔐 Authentication | User registration, login, logout and password reset with role-based session management |
| 🧮 Green Calculator | Sustainability assessment across 10 categories rated RED / AMBER / GREEN, producing a score out of 100 |
| 🏅 Badge System | 14 progressive badge levels unlocked by cumulative green answers across all submissions |
| 📄 Certificates | Auto-generated award certificates — Gold, Silver, Bronze, or Participation — with print and PDF export |
| 💳 Buy Points | Contribution page allowing users to close their score gap and upgrade their certificate level |
| 📝 Community Board | Paginated tip-sharing board with full create, read, update and delete functionality per user |
| 📬 Feedback System | User feedback submission with admin response panel and public visibility control |
| 👥 Admin Dashboard | User management (roles, statuses, deletion), feedback moderation, and public submission review |
| 📊 My Impact | Personal dashboard showing submission history, total green answers, donations, and current badge level |

---

## 🧩 Technologies

| Layer | Technology |
|---|---|
| Backend | PHP 8.2 |
| Database | MySQL / MariaDB (via XAMPP) |
| Frontend | HTML5, CSS3, JavaScript |
| UI Framework | Bootstrap 5.3 |
| Icons | Font Awesome 6.4 |
| Animations | Animate.css |
| Testing | PHPUnit 11.5 |
| Development Environment | XAMPP, phpMyAdmin, PHPStorm |

---

## 📁 Project Structure

/
├── index.php                        ← Home page
├── style.css                        ← Global stylesheet
│
├── includes/                        ← Shared PHP components
│   ├── init.php                     ← Session bootstrap and ROOT_PATH constant
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

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/Lancelcode/Graded-Unit-2-webpage.git
```

### 2. Set up XAMPP

- Start **Apache** and **MySQL** in the XAMPP control panel
- Copy the project folder into your `htdocs` directory

### 3. Set up the database

- Open **phpMyAdmin** at `http://localhost/phpmyadmin`
- Create a new database named `gradedunit`
- Import `database/gradedunit.sql`
- Update database credentials in `includes/connect_db.php` if needed

### 4. Open the application
http://localhost/Graded-Unit-2-webpage/

---

## 🧪 Testing

The project uses both automated and manual testing strategies.

### Automated — PHPUnit

**✅ 10 tests, 11 assertions — all passing**

| Test Class | Coverage |
|---|---|
| `LoginTest` | Valid login flow, CSRF token rejection |
| `GreenCalculatorTest` | All-green scoring, mixed selections, all-red scoring |
| `CommunityTipsTest` | Create, update and delete tip operations |
| `PaymentTest` | Successful payment simulation, declined payment handling |

A `fake_login_tools.php` helper simulates authenticated session state for testing protected routes without a live database connection.

Run the full test suite from the project root:

```bash
php phpunit.phar --testdox
```

### Manual

All user-facing flows were tested end to end, including registration, login, calculator submission, certificate generation, community interaction, feedback submission, and the full admin panel. Form validation, navigation, and responsive layout were verified across multiple screen sizes.

---

## 🛡️ Security

- **Password hashing** — all passwords stored using `password_hash()` with `PASSWORD_DEFAULT` (bcrypt)
- **SQL injection prevention** — all database interactions use MySQLi prepared statements with bound parameters
- **CSRF protection** — tokens generated per session and validated on every state-changing form submission
- **Role-based access control** — admin routes return HTTP 403 if accessed without the correct session role
- **Output sanitisation** — all user-supplied data escaped with `htmlspecialchars()` before rendering
- **Authentication enforcement** — protected pages redirect to login if no valid session is present

---

## 🗄️ Database Schema

The application uses six tables:

| Table | Purpose |
|---|---|
| `new_users` | User accounts, roles, statuses and company details |
| `green_calculator_results` | Assessment submissions, scores, award levels and donation records |
| `community_tips` | User-submitted sustainability tips |
| `feedback` | User feedback messages and admin responses |
| `credit_cards` | Saved payment card details per user |
| `success_stories` | Reserved for future community success story submissions |

---

## 👤 Author

**Djiby Sow Rebollo** ([@Lancelcode](https://github.com/Lancelcode))  
Edinburgh College — Software Development  
Graded Unit 2 — Academic Year 2024/2025
