<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !in_array($_SESSION["ROLE"], ["admin", "manager"])) {
  header("Location: ../adminlogin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" x-data="{}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Dashboard</title>

    <!-- TailwindCSS v4 -->
    <link rel="stylesheet" href="output.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- jQuery & DataTables -->
    <script src="../js/jquery.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --warning: #f72585;
            --dark: #1d3557;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7f1 100%);
            min-height: 100vh;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.2);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 16px 16px 0 0;
        }

        .card-sales::before {
            background: linear-gradient(90deg, #ff9a9e 0%, #fad0c4 100%);
        }

        .card-profit::before {
            background: linear-gradient(90deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .card-expenses::before {
            background: linear-gradient(90deg, #ffecd2 0%, #fcb69f 100%);
        }

        .card-cashflow::before {
            background: linear-gradient(90deg, #84fab0 0%, #8fd3f4 100%);
        }

        .glowing-border {
            position: relative;
            border: 1px solid transparent;
        }

        .glowing-border::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff00cc, #3333ff, #00ccff, #ff00cc);
            background-size: 400% 400%;
            z-index: -1;
            border-radius: 16px;
            animation: glowing 20s linear infinite;
            opacity: 0.1;
        }

        @keyframes glowing {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .table-container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            padding: 6px 12px;
            border: 1px solid #ddd;
        }

        .section-title {
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            border-radius: 2px;
            background: var(--primary);
        }

        .section-title.center::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .value-display {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .cashflow-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .cashflow-item:last-child {
            border-bottom: none;
        }

        .pulse {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
            background: #10b981;
        }

        .pulse::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: inherit;
            animation: pulse 2s ease-out infinite;
            z-index: -1;
        }

        @keyframes pulse {
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
    </style>
</head>

<body class="text-gray-800">
    <section class="max-w-screen-2xl mx-auto p-4 md:p-6">
        <div class="grid lg:grid-cols-[18rem_auto] gap-6">
            <?php include 'layouts/sidebar.php'; ?>

            <main class="space-y-8">
                <div class="text-center mb-10" data-aos="fade-down">
                    <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent inline-block">
                        📊 Daily Audit Dashboard
                    </h1>
                    <p class="text-gray-600 mt-2">Track your daily financial performance and transactions</p>
                </div>

                <!-- Financial Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
                    <!-- Today's Sales -->
                    <div class="dashboard-card card-sales p-6 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 font-medium">Today's Sales</h3>
                                <p id="Todays-sell" class="value-display text-yellow-900 mt-3">Loading...</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-xl">
                                <i data-lucide="shopping-bag" class="w-8 h-8 text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500 flex items-center">
                            <span class="pulse"></span>
                            <span>Updated in real-time</span>
                        </div>
                    </div>

                    <!-- Net Profit -->
                    <div class="dashboard-card card-profit p-6 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 font-medium">Net Profit</h3>
                                <p id="net-profit" class="value-display text-green-600 mt-3">Loading...</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-xl">
                                <i data-lucide="trending-up" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500 flex items-center">
                            <span class="pulse"></span>
                            <span>Calculated after expenses</span>
                        </div>
                    </div>

                    <!-- Expenses -->
                    <div class="dashboard-card card-expenses p-6 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 font-medium">Total Expenses</h3>
                                <p id="total-expenses" class="value-display text-red-600 mt-3">Loading...</p>
                            </div>
                            <div class="bg-red-100 p-3 rounded-xl">
                                <i data-lucide="trending-down" class="w-8 h-8 text-red-600"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500">
                            Includes all operational costs
                        </div>
                    </div>

                    <!-- Cash Flow -->
                    <div class="dashboard-card card-cashflow p-6 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 font-medium">Cash Flow</h3>
                                <div class="mt-4 space-y-3">
                                    <div class="cashflow-item">
                                        <span class="text-gray-600 flex items-center">
                                            <i data-lucide="dollar-sign" class="w-4 h-4 mr-2 text-green-500"></i>
                                            Cash:
                                        </span>
                                        <span id="cashflow" class="font-semibold">0</span>
                                    </div>
                                    <div class="cashflow-item">
                                        <span class="text-gray-600 flex items-center">
                                            <i data-lucide="smartphone" class="w-4 h-4 mr-2 text-blue-500"></i>
                                            PhonePe:
                                        </span>
                                        <span id="phonepeflow" class="font-semibold">0</span>
                                    </div>
                                    <div class="cashflow-item">
                                        <span class="text-gray-600 flex items-center">
                                            <i data-lucide="alert-circle" class="w-4 h-4 mr-2 text-amber-500"></i>
                                            Unpaid:
                                        </span>
                                        <span id="unpaidflow" class="font-semibold text-amber-600">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-xl">
                                <i data-lucide="credit-card" class="w-8 h-8 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Lists -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8" data-aos="fade-up" data-aos-delay="100">
                    <!-- Unpaid List -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden glowing-border">
                        <div class="bg-gradient-to-r from-red-50 to-rose-50 px-6 py-4">
                            <h2 class="text-xl font-bold text-red-700 flex items-center">
                                <i data-lucide="alert-triangle" class="w-5 h-5 mr-2 animate-pulse"></i>
                                Unpaid List
                            </h2>
                            <p class="text-sm text-red-600 mt-1">Outstanding payments to collect</p>
                        </div>
                        <div class="p-4">
                            <div class="table-container">
                                <table id="unpaidlist" class="display w-full text-sm" style="width:100%"></table>
                            </div>
                        </div>
                    </div>

                    <!-- PhonePe List -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden glowing-border">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4">
                            <h2 class="text-xl font-bold text-blue-700 flex items-center">
                                <i data-lucide="smartphone" class="w-5 h-5 mr-2"></i>
                                PhonePe Transactions
                            </h2>
                            <p class="text-sm text-blue-600 mt-1">Digital payments received</p>
                        </div>
                        <div class="p-4">
                            <div class="table-container">
                                <table id="phonepelist" class="display w-full text-sm" style="width:100%"></table>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Payments -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden glowing-border">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4">
                            <h2 class="text-xl font-bold text-green-700 flex items-center">
                                <i data-lucide="history" class="w-5 h-5 mr-2"></i>
                                Previous Payments
                            </h2>
                            <p class="text-sm text-green-600 mt-1">Historical payment records</p>
                        </div>
                        <div class="p-4">
                            <div class="overflow-auto max-h-96">
                                <table id="previouspaymentlist" class="display w-full text-sm" style="width:100%"></table>
                            </div>
                        </div>
                    </div>
                    <!-- Stock Payments -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden glowing-border">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4">
                            <h2 class="text-xl font-bold text-yellow-700 flex items-center">
                                <i data-lucide="history" class="w-5 h-5 mr-2"></i>
                                Stock Payments
                            </h2>
                            <p class="text-sm text-green-600 mt-1">Stock payment records</p>
                        </div>
                        <div class="p-4">
                            <div class="overflow-auto max-h-96">
                                <table id="stockpayments" class="display w-full text-sm" style="width:100%"></table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual Summary -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mt-8" data-aos="fade-up" data-aos-delay="150">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Daily Financial Overview</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 flex items-center">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <i data-lucide="arrow-up" class="w-6 h-6 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Avg. Daily Profit</p>
                                <p class="text-xl font-bold text-blue-700">₹2,850</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 flex items-center">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i data-lucide="credit-card" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Efficiency</p>
                                <p class="text-xl font-bold text-green-700">92%</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 flex items-center">
                            <div class="bg-amber-100 p-3 rounded-lg mr-4">
                                <i data-lucide="alert-circle" class="w-6 h-6 text-amber-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pending Collections</p>
                                <p class="text-xl font-bold text-amber-700">₹1,240</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>

    <!-- Get Net profit , Total Expenses -->
    <script>
        $(document).ready(function() {
            // Initialize animations
            AOS.init({
                once: true,
                duration: 600,
                easing: 'ease-out-cubic'
            });

            // Create Lucide icons
            if (window.lucide && lucide.createIcons) {
                lucide.createIcons();
            }

            // Fetch financial data
            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_TOTAL_EXPENSES"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    console.log("Expenses "+res);
                    document.getElementById("total-expenses").innerHTML = "₹" + jobj[0][0];
                },
                error: function() {
                    toastr.error("Failed to load expenses data.");
                }
            });

            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_TODAYS_NETPROFIT"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    console.log("earning data: ");
                    console.log(jobj);
                    document.getElementById('net-profit').innerHTML = "₹" + jobj.netprofit;
                },
                error: function() {
                    toastr.error("Failed to load profit data.");
                }
            });

            // Fetch cash flow data
            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_TODAY_CASH_FLOW_SELL"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    console.log(jobj);
                    document.getElementById("cashflow").innerHTML = "₹" + jobj[0][0]['Cash'];
                    document.getElementById("phonepeflow").innerHTML = "₹" + jobj[1][0]['Phonepe'];
                    document.getElementById("unpaidflow").innerHTML = "₹" + jobj[2][0]['Unpaid'];
                    document.getElementById("Todays-sell").innerHTML = "₹" + jobj[3][0]['sell'];
                },
                error: function() {
                    toastr.error("Failed to load cash flow data.");
                }
            });

            // Fetch transaction lists
            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_UNPAID_LIST"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    new DataTable("#unpaidlist", {
                        columns: [{
                                title: "Counter"
                            },
                            {
                                title: "Bill Amount"
                            },
                            {
                                title: "Paid Amount"
                            }
                        ],
                        data: jobj,
                        responsive: true,
                        pageLength: 5,
                        lengthMenu: [5, 10, 15]
                    });
                },
                error: function() {
                    toastr.error("Failed to load unpaid list.");
                }
            });

            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_PHONEPE_LIST"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    new DataTable("#phonepelist", {
                        columns: [{
                                title: "Counter"
                            },
                            {
                                title: "Amount Paid"
                            }
                        ],
                        data: jobj,
                        responsive: true,
                        pageLength: 5
                    });
                },
                error: function() {
                    toastr.error("Failed to load PhonePe list.");
                }
            });

            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_PREVIOUS_PAYMENT_LIST"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    new DataTable("#previouspaymentlist", {
                        columns: [{
                                title: "Counter"
                            },
                            {
                                title: "BillDate"
                            },
                            {
                                title: "PaymentDate"
                            },
                            {
                                title: "PaymentMode"
                            },
                            {
                                title: "AmountPaid"
                            }
                        ],
                        data: jobj,
                        responsive: true,
                        pageLength: 5
                    });
                },
                error: function() {
                    toastr.error("Failed to load previous payments.");
                }
            });
            $.ajax({
                url: "../functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_STOCK_PAYMENT_LIST"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    new DataTable("#stockpayments", {
                        columns: [{
                                title: "Product"
                            },
                            {
                                title: "Quantity"
                            },
                            {
                                title: "TotalBillAmount"
                            },
                            {
                                title: "PaidAmount"
                            },
                            {
                                title: "PaymentMode"
                            },
                            {
                                title: "PaymentDate"
                            },
                            {
                                title: "Agency"
                            }
                        ],
                        data: jobj,
                        responsive: true,
                        pageLength: 5
                    });
                },
                error: function() {
                    toastr.error("Failed to load previous payments.");
                }
            });
        });
    </script>
</body>

</html>