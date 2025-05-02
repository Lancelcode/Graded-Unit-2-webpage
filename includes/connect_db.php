<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradedunit";

// Enable exceptions for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Attempt connection
    $link = new mysqli($servername, $username, $password, $dbname);
    $link->set_charset("utf8mb4");

    // Connection successful
    //echo "<div class='alert alert-success'>Connected to the database successfully.</div>";
} catch (mysqli_sql_exception $e) {
    // Handle connection error gracefully
    echo "<div class='alert alert-danger'>Database connection failed: " . $e->getMessage() . "</div>";
    // Optionally log the error
    // error_log($e->getMessage());
    exit;
}
?>
