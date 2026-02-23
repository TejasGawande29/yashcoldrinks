<?php
/**
 * Customer Functions
 * YashColdrinks - Customer Portal
 */

// Include database configuration
require_once dirname(__DIR__, 2) . '/config/database.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle AJAX requests
$ResultType = isset($_POST["RESULT_TYPE"]) ? $_POST["RESULT_TYPE"] : '';

switch($ResultType){
    case "LOGIN":
        $result = customerLogin($_POST["userid"], $_POST["password"]);
        echo $result;
        break;
    case "GET_CART_COUNT":
        echo getCartCount();
        break;
    case "ADD_TO_CART":
        $result = addToCart($_POST["product_id"]);
        echo $result;
        break;
    default:
        // No action for direct page load
        break;
}

/**
 * Customer login function
 */
function customerLogin($userid, $password){
    global $conn;
    $hashedPassword = md5($password);
    
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email=? AND password=?");
    if ($stmt) {
        $stmt->bind_param("ss", $userid, $hashedPassword);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $_SESSION["CUSTOMER_LOGIN"] = true;
                $_SESSION["CUSTOMER_ID"] = $row["id"];
                $_SESSION["CUSTOMER_NAME"] = $row["name"];
                return json_encode(["result" => 1, "message" => "Login Success"]);
            }
        }
    }
    return json_encode(["result" => 0, "message" => "Invalid credentials"]);
}

/**
 * Get cart item count
 */
function getCartCount(){
    if (isset($_SESSION['cart'])) {
        $count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    return 0;
}

/**
 * Add item to cart
 */
function addToCart($product_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
        return json_encode(['success' => true, 'message' => 'Added to cart']);
    }
    return json_encode(['success' => false, 'message' => 'Product not found']);
}
?>
