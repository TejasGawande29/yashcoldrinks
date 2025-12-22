<?php
session_start();
if (isset($_SESSION["USERNAME"]) && isset($_SESSION["PASSWORD"]) && $_SESSION["ROLE"] == "admin") {
} else {
  header("Location: adminlogin.php");
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
  <script src="../js/jquery.js"></script>

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

<body class="bg-gradient-to-br from-sky-100 to-white min-h-screen text-gray-800 font-sans">

  <section class="max-w-screen-2xl mx-auto p-4">
    <div class="grid lg:grid-cols-[18rem_auto] gap-6">

      <!-- Sidebar -->
      <?php include 'layouts/sidebar.php'; ?>



      <!-- Main Content -->
      <div class="bg-white rounded-3xl shadow-2xl p-8 transition-colors duration-500 ease-in-out fade-in-up">
        <h1 class="text-4xl font-extrabold mb-8 text-sky-700 drop-shadow-md">
          📊 Dashboard
        </h1>
        <!-- Add this toggle button somewhere appropriate, e.g., top right corner -->
        <button
          id="themeToggleBtn"
          class=" max-sm:text-[10px] fixed top-4 right-4 z-50 bg-gray-200 rounded-full shadow hover:bg-gray-300 transition
         px-3 py-1 text-xs
         sm:px-4 sm:py-2 sm:text-sm">
          🌙 Dark Mode
        </button>







        <!-- Stats Boxes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="relative bg-gradient-to-r from-white via-sky-100 to-sky-200 border border-sky-300 rounded-2xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 hover:scale-[1.03] transition-all duration-400 ease-in-out">
            <h2 class="text-xl font-semibold text-sky-800 mb-4 tracking-wide drop-shadow-sm">
              📦 Total Available Stock
            </h2>
            <ul id="stock-list" class="list-disc pl-6 text-base text-gray-700 space-y-1 leading-relaxed"></ul>
          </div>

          <div class="relative bg-gradient-to-r from-white via-green-100 to-green-200 border border-green-300 rounded-2xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 hover:scale-[1.03] transition-all duration-400 ease-in-out">
            <h2 class="text-xl font-semibold text-green-800 mb-4 tracking-wide drop-shadow-sm">
              🧾 Today's Sell
            </h2>
            <ul id="todaySell" class="list-disc pl-6 text-base text-gray-700 space-y-1 leading-relaxed"></ul>
          </div>

          <div class="relative bg-gradient-to-r from-white via-yellow-100 to-yellow-200 border border-yellow-300 rounded-2xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 hover:scale-[1.03] transition-all duration-400 ease-in-out">
            <h2 id="earningHeading" class="text-xl font-semibold text-yellow-800 mb-4 tracking-wide drop-shadow-sm">
              💰 Today's Earning
            </h2>
            <ul id="todayearning" class="list-disc pl-6 text-base text-gray-700 space-y-1 leading-relaxed"></ul>
          </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-3xl border border-gray-300 shadow-xl mt-12 p-8 transition-colors duration-500 ease-in-out">
          <h2 class="text-2xl font-extrabold mb-6 text-gray-900 tracking-tight drop-shadow-md">
            📈 Monthly Sales & Earnings
          </h2>
          <canvas id="myChart" class="w-full h-[380px] rounded-xl shadow-md ring-1 ring-gray-200"></canvas>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Dark mode toggle logic   
    const toggleBtn = document.getElementById("themeToggleBtn");
    const body = document.body;

    // Load theme preference on page load   
    if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
      toggleBtn.textContent = "☀️ Light Mode";
    }

    toggleBtn.addEventListener("click", () => {
      body.classList.toggle("dark-mode");
      if (body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
        toggleBtn.textContent = "☀️ Light Mode";
      } else {
        localStorage.setItem("theme", "light");
        toggleBtn.textContent = "🌙 Dark Mode";
      }
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
            stockList.append("<li>" + item[0] + "ml" + "==>" + "<strong>" + item[1] + "</strong>" + " Boxes" + "</li>");
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
            todaySell.append("<li>" + item[0] + "ml" + "==>" + "<strong>" + item[1] + "</strong>" + " Boxes" + "</li>");
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
          earningHeading.innerHTML = "Today's Earning:<span style='color:green; font-weight: bold;'>(" + jobj[0][0] + "Rs)</span>"; // Update the heading with the sum of earnings          

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
            todaySell.append("<li>" + jobj[i][0] + "ml" + "==>" + "<strong>" + jobj[i][1] + "</strong>" + " Rs" + "</li>");
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