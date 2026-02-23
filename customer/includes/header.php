<?php
/**
 * Customer Website Header Component
 * YashColdrinks - Customer Portal
 */

// Define base URL for assets (fallback if config not loaded)
if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', '/YashColdrinks/assets');
}
if (!defined('CUSTOMER_URL')) {
    define('CUSTOMER_URL', '/YashColdrinks/customer');
}
?>
<header>
    <nav class="bg-gradient-to-r from-purple-800 via-purple-700 to-purple-900 text-white px-6 py-4 shadow-lg transition-all duration-500 sticky top-0 z-50">
      <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Logo -->
        <div class="flex items-center gap-2 animate-fade-in">
          <a href="<?= CUSTOMER_URL ?>/index.php">
            <img class="w-24 h-auto rounded-xl shadow-lg hover:scale-105 transition-transform duration-300" src="<?= ASSETS_URL ?>/images/logo.png" alt="Logo" />
          </a>
        </div>

        <!-- Navigation Links -->
        <ul class="flex flex-wrap gap-3 md:gap-6 items-center text-lg md:text-xl font-medium">
          <li><a href="<?= CUSTOMER_URL ?>/index.php" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Home</a></li>
          <li><a href="<?= CUSTOMER_URL ?>/pages/all-products.php" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">All Products</a></li>
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Offers</a></li>
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Home Delivery</a></li>
          <li>
            <a href="#" class="hover:bg-white/10 px-4 py-2 rounded flex items-center gap-2 transition duration-300 hover:scale-105">
              <i class="fas fa-user-cog text-red-400"></i><span>Manage Profile</span>
            </a>
          </li>
          <li>
            <a href="<?= CUSTOMER_URL ?>/pages/cart.php" class="relative hover:bg-white/10 px-4 py-2 rounded transition duration-300 hover:scale-105">
              🛒
              <span id="cart-count" class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full animate-pulse">0</span>
            </a>
          </li>
          <li>
            <a href="<?= ADMIN_URL ?>/adminlogin.php" target="_blank" class="hover:bg-white/10 px-4 py-2 rounded flex items-center gap-2 transition duration-300 hover:scale-105">
              <i class="fa-solid fa-user text-green-500"></i><span>Admin Login</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
</header>
