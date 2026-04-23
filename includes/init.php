<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));

if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $rootDir   = str_replace('\\', '/', ROOT_PATH);
    $docRoot   = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $base      = rtrim(str_replace($docRoot, '', $rootDir), '/');
    define('BASE_URL', $base);
}

// Generate CSRF token once per session — available to every page automatically
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}