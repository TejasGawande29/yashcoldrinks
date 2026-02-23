<?php
/**
 * Redirect: product.php -> customer/pages/product.php
 * For backward compatibility
 */
$query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
header("Location: /YashColdrinks/customer/pages/product.php" . $query);
exit;
