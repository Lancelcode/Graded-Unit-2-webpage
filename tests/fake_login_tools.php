<?php
// Fake validate() for testing
function validate($link, $email, $password, $is_admin_login = false) {
    return [true, [
        'id' => 1,
        'username' => 'Test User',
        'email' => $email,
        'role' => $is_admin_login ? 'admin' : 'user'
    ]];
}

// ✅ Fake load() for testing
function load($page = 'index.php') {
    // In test mode, just do nothing — prevent real redirect
}
