<?php
/**
 * Quick Database Connection Test
 * Run this to verify XAMPP and database are working
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yashcoldrinks";

echo "<h2>YashColdrinks - Database Connection Test</h2>";
echo "<hr>";

// Check if MySQL is accessible
$conn = @new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "❌ <strong>MySQL Connection Failed:</strong> " . $conn->connect_error . "<br>";
    echo "<p style='color: orange;'>Please start XAMPP Apache and MySQL services.</p>";
    exit();
}

echo "✅ <strong>MySQL Server Connected</strong><br>";

// Check if database exists
$db_check = $conn->select_db($dbname);
if (!$db_check) {
    echo "❌ <strong>Database '$dbname' not found</strong><br>";
    echo "<p style='color: orange;'>Please import the database from Backups/yashcoldrinks.sql</p>";
    echo "<p>Run this command in phpMyAdmin:<br>";
    echo "<code>CREATE DATABASE yashcoldrinks;</code><br>";
    echo "Then import: <code>Backups/yashcoldrinks.sql</code></p>";
    $conn->close();
    exit();
}

echo "✅ <strong>Database '$dbname' exists</strong><br>";

// Check tables
$tables_query = $conn->query("SHOW TABLES");
$table_count = $tables_query->num_rows;

echo "✅ <strong>Found $table_count tables</strong><br>";

if ($table_count > 0) {
    echo "<ul>";
    while ($row = $tables_query->fetch_array()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
}

echo "<hr>";
echo "<h3>✅ All checks passed! Your project is ready to run.</h3>";
echo "<p><a href='index.php'>Go to Customer Site</a> | <a href='admin/'>Go to Admin Panel</a></p>";

$conn->close();
?>
