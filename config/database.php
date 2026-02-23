<?php
/**
 * Database Configuration
 * YashColdrinks - Central Database Connection
 */

// Prevent direct access
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yashcoldrinks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}

// Set charset to prevent encoding issues
$conn->set_charset("utf8mb4");
?>
