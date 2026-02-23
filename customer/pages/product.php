<?php
/**
 * Product Detail Page
 * Shows detailed product information
 */

// Include configuration
require_once __DIR__ . '/../includes/config.php';

$product_id = $_GET['id'] ?? 0;

// Fetch product details
$product = null;
if ($product_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

// Fetch related products (same category or random if no category)
$related_products = [];
if ($product) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id != ? LIMIT 4");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $related_products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['name']) : 'Product' ?> | Yash Coldrinks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/output.css') ?>">
    <script src="<?= asset('js/jquery.js') ?>"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="bg-white text-gray-800">
    <?php include customer_include('header.php'); ?>

    <?php if ($product): ?>
    <main class="py-16">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Left: Product Image -->
            <div class="flex items-center justify-center bg-gray-50 rounded-xl p-8">
                <img id="mainImage" src="<?= htmlspecialchars($product['image']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>" 
                     class="w-full max-w-sm object-contain">
            </div>

            <!-- Right: Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold"><?= htmlspecialchars($product['name']) ?></h1>
                    <div class="flex items-center space-x-2 text-yellow-500 mt-2">
                        <span>★★★★☆</span>
                        <span class="text-gray-600 text-sm">Reviews</span>
                    </div>
                </div>

                <div>
                    <p class="text-3xl text-red-600 font-bold">
                        ₹<?= number_format($product['price'], 2) ?>
                    </p>
                    <p class="text-gray-600 text-sm mt-1">(Incl. of all taxes)</p>
                </div>

                <?php if (!empty($product['description'])): ?>
                <div>
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-gray-600"><?= htmlspecialchars($product['description']) ?></p>
                </div>
                <?php endif; ?>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center border rounded-lg">
                        <button id="qty-minus" class="px-4 py-2 hover:bg-gray-100">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" 
                               class="w-16 text-center py-2 border-x">
                        <button id="qty-plus" class="px-4 py-2 hover:bg-gray-100">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <button onclick="addToCart(<?= $product['id'] ?>)" 
                        class="bg-purple-600 hover:bg-purple-700 text-white w-full py-3 font-bold rounded-lg transition">
                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                </button>

                <div class="grid grid-cols-3 gap-4 pt-4 border-t">
                    <div class="text-center">
                        <i class="fas fa-truck text-2xl text-purple-600 mb-2"></i>
                        <p class="text-sm text-gray-600">Free Delivery</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-undo text-2xl text-purple-600 mb-2"></i>
                        <p class="text-sm text-gray-600">Easy Returns</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-shield-alt text-2xl text-purple-600 mb-2"></i>
                        <p class="text-sm text-gray-600">Secure Payment</p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($related_products)): ?>
        <!-- Related Products -->
        <section class="mt-16 bg-gray-50 py-12">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-2xl font-bold mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <?php foreach ($related_products as $related): ?>
                    <a href="product.php?id=<?= $related['id'] ?>" 
                       class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="<?= htmlspecialchars($related['image']) ?>" 
                             alt="<?= htmlspecialchars($related['name']) ?>" 
                             class="w-full h-40 object-contain p-4">
                        <div class="p-4">
                            <h3 class="font-semibold"><?= htmlspecialchars($related['name']) ?></h3>
                            <p class="text-red-600 font-bold">₹<?= number_format($related['price'], 2) ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>
    <?php else: ?>
    <main class="py-16">
        <div class="max-w-screen-md mx-auto px-4 text-center">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="text-gray-400 text-6xl mb-6">
                    <i class="fas fa-box-open"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Product Not Found</h1>
                <p class="text-gray-600 mb-8">
                    Sorry, the product you're looking for doesn't exist.
                </p>
                <a href="all-products.php" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                    Browse Products
                </a>
            </div>
        </div>
    </main>
    <?php endif; ?>

    <?php include customer_include('footer.php'); ?>

    <script>
    // Quantity controls
    $('#qty-minus').click(function() {
        let qty = parseInt($('#quantity').val());
        if (qty > 1) $('#quantity').val(qty - 1);
    });
    
    $('#qty-plus').click(function() {
        let qty = parseInt($('#quantity').val());
        $('#quantity').val(qty + 1);
    });
    
    function addToCart(productId) {
        const quantity = parseInt($('#quantity').val()) || 1;
        
        for (let i = 0; i < quantity; i++) {
            $.ajax({
                url: '<?= customer_url('ajax/cart_action.php') ?>',
                method: 'POST',
                data: { 
                    action: 'add',
                    product_id: productId
                },
                success: function(response) {
                    if (i === quantity - 1) {
                        toastr.success('Product added to cart!');
                        updateCartCount();
                    }
                },
                error: function() {
                    toastr.error('Failed to add product to cart');
                }
            });
        }
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
