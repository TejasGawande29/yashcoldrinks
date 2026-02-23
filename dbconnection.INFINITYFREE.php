<?php
/**
 * InfinityFree Database Connection
 * RENAME THIS FILE TO: dbconnection.php
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

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}
?>
