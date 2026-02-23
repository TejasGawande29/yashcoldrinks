<?php 
include_once('dbconnection.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ResultType = isset($_POST["RESULT_TYPE"]) ? $_POST["RESULT_TYPE"] : '';

switch($ResultType){
    case "LOGIN":
        $result = customerLogin($_POST["userid"], $_POST["password"]);
        echo $result;
        break;
    case "GET_CART_COUNT":
        echo getCartCount();
        break;
    default:
        // No action
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
?>