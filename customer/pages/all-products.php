<?php
/**
 * All Products Page
 * Displays all available products for customers
 */

// Include configuration
require_once __DIR__ . '/../includes/config.php';

// Fetch all products
$products = [];
$result = $conn->query("SELECT * FROM products ORDER BY name ASC");
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products | Yash Coldrinks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/output.css') ?>">
    <script src="<?= asset('js/jquery.js') ?>"></script>
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
    <?php include customer_include('header.php'); ?>

    <main class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">All Products</h2>
            
            <?php if (empty($products)): ?>
                <div class="text-center py-20">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-6"></i>
                    <p class="text-xl text-gray-600">No products available yet</p>
                    <a href="<?= customer_url('') ?>" class="mt-6 inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                        Go Home
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <?php foreach ($products as $product): ?>
                    <div class="product-card bg-white rounded-xl shadow-md overflow-hidden">
                        <img src="<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="w-full h-56 object-contain p-4">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="text-red-600 font-bold text-lg mb-4">₹<?= number_format($product['price'], 2) ?></p>
                            <button onclick="addToCart(<?= $product['id'] ?>)" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg transition">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include customer_include('footer.php'); ?>

    <script>
    function addToCart(productId) {
        $.ajax({
            url: '<?= customer_url('ajax/cart_action.php') ?>',
            method: 'POST',
            data: { 
                action: 'add',
                product_id: productId
            },
            success: function(response) {
                toastr.success('Product added to cart!');
                updateCartCount();
            },
            error: function() {
                toastr.error('Failed to add product to cart');
            }
        });
    }
    
    function updateCartCount() {
        $.ajax({
            url: '<?= customer_url('ajax/cart_action.php') ?>',
            method: 'POST',
            data: { action: 'count' },
            success: function(count) {
                $('#cart-count').text(count);
            }
        });
    }
    
    $(document).ready(function() {
        updateCartCount();
    });
    </script>
</body>
</html>
