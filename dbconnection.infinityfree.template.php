<?php
/**
 * InfinityFree Database Connection Template
 * 
 * INSTRUCTIONS:
 * 1. Copy this file and rename it to 'dbconnection.php'
 * 2. Replace the placeholder values with your InfinityFree database credentials
 * 3. Upload to the root folder on your hosting
 */

// ⚠️ REPLACE THESE VALUES WITH YOUR INFINITYFREE CREDENTIALS ⚠️

$servername = "sql###.infinityfree.com";        // Your InfinityFree DB host
$username = "epizy_XXXXXXX";                    // Your InfinityFree DB username
$password = "YOUR_DATABASE_PASSWORD";           // Your database password
$dbname = "epizy_XXXXXXX_yashcoldrinks";       // Your database name

// ====================
// DO NOT EDIT BELOW THIS LINE
// ====================

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}

// Optional: Uncomment for debugging (REMOVE IN PRODUCTION)
// echo "Connection Successful!";
?>
