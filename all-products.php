<?php
// Enable error reporting for development
ini_set('display_errors', 0); // Set to 0 in production
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include_once('dbconnection.php');
session_start();

// Fetch all products
$products = [];
$result = $conn->query("SELECT * FROM products");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
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
<?php include(__DIR__ . '/header.php'); ?>

    <main class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">All Products</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach ($products as $product): ?>
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full h-56 object-contain p-4">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= $product['name'] ?></h3>
                        <p class="text-red-600 font-bold text-lg mb-4">₹<?= number_format($product['price'], 2) ?></p>
                        <button onclick="addToCart(<?= $product['id'] ?>)" 
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg transition">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php include(__DIR__ . '/footer.php'); ?>

    
    <script>
    function addToCart(productId) {
        $.ajax({
            url: 'cart_action.php',
            method: 'POST',
            data: { 
                action: 'add',
                product_id: productId
            },
            success: function(response) {
                toastr.success('Product added to cart!');
                updateCartCount();
            }
        });
    }
    
    function updateCartCount() {
        $.ajax({
            url: 'cart_action.php',
            method: 'POST',
            data: { action: 'count' },
            success: function(count) {
                $('#cart-count').text(count);
            }
        });
    }
    
    // Initialize cart count
    $(document).ready(function() {
        updateCartCount();
    });
    </script>
</body>
</html>