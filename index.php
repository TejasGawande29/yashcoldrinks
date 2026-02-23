<?php
/**
 * Root Index - Redirect to Customer Portal
 * YashColdrinks
 * 
 * This file redirects users to the new customer portal location
 * Remove this redirect to keep original homepage
 */

// Dynamic redirect that works in both local and production
$base_url = (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http') . '://' . $_SERVER['HTTP_HOST'];
$redirect_path = '/customer/index.php';

header("Location: " . $redirect_path);
exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="dist/output.css" />
  <script src="js/jquery.js"></script>
  <!-- Toastr CSS -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    rel="stylesheet" />
  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="js/cart.js"></script>
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>

  <style>
    .reveal {
      opacity: 0;
      transform: translateY(60px) scale(0.96) rotateX(5deg);
      filter: blur(6px) brightness(0.9);
      transition:
        opacity 0.8s ease-out,
        transform 0.8s cubic-bezier(0.22, 1, 0.36, 1),
        filter 0.8s ease-out;
      will-change: opacity, transform, filter;
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0) scale(1) rotateX(0deg);
      filter: blur(0px) brightness(1);
    }

    /* Hover effect: sleek upscale and light elevation */
    .reveal.visible:hover {
      transform: translateY(-4px) scale(1.05);
      filter: brightness(1.03) saturate(1.2) drop-shadow(0 8px 18px rgba(0, 0, 0, 0.1));
      transition:
        transform 0.3s ease,
        filter 0.3s ease;
      cursor: pointer;
    }

    /* Optional staggered reveal for children boxes */
    .reveal:nth-child(1) {
      transition-delay: 0s;
    }

    .reveal:nth-child(2) {
      transition-delay: 0.1s;
    }

    .reveal:nth-child(3) {
      transition-delay: 0.2s;
    }

    .reveal:nth-child(4) {
      transition-delay: 0.3s;
    }
  </style>

  <!--  <style> More Advancew Reveal Animation
.reveal {
  opacity: 0;
  transform: translateY(120px) scale(0.94) rotateX(8deg);
  filter: blur(10px) brightness(0.8);
  transition:
    opacity 1s ease-out,
    transform 1s cubic-bezier(0.22, 1, 0.36, 1),
    filter 1s ease-out;
  will-change: opacity, transform, filter;
}

.reveal.visible {
  opacity: 1;
  transform: translateY(0) scale(1) rotateX(0deg);
  filter: blur(0px) brightness(1);
}

/* Optional staggered delay for a cascade effect */
.reveal:nth-child(1) { transition-delay: 0s; }
.reveal:nth-child(2) { transition-delay: 0.15s; }
.reveal:nth-child(3) { transition-delay: 0.3s; }
.reveal:nth-child(4) { transition-delay: 0.45s; }

/* Hover interaction remains enhanced */
.reveal.visible:hover {
  transform: translateY(-8px) scale(1.06);
  filter: brightness(1.05) saturate(1.2) drop-shadow(0 12px 24px rgba(0, 0, 0, 0.12));
  transition: transform 0.3s ease, filter 0.3s ease;
  cursor: pointer;
}

</style> -->
</head>

