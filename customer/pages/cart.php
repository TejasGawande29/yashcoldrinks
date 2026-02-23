<?php
/**
 * Shopping Cart Page
 * Displays cart items and handles checkout
 */

// Include configuration
require_once __DIR__ . '/../includes/config.php';

// Process order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    
    $total = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    
    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, total_amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $name, $phone, $address, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    
    // Insert order items
    foreach ($_SESSION['cart'] as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }
    
    // Clear cart
    $_SESSION['cart'] = [];
    
    header("Location: order_success.php?order_id=$order_id");
    exit;
}

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Yash Coldrinks</title>
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
    
    <main class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-screen-xl mx-auto px-4" id="cart-content">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Your Shopping Cart</h1>
            
            <?php if (empty($_SESSION['cart'])): ?>
                <div class="text-center py-20">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-6"></i>
                    <p class="text-xl text-gray-600">Your cart is empty</p>
                    <a href="all-products.php" class="mt-6 inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                        Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="divide-y">
                                <?php 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $id => $item): 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                <div class="p-6 flex items-center cart-item" data-id="<?= $id ?>">
                                    <img src="<?= asset('images/' . $item['name'] . '.png') ?>" 
                                         alt="<?= htmlspecialchars($item['name']) ?>" 
                                         class="w-20 h-20 object-contain">
                                    <div class="ml-6 flex-1">
                                        <h3 class="font-semibold text-lg"><?= htmlspecialchars($item['name']) ?></h3>
                                        <p class="text-purple-600 font-bold">₹<?= number_format($item['price'], 2) ?></p>
                                    </div>
                                    <div class="flex items-center">
                                        <button class="quantity-minus px-3 py-1 bg-gray-200 rounded-l">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" min="1" value="<?= $item['quantity'] ?>" 
                                            class="quantity-input w-12 text-center py-1 border-y">
                                        <button class="quantity-plus px-3 py-1 bg-gray-200 rounded-r">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <p class="font-bold ml-6 w-24 text-right">₹<?= number_format($subtotal, 2) ?></p>
                                    <button class="remove-item ml-6 text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                            <div class="flex justify-between mb-2">
                                <span>Subtotal</span>
                                <span>₹<?= number_format($total, 2) ?></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Delivery</span>
                                <span>FREE</span>
                            </div>
                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between font-bold text-lg">
                                    <span>Total</span>
                                    <span>₹<?= number_format($total, 2) ?></span>
                                </div>
                            </div>
                            <button id="checkout-btn" class="w-full mt-6 bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg transition">
                                Place Order (Cash on Delivery)
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Checkout Modal -->
    <div id="checkout-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-6">Complete Your Order</h2>
            <form id="order-form" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Delivery Address</label>
                    <textarea name="address" required rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancel-order" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                        Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include customer_include('footer.php'); ?>

    <script>
    // Cart item interactions
    $('.quantity-minus').click(function() {
        const item = $(this).closest('.cart-item');
        const id = item.data('id');
        const input = item.find('.quantity-input');
        let quantity = parseInt(input.val());
        
        if (quantity > 1) {
            quantity--;
            input.val(quantity);
            updateCartItem(id, quantity);
        }
    });
    
    $('.quantity-plus').click(function() {
        const item = $(this).closest('.cart-item');
        const id = item.data('id');
        const input = item.find('.quantity-input');
        let quantity = parseInt(input.val());
        
        quantity++;
        input.val(quantity);
        updateCartItem(id, quantity);
    });
    
    $('.remove-item').click(function() {
        const item = $(this).closest('.cart-item');
        const id = item.data('id');
        
        $.ajax({
            url: '<?= customer_url('ajax/cart_action.php') ?>',
            method: 'POST',
            data: {
                action: 'remove',
                product_id: id
            },
            success: function() {
                item.remove();
                updateCartCount();
                if ($('.cart-item').length === 0) {
                    location.reload();
                } else {
                    updateTotals();
                }
            }
        });
    });
    
    function updateCartItem(productId, quantity) {
        $.ajax({
            url: '<?= customer_url('ajax/cart_action.php') ?>',
            method: 'POST',
            data: {
                action: 'update',
                product_id: productId,
                quantity: quantity
            },
            success: function() {
                updateCartCount();
                updateTotals();
            }
        });
    }
    
    function updateTotals() {
        location.reload(); // Simple refresh to update totals
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
    
    // Checkout modal
    $('#checkout-btn').click(function() {
        $('#checkout-modal').removeClass('hidden').addClass('flex');
    });
    
    $('#cancel-order').click(function() {
        $('#checkout-modal').addClass('hidden').removeClass('flex');
    });
    </script>
</body>
</html>
