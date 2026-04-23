<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ROOT_PATH — absolute filesystem path to the project root
// Used for require_once and file_exists() calls
define('ROOT_PATH', dirname(__DIR__));

// BASE_URL — the URL prefix to reach the project root from the browser
// Auto-detected so the app works on any machine without configuration.
//
// Examples:
//   localhost/Graded-Unit-2-webpage/  →  BASE_URL = /Graded-Unit-2-webpage
//   localhost/                        →  BASE_URL = (empty string)
//   greenscore.com/                   →  BASE_URL = (empty string)
//
if (!defined('BASE_URL')) {
    $scriptDir  = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $rootDir    = str_replace('\\', '/', ROOT_PATH);
    $docRoot    = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

    // Walk up from the calling script's directory until we reach ROOT_PATH
    $base = rtrim(str_replace($docRoot, '', $rootDir), '/');
    define('BASE_URL', $base);
}