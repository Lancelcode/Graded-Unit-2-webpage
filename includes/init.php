<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();     // runs exactly once per request
}
