<?php
/**
 * InfinityFree Database Configuration Template
 * 
 * INSTRUCTIONS:
 * 1. Copy this file and rename it to 'database.php'
 * 2. Replace the placeholder values with your InfinityFree database credentials
 * 3. Upload to the 'config/' folder on your hosting
 */

// ⚠️ REPLACE THESE VALUES WITH YOUR INFINITYFREE CREDENTIALS ⚠️

$servername = "sql###.infinityfree.com";        // Your InfinityFree DB host (e.g., sql123.infinityfree.com)
$username = "epizy_XXXXXXX";                    // Your InfinityFree DB username (e.g., epizy_12345678)
$password = "YOUR_DATABASE_PASSWORD";           // Your database password (set in InfinityFree panel)
$dbname = "epizy_XXXXXXX_yashcoldrinks";       // Your database name (e.g., epizy_12345678_yashcoldrinks)

// ====================
// DO NOT EDIT BELOW THIS LINE
// ====================

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Connection failed. Please check your database credentials.");
}

// Set charset to prevent encoding issues
$conn->set_charset("utf8mb4");

// Optional: Uncomment for debugging (REMOVE IN PRODUCTION)
// echo "Database connected successfully!";
?>
