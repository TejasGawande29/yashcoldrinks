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
  <script src="/YashColdrinks/assets/js/jquery.js"></script>

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

  <!-- Fingerprint Auth -->
  <script src="js/fingerprint.js"></script>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
      /* lighter blue for headings */
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
            <p class="text-gray-500 mt-1">Welcome back! Here's your business overview.</p>
          </div>
          <button
            id="themeToggleBtn"
            class="mt-4 sm:mt-0 flex items-center gap-2 bg-gray-100 hover:bg-gray-200 rounded-xl px-4 py-2 text-sm font-medium transition-all">
            <i data-lucide="moon" class="w-4 h-4"></i>
            <span>Dark Mode</span>
          </button>
        </div>

        <!-- Fingerprint Setup Banner -->
        <div id="fingerprintBanner" class="hidden mb-6 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl p-5 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
          <div class="absolute right-0 top-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/>
                  <path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/>
                  <path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/>
                  <path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/>
                  <path d="M8.65 22c.21-.66.45-1.32.57-2"/>
                  <path d="M14 13.12c0 2.38 0 6.38-1 8.88"/>
                  <path d="M2 16h.01"/>
                  <path d="M21.8 16c.2-2 .131-5.354 0-6"/>
                  <path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/>
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-bold">Enable Fingerprint Login</h3>
                <p class="text-emerald-100 text-sm">Skip typing passwords — login with just your fingerprint next time!</p>
              </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
              <button onclick="setupFingerprint()" id="setupFpBtn"
                class="bg-white text-emerald-600 hover:bg-emerald-50 font-semibold px-5 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-lg text-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/>
                  <path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/>
                  <path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/>
                  <path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/>
                </svg>
                Setup Now
              </button>
              <button onclick="dismissFpBanner()" class="text-white/70 hover:text-white p-2 hover:bg-white/10 rounded-lg transition-colors" title="Dismiss">
                <i data-lucide="x" class="w-5 h-5"></i>
              </button>
            </div>
          </div>
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

          <!-- Today's Sell Card -->
          <div class="relative bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-72">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-green-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="flex items-center gap-4 mb-4 flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
              </div>
              <h2 class="text-lg font-semibold text-gray-800">Today's Sales</h2>
            </div>
            <ul id="todaySell" class="space-y-2 text-sm text-gray-600 overflow-y-auto flex-1 pr-2 scrollbar-thin"></ul>
          </div>

          <!-- Today's Earning Card -->
          <div class="relative bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-72">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-orange-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="flex items-center gap-4 mb-4 flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                <i data-lucide="indian-rupee" class="w-6 h-6"></i>
              </div>
              <h2 id="earningHeading" class="text-lg font-semibold text-gray-800">Today's Earnings</h2>
            </div>
            <ul id="todayearning" class="space-y-2 text-sm text-gray-600 overflow-y-auto flex-1 pr-2 scrollbar-thin"></ul>
          </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-6 transition-colors duration-500 ease-in-out">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-violet-500/30">
              <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Monthly Sales & Earnings</h2>
          </div>
          <canvas id="myChart" class="w-full h-[350px] rounded-xl"></canvas>
        </div>
      </div>
    </div>
  </section>

  <script>
    lucide.createIcons();

    // ─── Fingerprint Setup Banner ─────────────────────────────
    (async function() {
      // Only show if browser supports fingerprint and user hasn't dismissed it
      if (typeof FingerprintAuth === 'undefined' || !FingerprintAuth.isSupported()) return;
      
      const available = await FingerprintAuth.isPlatformAvailable();
      if (!available) return;

      // Check if user dismissed the banner
      if (localStorage.getItem('fp_banner_dismissed') === 'true') return;

      // Check if user already has fingerprints registered
      try {
        const creds = await FingerprintAuth.getCredentials();
        if (creds.credentials && creds.credentials.length > 0) return; // Already registered
      } catch(e) { /* ignore */ }

      // Show the banner
      document.getElementById('fingerprintBanner').classList.remove('hidden');
    })();

    async function setupFingerprint() {
      const btn = document.getElementById('setupFpBtn');
      const originalHTML = btn.innerHTML;
      btn.innerHTML = '<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Scanning...';
      btn.disabled = true;

      try {
        const result = await FingerprintAuth.register('My Device');
        if (result.success) {
          toastr.success('Fingerprint registered! You can now login with fingerprint.', 'Success', {timeOut: 5000});
          document.getElementById('fingerprintBanner').innerHTML = `
            <div class="flex items-center gap-4 p-2">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
              </div>
              <div>
                <h3 class="text-lg font-bold">Fingerprint Registered!</h3>
                <p class="text-emerald-100 text-sm">Next time, you can login by just scanning your fingerprint.</p>
              </div>
            </div>
          `;
          setTimeout(() => {
            document.getElementById('fingerprintBanner').classList.add('hidden');
          }, 5000);
        } else {
          toastr.error(result.error || 'Registration failed');
          btn.innerHTML = originalHTML;
          btn.disabled = false;
        }
      } catch (err) {
        toastr.error(err.message);
        btn.innerHTML = originalHTML;
        btn.disabled = false;
      }
    }

    function dismissFpBanner() {
      localStorage.setItem('fp_banner_dismissed', 'true');
      document.getElementById('fingerprintBanner').classList.add('hidden');
    }
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
          console.log(jobj[0]);

          var stockList = $("#stock-list");
          stockList.empty(); // Clear existing items           
          jobj.forEach(function(item) {
            stockList.append('<li class="flex items-center justify-between py-1 px-3 bg-blue-50 rounded-lg"><span class="font-medium">' + item[0] + 'ml</span><span class="font-bold text-blue-600">' + item[1] + ' Boxes</span></li>');
          });

        },
        error: function() {
          toastr.error("Failed to load stock data.");
        }
      });

      $.ajax({
        url: "functions.php",
        type: "POST",
        data: {
          "RESULT_TYPE": "GET_TODAY_SELL"
        },
        success: function(res) {
          const jobj = JSON.parse(res);
          console.log(jobj);

          const todaySell = $("#todaySell");
          todaySell.empty();
          jobj.forEach(function(item) {
            todaySell.append('<li class="flex items-center justify-between py-1 px-3 bg-emerald-50 rounded-lg"><span class="font-medium">' + item[0] + 'ml</span><span class="font-bold text-emerald-600">' + item[1] + ' Boxes</span></li>');
          });

        },
        error: function() {
          toastr.error("Failed to load stock data.");
        }
      });

      $.ajax({
        url: "functions.php",
        type: "POST",
        data: {
          "RESULT_TYPE": "GET_SUM_EARNING"
        },
        success: function(res) {
          const jobj = JSON.parse(res);
          console.log("sum data: ");
          console.log(jobj);
          const totalEarning = jobj[0][0] || 0;
          document.getElementById("earningHeading").innerHTML = 'Today\'s Earnings <span class="text-emerald-500 font-bold">(₹' + totalEarning + ')</span>';

        },
        error: function() {
          toastr.error("Failed to load stock data.");
        }
      });

      $.ajax({
        url: "functions.php",
        type: "POST",
        data: {
          "RESULT_TYPE": "GET_TODAY_EARNING"
        },
        success: function(res) {
          const jobj = JSON.parse(res);
          console.log("earning data: ");
          console.log(jobj[0]);

          const todaySell = $("#todayearning");
          todaySell.empty();
          for (let i = 0; i < jobj.length; i++) {
            todaySell.append('<li class="flex items-center justify-between py-1 px-3 bg-amber-50 rounded-lg"><span class="font-medium">' + jobj[i][0] + 'ml</span><span class="font-bold text-amber-600">₹' + jobj[i][1] + '</span></li>');
          }
        },
        error: function() {
          toastr.error("Failed to load stock data.");
        }
      });
    });
  </script>

  <!-- Chart Section -->
  <script>
    $.ajax({
      url: "functions.php",
      type: "POST",
      data: {
        "RESULT_TYPE": "GET_DATA_FOR_CHART"
      },
      success: function(res) {
        const jobj = JSON.parse(res); // Format: [["Jan 2025", 20, 3000], ...]          

        const labels = jobj.map(item => item[0]); // Month         
        const boxesSold = jobj.map(item => item[1]); // Quantity         
        const earnings = jobj.map(item => item[2]); // Earnings          

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
                label: 'Boxes Sold',
                data: boxesSold,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
              },
              {
                label: 'Earnings (Rs)',
                data: earnings,
                type: 'line',
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
                yAxisID: 'y1'
              }
            ]
          },
          options: {
            responsive: true,
            interaction: {
              mode: 'index',
              intersect: false
            },
            plugins: {
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const label = context.dataset.label || '';
                    const value = context.raw;
                    if (label === 'Earnings (Rs)') {
                      return `${label}: ₹${value}`;
                    }
                    return `${label}: ${value} boxes`;
                  }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                position: 'left',
                title: {
                  display: true,
                  text: 'Boxes Sold'
                }
              },
              y1: {
                beginAtZero: true,
                position: 'right',
                grid: {
                  drawOnChartArea: false
                },
                title: {
                  display: true,
                  text: 'Earnings (Rs)'
                }
              }
            }
          }
        });
      },
      error: function() {
        toastr.error("Failed to load chart data.");
      }
    });
  </script>
</body>

</html>