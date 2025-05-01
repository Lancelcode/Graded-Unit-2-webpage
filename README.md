# 🌱 Green Score – Sustainability Tracking Web App

**Green Score** is a web-based application developed to help users track and improve their environmental impact through a points-based reward system. By logging eco-friendly actions, users earn points, achieve badge levels, and unlock downloadable certificates. The platform also allows users to purchase additional Green Points and engage with a community board to share sustainability ideas.

This project was developed as part of the Graded Unit 2 Software Development assessment at Edinburgh College.

---

## 🌍 Key Features

- 🔐 Secure user registration and login with session tracking
- 🧮 Green Calculator for scoring sustainable actions (RED/AMBER/GREEN)
- 🏅 Badge awarding system and XP-style progress tracker (My Impact)
- 📄 Certificate generation and download based on achievements
- 💳 Buy Points page with Stripe-based payment simulation
- 📝 Community Tips feature (Create, Read, Update, Delete)
- 📬 Feedback system with admin responses and visibility control
- 🌙 Dark mode toggle and consistent UI with responsive layout
- 🧪 Automated testing using PHPUnit

---

## 🧩 Technologies Used

- **PHP 8.2.12**
- **MySQL/MariaDB**
- **HTML, CSS, JavaScript**
- **PHPUnit 11.5.18**
- **Font Awesome**
- **Bootstrap 5.3**
- **Animate.css**
- **Stripe API** (mocked for simulation)
- **XAMPP / phpMyAdmin**
- **PHPStorm IDE**

---

## ⚙️ Installation Instructions

1. **Clone or Download the Repository**
   ```bash
   git clone https://github.com/Lancelcode/Graded-Unit-2-webpage.git

Set Up Your Environment

Launch Apache and MySQL via XAMPP

Copy the project folder into htdocs (or your web directory)

Database Setup

Open phpMyAdmin

Create a database called greenscore

Import the SQL file: greenscore.sql

Update DB credentials in includes/connect_db.php if needed

Run Locally Open your browser and go to:

http://localhost/green-score

🧪 Testing Approach
White-box testing was used to validate backend logic and session handling

PHPUnit was used to test login, calculator scoring, CRUD operations, and payment simulation

A fake login tool was implemented to simulate session data for protected features

Manual testing was performed for all user flows, including form validation, navigation, and UI consistency

✅ 10 automated tests passed with 11 assertions
📸 Evidence included in /tests/ and screenshots

🛡️ Security Measures
Password hashing and input validation

CSRF token protection for forms

SQL injection prevention using prepared statements

Session-based access control for restricted features

