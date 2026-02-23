<?php
/**
 * InfinityFree Database Configuration
 * RENAME THIS FILE TO: database.php
 * REPLACE THE VALUES BELOW WITH YOUR INFINITYFREE CREDENTIALS
 */

// ⚠️ IMPORTANT: Replace these with YOUR InfinityFree database credentials
$servername = "sql###.infinityfree.com";        // Example: sql212.infinityfree.com
$username = "epizy_XXXXXXX";                    // Example: epizy_12345678
$password = "YOUR_DATABASE_PASSWORD";           // The password you set
$dbname = "epizy_XXXXXXX_yashcoldrinks";       // Example: epizy_12345678_yashcoldrinks

// ====================
// DO NOT EDIT BELOW
// ====================

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Connection failed. Please check your database credentials.");
}

$conn->set_charset("utf8mb4");
?>
