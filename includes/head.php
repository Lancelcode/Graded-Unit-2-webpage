<?php
// head.php — start of every page
// Expects $pageTitle to be set by the including script.
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle ?? 'GreenScore') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <!-- Your global styles -->
    <link rel="stylesheet" href="/style.css">
</head>
<body>
