<?php
/**
 * Customer Site Configuration
 * Defines paths and constants for the customer-facing website
 */

// Base paths - adjust these if you move the project
define('BASE_PATH', dirname(dirname(__DIR__))); // Root of YashColdrinks
define('CUSTOMER_PATH', dirname(__DIR__)); // customer/ folder
define('CONFIG_PATH', BASE_PATH . '/config');

// URL paths (relative to web root)
// For local development server (php -S localhost:8000), use empty BASE_URL
// For XAMPP (http://localhost/YashColdrinks), use '/YashColdrinks'
// For InfinityFree (root domain), use empty ''
define('BASE_URL', '/YashColdrinks'); // Change to '/YashColdrinks' for XAMPP or '' for production
define('CUSTOMER_URL', BASE_URL . '/customer');
define('ASSETS_URL', BASE_URL . '/assets');
define('ADMIN_URL', BASE_URL . '/admin');

// Include database connection
require_once CONFIG_PATH . '/database.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Helper function to get asset URL
 */
function asset($path) {
    return ASSETS_URL . '/' . ltrim($path, '/');
}

/**
 * Helper function to get customer page URL
 */
function customer_url($path = '') {
    return CUSTOMER_URL . '/' . ltrim($path, '/');
}

/**
 * Helper function to include customer file
 */
function customer_include($file) {
    return CUSTOMER_PATH . '/includes/' . $file;
}
