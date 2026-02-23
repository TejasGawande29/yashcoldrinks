<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["ROLE"]) || $_SESSION["ROLE"] !== "admin") {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit;
}

include_once("../dbconnection.php");

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Expense deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting expense"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>