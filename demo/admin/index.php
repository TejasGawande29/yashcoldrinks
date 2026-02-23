<?php
session_start();
if (isset($_SESSION["USERNAME"]) && isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] == "admin" || $_SESSION["ROLE"] == "manager")) {
  // User is authenticated
} else {
  header("Location: adminlogin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- taliwindcss -->
  <link rel="stylesheet" href="output.css">

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Tables -->
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">

  <!--Toastr-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <!-- Alpine.js for interactivity -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <title>Dashboard</title>

  <style>
    /* Normal CSS for dark mode */
    body.dark-mode {
      background-color: #1a202c;
      color: #e2e8f0;
    }

    body.dark-mode h1,
    body.dark-mode h2 {
      color: #63b3ed;
      text-shadow: 0 0 5px rgba(99, 179, 237, 0.7);
    }

    body.dark-mode .bg-white {
      background-color: #2d3748 !important;
    }

    body.dark-mode .border-gray-300 {
      border-color: #4a5568 !important;
    }

    body.dark-mode .text-gray-700 {
      color: #a0aec0 !important;
    }

    body.dark-mode .shadow-xl {
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.7) !important;
    }

    body.dark-mode button#themeToggleBtn {
      background-color: #4a5568;
      color: #e2e8f0;
    }

    body.dark-mode button#themeToggleBtn:hover {
      background-color: #718096;
    }

    /* Smooth background and text color transitions */
    body,
    div,
    h1,
    h2,
    ul,
    li,
    button {
      transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Animation from bottom to top on page load */
    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.8s ease forwards;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen text-gray-800 font-sans">

  <section class="max-w-screen-2xl mx-auto p-4 lg:p-6">
    <div class="flex flex-col lg:flex-row gap-6">

      <!-- Sidebar -->
      <?php include 'layouts/sidebar.php'; ?>

      <!-- Main Content -->
      <div class="flex-1 min-w-0 bg-white rounded-2xl shadow-xl p-6 lg:p-8 transition-colors duration-500 ease-in-out fade-in-up">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
              <span class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-500 rounded-xl flex items-center justify-center text-white text-lg">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
              </span>
              Dashboard
            </h1>
            <p class="text-gray-500 mt-1">Welcome back! Here's your stock overview.</p>
          </div>
          <button
            id="themeToggleBtn"
            class="mt-4 sm:mt-0 flex items-center gap-2 bg-gray-100 hover:bg-gray-200 rounded-xl px-4 py-2 text-sm font-medium transition-all">
            <i data-lucide="moon" class="w-4 h-4"></i>
            <span>Dark Mode</span>
          </button>
        </div>

        <!-- Stats Boxes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
          <!-- Total Stock Card -->
          <div class="relative bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-72">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="flex items-center gap-4 mb-4 flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <i data-lucide="package" class="w-6 h-6"></i>
              </div>
              <h2 class="text-lg font-semibold text-gray-800">Total Stock</h2>
            </div>
            <ul id="stock-list" class="space-y-2 text-sm text-gray-600 overflow-y-auto flex-1 pr-2 scrollbar-thin"></ul>
          </div>

          <!-- Placeholder Card 1 - Coming Soon -->
          <div class="relative bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-72 opacity-50">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-green-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="flex items-center gap-4 mb-4 flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
              </div>
              <h2 class="text-lg font-semibold text-gray-800">Today's Sales</h2>
            </div>
            <div class="flex items-center justify-center flex-1">
              <p class="text-gray-400 text-sm italic">🚧 Coming Soon...</p>
            </div>
          </div>

          <!-- Placeholder Card 2 - Coming Soon -->
          <div class="relative bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-72 opacity-50">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-orange-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="flex items-center gap-4 mb-4 flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                <i data-lucide="indian-rupee" class="w-6 h-6"></i>
              </div>
              <h2 class="text-lg font-semibold text-gray-800">Today's Earnings</h2>
            </div>
            <div class="flex items-center justify-center flex-1">
              <p class="text-gray-400 text-sm italic">🚧 Coming Soon...</p>
            </div>
          </div>
        </div>

        <!-- Progress Note -->
        <div class="bg-gradient-to-r from-violet-50 to-purple-50 rounded-2xl border border-violet-200 p-6">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-violet-500/30">
              <i data-lucide="construction" class="w-5 h-5"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Development Progress - 30%</h2>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
            <div class="bg-gradient-to-r from-violet-500 to-purple-500 h-4 rounded-full" style="width: 30%"></div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
            <div class="flex items-center gap-2 text-green-600">
              <i data-lucide="check-circle" class="w-4 h-4"></i>
              <span>Admin Login & Authentication</span>
            </div>
            <div class="flex items-center gap-2 text-green-600">
              <i data-lucide="check-circle" class="w-4 h-4"></i>
              <span>Dashboard with Stock Overview</span>
            </div>
            <div class="flex items-center gap-2 text-green-600">
              <i data-lucide="check-circle" class="w-4 h-4"></i>
              <span>Add Stock Module</span>
            </div>
            <div class="flex items-center gap-2 text-green-600">
              <i data-lucide="check-circle" class="w-4 h-4"></i>
              <span>View Stock Module</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
              <i data-lucide="circle" class="w-4 h-4"></i>
              <span>Sales & Billing (Pending)</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
              <i data-lucide="circle" class="w-4 h-4"></i>
              <span>Expense Management (Pending)</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
              <i data-lucide="circle" class="w-4 h-4"></i>
              <span>Reports & Analytics (Pending)</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
              <i data-lucide="circle" class="w-4 h-4"></i>
              <span>Customer E-Commerce (Pending)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    lucide.createIcons();
  </script>

  <script>
    // Dark mode toggle logic   
    const toggleBtn = document.getElementById("themeToggleBtn");
    const body = document.body;

    // Load theme preference on page load   
    if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
      toggleBtn.innerHTML = '<i data-lucide="sun" class="w-4 h-4"></i><span>Light Mode</span>';
      lucide.createIcons();
    }

    toggleBtn.addEventListener("click", () => {
      body.classList.toggle("dark-mode");
      if (body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
        toggleBtn.innerHTML = '<i data-lucide="sun" class="w-4 h-4"></i><span>Light Mode</span>';
      } else {
        localStorage.setItem("theme", "light");
        toggleBtn.innerHTML = '<i data-lucide="moon" class="w-4 h-4"></i><span>Dark Mode</span>';
      }
      lucide.createIcons();
    });
  </script>

  <script>
    $(document).ready(function() {
      $.ajax({
        url: "functions.php",
        type: "POST",
        data: {
          "RESULT_TYPE": "GET_TOTAL_STOCK_DASHBOARD"
        },
        success: function(res) {
          const jobj = JSON.parse(res);
          var stockList = $("#stock-list");
          stockList.empty();
          jobj.forEach(function(item) {
            stockList.append('<li class="flex items-center justify-between py-1 px-3 bg-blue-50 rounded-lg"><span class="font-medium">' + item[0] + 'ml</span><span class="font-bold text-blue-600">' + item[1] + ' Boxes</span></li>');
          });
        },
        error: function() {
          toastr.error("Failed to load stock data.");
        }
      });
    });
  </script>
</body>

</html>
