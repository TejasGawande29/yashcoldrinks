<header>
    <nav class="bg-gradient-to-r from-purple-800 via-purple-700 to-purple-900 text-white px-6 py-4 shadow-lg transition-all duration-500 sticky top-0 z-50">
      <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Logo -->
        <div class="flex items-center gap-2 animate-fade-in">
          <img class="w-24 h-auto rounded-xl shadow-lg hover:scale-105 transition-transform duration-300" src="image/logo.png" alt="Logo" />
        </div>

        <!-- Navigation Links -->
        <ul class="flex flex-wrap gap-3 md:gap-6 items-center text-lg md:text-xl font-medium">
          <li><a href="index.php" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Home</a></li>
          <li><a href="all-products.php" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">All Products</a></li>
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Offers</a></li>
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Home Delivery</a></li>
          <li>
            <a href="#" class="hover:bg-white/10 px-4 py-2 rounded flex items-center gap-2 transition duration-300 hover:scale-105">
              <i class="fas fa-user-cog text-red-400"></i><span>Manage Profile</span>
            </a>
          </li>
          <li>
            <a href="cart.php" class="relative hover:bg-white/10 px-4 py-2 rounded transition duration-300 hover:scale-105">
              🛒
              <span id="cart-count" class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full animate-pulse">0</span>
            </a>
          </li>
          <li onclick="openAdminlogin()">
            <a href="#" class="hover:bg-white/10 px-4 py-2 rounded flex items-center gap-2 transition duration-300 hover:scale-105">
              <i class="fa-solid fa-user text-green-500"></i><span>Admin Login</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

  </header>
  <script>
      function openAdminlogin() {
      // Open the admin login page in a new tab
      window.open("admin/adminlogin.php", "_blank");

    }
  </script>