<?php
/*
 * includes/head.php
 * Outputs ONLY the content that belongs inside <head> — no wrapper tags.
 * FIX: stylesheet now uses BASE_URL so it loads correctly from any subdirectory.
 */
if (!defined('BASE_URL')) require_once __DIR__ . '/init.php';
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/style.css" rel="stylesheet">