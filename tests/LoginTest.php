<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/fake_login_tools.php';

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['csrf_token'] = 'test_csrf_token';
        $GLOBALS['link']        = true;
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        $_POST    = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    // ── validate() unit tests ────────────────────────────────

    public function testValidateSucceedsWithCorrectCredentials(): void
    {
        [$ok, $data] = validate(true, 'user@example.com', 'userpass123');

        $this->assertTrue($ok, 'Valid credentials should return true.');
        $this->assertEquals('user@example.com', $data['email']);
        $this->assertEquals('user', $data['role']);
        $this->assertEquals(2, $data['id']);
    }

    public function testValidateFailsWithWrongPassword(): void
    {
        [$ok, $errors] = validate(true, 'user@example.com', 'wrongpassword');

        $this->assertFalse($ok, 'Wrong password should return false.');
        $this->assertContains('Incorrect password.', $errors);
    }

    public function testValidateFailsWithUnknownEmail(): void
    {
        [$ok, $errors] = validate(true, 'nobody@example.com', 'password123');

        $this->assertFalse($ok);
        $this->assertContains('Email address and password not found.', $errors);
    }

    public function testValidateFailsWithEmptyEmail(): void
    {
        [$ok, $errors] = validate(true, '', 'password123');

        $this->assertFalse($ok);
        $this->assertContains('Enter your email address.', $errors);
    }

    public function testValidateFailsWithEmptyPassword(): void
    {
        [$ok, $errors] = validate(true, 'user@example.com', '');

        $this->assertFalse($ok);
        $this->assertContains('Enter your password.', $errors);
    }

    public function testAdminRoleReturnedCorrectly(): void
    {
        [$ok, $data] = validate(true, 'admin@example.com', 'adminpass123');

        $this->assertTrue($ok);
        $this->assertEquals('admin', $data['role']);
    }

    // ── login_action.php integration tests ──────────────────

    public function testLoginActionSetsCorrectSessionKeys(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'email'      => 'user@example.com',
            'password'   => 'userpass123',
            'csrf_token' => 'test_csrf_token',
        ];

        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        ob_end_clean();

        $this->assertArrayHasKey('user_id',  $_SESSION, 'Session must contain user_id.');
        $this->assertArrayHasKey('username', $_SESSION, 'Session must contain username.');
        $this->assertArrayHasKey('email',    $_SESSION, 'Session must contain email.');
        $this->assertArrayHasKey('role',     $_SESSION, 'Session must contain role.');
    }

    public function testLoginActionRejectsInvalidCsrfToken(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'email'      => 'user@example.com',
            'password'   => 'userpass123',
            'csrf_token' => 'wrong_token',
        ];

        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        ob_end_clean();

        $this->assertArrayNotHasKey('user_id', $_SESSION,
            'Session user_id must not be set after CSRF failure.'
        );
    }

    public function testLoginActionSetsLoginErrorOnBadPassword(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'email'      => 'user@example.com',
            'password'   => 'completelyWrong',
            'csrf_token' => 'test_csrf_token',
        ];

        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        ob_end_clean();

        $this->assertArrayHasKey('login_error', $_SESSION,
            'A login_error should be set in session on bad credentials.'
        );
    }
}