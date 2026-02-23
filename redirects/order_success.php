<?php
/**
 * Redirect: order_success.php -> customer/pages/order_success.php
 * For backward compatibility
 */
$query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
header("Location: /YashColdrinks/customer/pages/order_success.php" . $query);
exit;
