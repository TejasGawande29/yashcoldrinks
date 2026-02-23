<?php
/**
 * Admin Panel Configuration
 * Defines paths and constants for the admin panel
 */

// Base paths - adjust these if you move the project
define('BASE_PATH', dirname(dirname(__DIR__))); // Root of YashColdrinks
define('ADMIN_PATH', dirname(__DIR__)); // admin/ folder
define('CONFIG_PATH', BASE_PATH . '/config');

// URL paths (relative to web root)
// For local development server (php -S localhost:8000), use empty BASE_URL
// For XAMPP (http://localhost/YashColdrinks), use '/YashColdrinks'
// For InfinityFree (root domain), use empty ''
define('BASE_URL', '/YashColdrinks'); // Change to '/YashColdrinks' for XAMPP or '' for production
define('ADMIN_URL', BASE_URL . '/admin');
define('ASSETS_URL', BASE_URL . '/assets');
define('CUSTOMER_URL', BASE_URL . '/customer');

// Include database connection
require_once CONFIG_PATH . '/database.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if admin is logged in
 */
function isAdminLoggedIn() {
    return isset($_SESSION["USERNAME"]) && isset($_SESSION["ROLE"]);
}

/**
 * Require admin login - redirect if not logged in
 */
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header("Location: " . ADMIN_URL . "/adminlogin.php");
        exit;
    }
}

/**
 * Helper function to get admin asset URL
 */
function admin_asset($path) {
    return ADMIN_URL . '/assets/' . ltrim($path, '/');
}

/**
 * Helper function to get admin page URL
 */
function admin_url($path = '') {
    return ADMIN_URL . '/' . ltrim($path, '/');
}

/**
 * Helper function to include admin file
 */
function admin_include($file) {
    return ADMIN_PATH . '/includes/' . $file;
}
