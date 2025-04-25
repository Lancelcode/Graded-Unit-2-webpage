<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $backupGlobalsBlacklist = ['_SESSION', '_POST'];

    protected function setUp(): void
    {
        // Start a new session
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Fake CSRF token setup
        $_SESSION['csrf_token'] = 'test_csrf_token';
    }

    public function testValidLogin()
    {
        // Simulate valid POST input
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'testuser@example.com';
        $_POST['password'] = 'password123';
        $_POST['csrf_token'] = 'test_csrf_token';

        // Fake validate() function behavior
        require_once __DIR__ . '/../includes/login_tools.php';
        $GLOBALS['link'] = mysqli_connect('localhost', 'root', '', 'gradedunit'); // <-- Your DB here

        /* Mock validate() to succeed
        function validate($link, $email, $password, $is_admin_login = false) {
            return [true, [
                'id' => 1,
                'username' => 'Test User',
                'email' => $email,
                'role' => $is_admin_login ? 'admin' : 'user'
            ]];
        }*/

        // Include the login action
        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        ob_end_clean();

        // Assertions
        $this->assertNotEmpty($_SESSION['id'], "Session ID should be set after successful login.");
        $this->assertEquals('testuser@example.com', $_SESSION['email'], "Session email should match posted email.");
    }

    public function testInvalidCsrfToken()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'testuser@example.com';
        $_POST['password'] = 'password123';
        $_POST['csrf_token'] = 'invalid_csrf_token';

        ob_start();
        include __DIR__ . '/../includes/login_action.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid CSRF token', $output, "Should detect invalid CSRF token.");
    }
}
?>
