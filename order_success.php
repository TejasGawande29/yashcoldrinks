<?php
include_once('dbconnection.php');
$order_id = $_GET['order_id'] ?? 0;

// Fetch order details
$order = [];
if ($order_id) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>All Products | Yash Coldrinks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="dist/output.css">
    <script src="js/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>

</head>
<body>
    <?php include('header.php'); ?>
    
    <main class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-screen-md mx-auto px-4 text-center">
            <?php if ($order): ?>
                <div class="bg-white rounded-xl shadow-md p-8">
                    <div class="text-green-500 text-6xl mb-6">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Order Placed Successfully!</h1>
                    <p class="text-gray-600 mb-8">
                        Thank you for your order. We'll deliver your cold drinks soon.
                    </p>
                    
                    <div class="bg-gray-50 rounded-lg p-6 text-left max-w-md mx-auto">
                        <h2 class="text-xl font-bold mb-4">Order Details</h2>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-bold">#<?= $order['id'] ?></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-bold">₹<?= number_format($order['total_amount'], 2) ?></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Delivery To:</span>
                            <span class="font-bold"><?= $order['customer_name'] ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <a href="all-products.php" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-md p-8">
                    <div class="text-red-500 text-6xl mb-6">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Order Not Found</h1>
                    <p class="text-gray-600 mb-8">
                        Sorry, we couldn't find your order details.
                    </p>
                    <a href="all-products.php" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                        Continue Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include('footer.php'); ?>
</body>
</html>