<body>
  <header>
    <nav class="bg-gradient-to-r from-purple-800 via-purple-700 to-purple-900 text-white px-6 py-4 shadow-lg transition-all duration-500 sticky top-0 z-50">
      <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Logo -->
        <div class="flex items-center gap-2 animate-fade-in">
          <img class="w-24 h-auto rounded-xl shadow-lg hover:scale-105 transition-transform duration-300" src="image/logo.png" alt="Logo" />
        </div>

        <!-- Navigation Links -->
        <ul class="flex flex-wrap gap-3 md:gap-6 items-center text-lg md:text-xl font-medium">
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Home</a></li>
          <li><a href="all-products.php" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">All Products</a></li>
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Offers</a></li>
          <li><a href="#" class="hover:bg-white/25 px-4 py-2 rounded transition duration-300 hover:scale-105">Home Delivery</a></li>
          <li>
            <a href="#" class="hover:bg-white/10 px-4 py-2 rounded flex items-center gap-2 transition duration-300 hover:scale-105">
              <i class="fas fa-user-cog text-red-400"></i><span>Manage Profile</span>
            </a>
          </li>
          <li>
            <a href="#" class="relative hover:bg-white/10 px-4 py-2 rounded transition duration-300 hover:scale-105">
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
  <!-- okk -->

  <main>
    <!-- Hero Section -->
    <section style="background-image: url(image/heroBackground.png);"
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
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-10">
          Popular Products
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Product Card Example -->
          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a href="product-details.html?item=cocacola" class="flex flex-col items-center">
              <img
                src="image/thumsup750.png"
                alt="ThumsUp Crate"
                class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <h3 class="text-lg md:text-xl font-semibold text-gray-800 group-hover:underline text-center">
                ThumsUp Crate (24 Bottles)
              </h3>
            </a>
            <p class="text-red-600 font-bold mt-2">₹480</p>
            <button
              onclick='addToCart({ id: "product-01", name: "ThumsUp Crate (24 Bottles)", price: 480, image: "image/cocacola2500.png" })'
              class="mt-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>

          <!-- Repeat the above card for other products by replacing data -->

          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a
              href="product-details.html?item=sprite">
              <img
                src="image/sprite750.png"
                alt="Sprite Crate"
                class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <div class="p-5">
                <h3
                  class="text-xl font-semibold text-gray-800 group-hover:underline">
                  Sprite Crate (24 Bottles)
                </h3>

              </div>
            </a>
            <p class="text-red-600 font-bold mt-2">₹460</p>
            <button onclick='addToCart({
                  id: "product-02",
                  name: "Sprite Crate (24 Bottles)",
                  price: 460,
                  image: "image/sprite750.png"
                })' class="absolute bottom-4 right-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>


          <!-- Repeat for other products -->
          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a
              href="product-details.html?item=sprite">
              <img
                src="image/cocacola2500.png"
                alt="Sprite Crate"
                class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <div class="p-5">
                <h3
                  class="text-xl font-semibold text-gray-800 group-hover:underline">
                  Coca Cola Crate (24 Bottles)
                </h3>

              </div>
            </a>
            <p class="text-red-600 font-bold mt-2">₹480</p>
            <button onclick='addToCart({
              id: "product-03",
              name: "Coca Cola Crate (24 Bottles)",
              price: 480,
              image: "image/sprite750.png"
            })' class="absolute bottom-4 right-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>


          <!-- Repeat for other products -->
          <div class="group bg-gray-50 shadow rounded-lg overflow-hidden transition hover:shadow-xl p-4 flex flex-col items-center justify-between reveal">
            <a
              href="product-details.html?item=sprite">
              <img
                src="image/fanta750.png"
                alt="Sprite Crate"
                class="w-full max-w-[160px] h-auto object-contain mx-auto" />
              <div class="p-5">
                <h3
                  class="text-xl font-semibold text-gray-800 group-hover:underline">
                  Fanta Crate (24 Bottles)
                </h3>

              </div>
            </a>
            <p class="text-red-600 font-bold mt-2">₹520</p>
            <button onclick='addToCart({
                  id: "product-04",
                  name: "Fanta Crate (24 Bottles)",
                  price: 520,
                  image: "image/fanta750.png"
                })'
              class="absolute bottom-4 right-4 bg-red-500 text-white px-4 py-2 text-sm rounded-full hover:bg-red-600 transition">
              🛒 Add to Cart
            </button>
          </div>
          <!-- Continue with other items similarly -->
          <!-- ... -->
        </div>

        <!-- View All Button -->
        <div class="mt-10">
          <a
            href="all-products.php"
            class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full transition">
            View All Products
          </a>
        </div>
      </div>
    </section>

    <section id="services" class="py-20 bg-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-red-600 mb-4">How to Order</h2>
        <p class="text-gray-600 mb-12 max-w-xl mx-auto">
          We make wholesale ordering simple and fast — from inquiry to
          doorstep delivery.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Step 1 -->
          <div
            class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img
                src="icons/browse.png"
                alt="Browse Icon"
                class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">
              Browse Products
            </h3>
            <p class="text-gray-600 mt-2 text-sm">
              View crates, combos, and availability easily online.
            </p>
          </div>

          <!-- Step 2 -->
          <div
            class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img
                src="icons/inquiry.png"
                alt="Inquiry Icon"
                class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Place Inquiry</h3>
            <p class="text-gray-600 mt-2 text-sm">
              Reach out via call or form to confirm price & stock.
            </p>
          </div>

          <!-- Step 3 -->
          <div
            class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img
                src="icons/confirm.png"
                alt="Confirm Icon"
                class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Confirm Order</h3>
            <p class="text-gray-600 mt-2 text-sm">
              We finalize quantity, mix, and payment method.
            </p>
          </div>

          <!-- Step 4 -->
          <div
            class="bg-yellow-50 border-t-4 border-red-500 rounded-xl shadow p-6 hover:shadow-lg transition reveal">
            <div class="mb-4">
              <img
                src="icons/delivery.png"
                alt="Delivery Icon"
                class="mx-auto w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Fast Delivery</h3>
            <p class="text-gray-600 mt-2 text-sm">
              We deliver within 24 hours to your shop or location.
            </p>
          </div>
        </div>

        <!-- CTA Button -->
        <div class="mt-10">
          <a
            href="#contact"
            class="bg-red-600 hover:bg-red-700 text-white text-lg font-medium px-8 py-3 rounded-full transition shadow">
            📞 Start an Order
          </a>
        </div>
      </div>
    </section>
    <!-- contact Inquiry section -->
    <section
      id="contact"
      class="py-20 bg-gradient-to-b from-yellow-50 to-red-50">
      <div class="container mx-auto px-4 max-w-3xl animate-fade-in-up">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-10">
          Contact / Inquiry
        </h2>

        <form
          id="inquiryForm"
          class="bg-white p-8 shadow-2xl rounded-xl space-y-6 transition duration-300 reveal">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative">
              <label for="name" class="block text-gray-700 font-semibold mb-1">Full Name</label>
              <input
                type="text"
                id="name"
                name="name"
                placeholder="Your full name"
                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:shadow-lg transition duration-300" />
            </div>
            <div class="relative">
              <label
                for="email"
                class="block text-gray-700 font-semibold mb-1">Email Address</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="example@mail.com"
                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:shadow-lg transition duration-300" />
            </div>
          </div>

          <div>
            <label for="phone" class="block text-gray-700 font-semibold mb-1">Phone Number</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              placeholder="e.g., 9876543210"
              class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:shadow-lg transition duration-300" />
          </div>

          <div>
            <label
              for="message"
              class="block text-gray-700 font-semibold mb-1">Message / Inquiry</label>
            <textarea
              id="message"
              name="message"
              rows="5"
              placeholder="Your message here..."
              class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:shadow-lg transition duration-300 resize-none"></textarea>
          </div>

          <button
            type="submit"
            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            📩 Send Inquiry
          </button>
        </form>
      </div>
    </section>
  </main>
  <footer class="bg-slate-800 border-t border-gray-300 px-10 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-white text-lg">

      <!-- Info Section -->
      <div class="reveal">
        <h4 class="text-2xl font-bold mb-2">Pratiksha Agency</h4>
        <p class="mb-2">
          Ased do eiusm tempor incidi ut labore et dolore magnaian aliqua. Ut enim ad minim veniam.
        </p>
        <p class="flex items-center gap-2">
          <img src="icons/emailicon.png" class="w-4 h-4" alt="Email Icon" />
          yashcoldrinks@gmail.com
        </p>
        <p class="flex items-center gap-2">
          <img src="icons/phoneicon.png" class="w-4 h-4" alt="Phone Icon" />
          9405416771
        </p>
      </div>

      <!-- About Section -->
      <div class="reveal">
        <h5 class="text-md font-semibold mb-2">ABOUT DEVLOON</h5>
        <ul class="space-y-1">
          <li><a href="#" class="hover:text-red-500">About Us</a></li>
          <li><a href="#" class="hover:text-red-500">Career</a></li>
          <li><a href="#" class="hover:text-red-500">Terms of Service</a></li>
          <li><a href="#" class="hover:text-red-500">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Brands Section -->
      <div class="reveal">
        <h5 class="text-md font-semibold mb-2">TOP BRANDS</h5>
        <ul class="space-y-1">
          <li>ThumsUp</li>
          <li>Sprite</li>
          <li>Campa</li>
          <li>Frooti</li>
          <li>Lassi</li>
          <li>Jeera</li>
          <li>Slice</li>
        </ul>
      </div>

      <!-- Newsletter Section -->
      <div class="reveal">
        <h5 class="text-md font-semibold mb-2">Subscribe to get latest news and updates</h5>
        <div class="flex items-center mt-2">
          <input type="email" id="newsletterEmail" placeholder="Your Email"
            class="w-full px-3 py-2 rounded-l bg-gray-100 text-gray-800 text-sm focus:outline-none" />
          <button onclick="subscribeNewsletter()"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-r text-sm font-semibold">
            Subscribe
          </button>
        </div>
        <p id="subscribeMessage" class="text-sm mt-2 text-green-400"></p>
      </div>
    </div>

    <!-- Divider -->
    <hr class="my-6 border-gray-300" />

    <!-- Bottom Copyright -->
    <div class="flex flex-col md:flex-row justify-between items-center text-xs text-gray-600">
      <p class="text-lg subpixel-antialiased font-semibold text-red-300 ">© 2025 Yash Coldrinks. Designed & Developed by Tejas Gawande.</p>
      <div class="flex gap-3 mt-3 md:mt-0">
        <a href="https://facebook.com" target="_blank"><img src="icons/fblogo.png" alt="Facebook" class="w-5 h-5" /></a>
        <a href="https://www.instagram.com/mh27_thunder_boy/" target="_blank"><img src="icons/instalogo.png" alt="Instagram" class="w-5 h-5" /></a>
        <a href="https://twitter.com" target="_blank"><img src="icons/twtlogo.png" alt="Twitter" class="w-5 h-5" /></a>
        <a href="https://youtube.com/@Yashwalivakar2.0" target="_blank"><img src="icons/ytlogo.webp" alt="YouTube" class="w-5 h-5" /></a>
      </div>
    </div>
  </footer>





  <script>
    function openAdminlogin() {
      // Open the admin login page in a new tab
      window.open("admin/adminlogin.php", "_blank");

    }

    function subscribeNewsletter() {
      const email = document.getElementById("newsletterEmail").value;
      if (email) {
        document.getElementById("subscribeMessage").innerText =
          "Subscribed successfully!";
        toastr.success("Subscribed successfully!", "Success");
      } else {
        toastr.error("Please enter a valid email address.", "Error");
      }
    }
  </script>
  <script>
    document
      .getElementById("inquiryForm")
      .addEventListener("submit", function(e) {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const message = document.getElementById("message").value.trim();

        if (!name || !email || !phone || !message) {
          toastr.error("Please fill out all fields.", "Incomplete");
          return;
        }

        // You can send this data using fetch() or store it in future
        // For now, we just simulate a success response
        toastr.success("Your inquiry has been sent!", "Success");

        // Reset the form
        document.getElementById("inquiryForm").reset();
      });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const reveals = document.querySelectorAll(".reveal");

      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("visible");
            } else {
              entry.target.classList.remove("visible"); // allow repeat
            }
          });
        }, {
          threshold: 0.1, // trigger when 10% visible
        }
      );

      reveals.forEach((el) => {
        observer.observe(el);
      });
    });
  </script>

  <script>
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        } else {
          entry.target.classList.remove('visible');
        }
      });
    });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  </script>

</body>
</html>