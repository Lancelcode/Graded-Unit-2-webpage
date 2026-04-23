<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ROOT_PATH points to the project root regardless of how deep the calling file is
define('ROOT_PATH', dirname(__DIR__));