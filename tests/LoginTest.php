<?php
use PHPUnit\Framework\TestCase;

// ✅ Load the fake login logic instead of the real one
require_once __DIR__ . '/fake_login_tools.php';

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['csrf_token'] = 'test_csrf_token';
        $GLOBALS['link'] = true; // Fake connection to skip mysqli errors
    }

    public function testValidLogin()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'testuser@example.com';
        $_POST['password'] = 'password123';
        $_POST['csrf_token'] = 'test_csrf_token';

        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        ob_end_clean();

        $this->assertNotEmpty($_SESSION['id'], "Session ID should be set after successful login.");
    }

    public function testInvalidCsrfToken()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'testuser@example.com';
        $_POST['password'] = 'password123';
        $_POST['csrf_token'] = 'wrong_token';

        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid CSRF token', $output, "Should detect invalid CSRF token.");
    }
}
