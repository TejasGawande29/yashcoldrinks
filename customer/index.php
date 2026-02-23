<?php
/**
 * Customer Website - Home Page
 * YashColdrinks - Customer Portal
 */

// Include configuration
require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home | Yash Coldrinks</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/output.css" />
  <script src="<?= ASSETS_URL ?>/js/jquery.js"></script>
  <!-- Toastr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="<?= ASSETS_URL ?>/js/cart.js"></script>
  
  <style>
    html { scroll-behavior: smooth; }
    
    .reveal {
      opacity: 0;
      transform: translateY(60px) scale(0.96) rotateX(5deg);
      filter: blur(6px) brightness(0.9);
      transition: opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.22, 1, 0.36, 1), filter 0.8s ease-out;
      will-change: opacity, transform, filter;
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0) scale(1) rotateX(0deg);
      filter: blur(0px) brightness(1);
    }

    .reveal.visible:hover {
      transform: translateY(-4px) scale(1.05);
      filter: brightness(1.03) saturate(1.2) drop-shadow(0 8px 18px rgba(0, 0, 0, 0.1));
      transition: transform 0.3s ease, filter 0.3s ease;
      cursor: pointer;
    }

    .reveal:nth-child(1) { transition-delay: 0s; }
    .reveal:nth-child(2) { transition-delay: 0.1s; }
    .reveal:nth-child(3) { transition-delay: 0.2s; }
    .reveal:nth-child(4) { transition-delay: 0.3s; }
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <!-- Hero Section -->
    <section style="background-image: url(<?= ASSETS_URL ?>/images/heroBackground.png);"
      class="bg-center bg-no-repeat bg-cover text-white py-20 sm:py-24 md:py-32">
      <div class="container mx-auto px-6 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-6 drop-shadow-lg">
          Welcome to Yash Coldrinks
        </h1>
        <p class="text-base sm:text-lg md:text-xl mb-8 max-w-2xl mx-auto">
          Your trusted cold drinks wholesale partner. Fast delivery,
          unbeatable prices, and top brands at your fingertips.
        </p>
        <div class="flex justify-center gap-4 flex-wrap">
          <a href="#products" class="bg-white text-red-600 font-semibold px-6 py-3 rounded-full hover:bg-red-100 transition">
            View Products
          </a>
          <a href="#contact" class="bg-yellow-600 text-white font-semibold px-6 py-3 rounded-full hover:bg-yellow-500 transition">
            Contact Us
          </a>
        </div>
      </div>
    </section>

    <!-- Popular Products Section -->
    <section id="products" class="py-16 bg-white">
      <div class="max-w-screen-xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-10">Popular Products</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Product Cards -->
          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a href="pages/product.php?id=1" class="flex flex-col items-center">
              <img src="<?= ASSETS_URL ?>/images/thumsup750.png" alt="ThumsUp Crate" class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <h3 class="text-lg md:text-xl font-semibold text-gray-800 group-hover:underline text-center">ThumsUp Crate (24 Bottles)</h3>
            </a>
            <p class="text-red-600 font-bold mt-2">₹480</p>
            <button onclick='addToCart({ id: 1, name: "ThumsUp Crate (24 Bottles)", price: 480, image: "<?= ASSETS_URL ?>/images/thumsup750.png" })'
              class="mt-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>

          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a href="pages/product.php?id=2">
              <img src="<?= ASSETS_URL ?>/images/sprite750.png" alt="Sprite Crate" class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <div class="p-5">
                <h3 class="text-xl font-semibold text-gray-800 group-hover:underline">Sprite Crate (24 Bottles)</h3>
              </div>
            </a>
            <p class="text-red-600 font-bold mt-2">₹460</p>
            <button onclick='addToCart({ id: 2, name: "Sprite Crate (24 Bottles)", price: 460, image: "<?= ASSETS_URL ?>/images/sprite750.png" })'
              class="mt-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>

          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a href="pages/product.php?id=3">
              <img src="<?= ASSETS_URL ?>/images/cocacola2500.png" alt="Coca Cola Crate" class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <div class="p-5">
                <h3 class="text-xl font-semibold text-gray-800 group-hover:underline">Coca Cola Crate (24 Bottles)</h3>
              </div>
            </a>
            <p class="text-red-600 font-bold mt-2">₹480</p>
            <button onclick='addToCart({ id: 3, name: "Coca Cola Crate (24 Bottles)", price: 480, image: "<?= ASSETS_URL ?>/images/cocacola2500.png" })'
              class="mt-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>

          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a href="pages/product.php?id=4">
              <img src="<?= ASSETS_URL ?>/images/fanta750.png" alt="Fanta Crate" class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <div class="p-5">
                <h3 class="text-xl font-semibold text-gray-800 group-hover:underline">Fanta Crate (24 Bottles)</h3>
              </div>
            </a>
            <p class="text-red-600 font-bold mt-2">₹520</p>
            <button onclick='addToCart({ id: 4, name: "Fanta Crate (24 Bottles)", price: 520, image: "<?= ASSETS_URL ?>/images/fanta750.png" })'
              class="mt-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>
        </div>

        <div class="mt-10">
          <a href="pages/all-products.php" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full transition">
            View All Products
          </a>
        </div>
      </div>
    </section>

    <!-- How to Order Section -->
    <section id="services" class="py-20 bg-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-red-600 mb-4">How to Order</h2>
        <p class="text-gray-600 mb-12 max-w-xl mx-auto">
          We make wholesale ordering simple and fast — from inquiry to doorstep delivery.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img src="<?= ASSETS_URL ?>/icons/browse.png" alt="Browse Icon" class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Browse Products</h3>
            <p class="text-gray-600 mt-2 text-sm">View crates, combos, and availability easily online.</p>
          </div>

          <div class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img src="<?= ASSETS_URL ?>/icons/inquiry.png" alt="Inquiry Icon" class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Place Inquiry</h3>
            <p class="text-gray-600 mt-2 text-sm">Reach out via call or form to confirm price & stock.</p>
          </div>

          <div class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img src="<?= ASSETS_URL ?>/icons/confirm.png" alt="Confirm Icon" class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Confirm Order</h3>
            <p class="text-gray-600 mt-2 text-sm">We finalize quantity, mix, and payment method.</p>
          </div>

          <div class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img src="<?= ASSETS_URL ?>/icons/delivery.png" alt="Delivery Icon" class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Fast Delivery</h3>
            <p class="text-gray-600 mt-2 text-sm">We deliver within 24 hours to your shop or location.</p>
          </div>
        </div>

        <div class="mt-10">
          <a href="#contact" class="bg-red-600 hover:bg-red-700 text-white text-lg font-medium px-8 py-3 rounded-full transition shadow">
            📞 Start an Order
          </a>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gradient-to-b from-yellow-50 to-red-50">
      <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-10">Contact / Inquiry</h2>

        <form id="inquiryForm" class="bg-white p-8 shadow-2xl rounded-xl space-y-6 transition duration-300 reveal">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="block text-gray-700 font-semibold mb-1">Full Name</label>
              <input type="text" id="name" name="name" placeholder="Your full name"
                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 transition" />
            </div>
            <div>
              <label for="email" class="block text-gray-700 font-semibold mb-1">Email Address</label>
              <input type="email" id="email" name="email" placeholder="example@mail.com"
                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 transition" />
            </div>
          </div>

          <div>
            <label for="phone" class="block text-gray-700 font-semibold mb-1">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="e.g., 9876543210"
              class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 transition" />
          </div>

          <div>
            <label for="message" class="block text-gray-700 font-semibold mb-1">Message / Inquiry</label>
            <textarea id="message" name="message" rows="5" placeholder="Your message here..."
              class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 transition resize-none"></textarea>
          </div>

          <button type="submit"
            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition">
            📩 Send Inquiry
          </button>
        </form>
      </div>
    </section>
  </main>

  <?php include 'includes/footer.php'; ?>

  <script>
    // Inquiry Form Submission
    document.getElementById("inquiryForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const phone = document.getElementById("phone").value.trim();
      const message = document.getElementById("message").value.trim();

      if (!name || !email || !phone || !message) {
        toastr.error("Please fill out all fields.", "Incomplete");
        return;
      }

      toastr.success("Your inquiry has been sent!", "Success");
      document.getElementById("inquiryForm").reset();
    });

    // Reveal Animation Observer
    document.addEventListener("DOMContentLoaded", function() {
      const reveals = document.querySelectorAll(".reveal");
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
          } else {
            entry.target.classList.remove("visible");
          }
        });
      }, { threshold: 0.1 });

      reveals.forEach((el) => observer.observe(el));
    });
  </script>
</body>
</html>
