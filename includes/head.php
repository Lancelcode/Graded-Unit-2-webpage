<?php
/*
 * includes/head.php
 * Outputs ONLY the content that belongs inside <head> — no wrapper tags.
 *
 * FIX: previously output <!DOCTYPE html><html><head>...</head><body>
 * which broke any page that included this inside their own <head> tags,
 * producing nested doctypes, html tags and body tags.
 *
 * Usage:
 * <!DOCTYPE html>
 * <html lang="en">
 * <head>
 *     <?php include 'includes/head.php'; ?>
 *     <title>Page Title</title>
 * </head>
 */
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">