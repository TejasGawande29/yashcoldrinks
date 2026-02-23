<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !in_array($_SESSION["ROLE"], ["admin", "manager"])) {
  header("Location: adminlogin.php");
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
    <script src="/YashColdrinks/assets/js/jquery.js"></script>
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

<body class="text-gray-800 bg-gradient-to-br from-slate-50 to-slate-100">
    <section class="max-w-screen-2xl mx-auto p-4 lg:p-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php include 'layouts/sidebar.php'; ?>

            <main class="flex-1 min-w-0 bg-white rounded-2xl shadow-xl p-6 lg:p-8 space-y-8">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                  <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
                      <span class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                        <i data-lucide="file-search" class="w-5 h-5"></i>
                      </span>
                      Audit Dashboard
                    </h1>
                    <p id="filterLabel" class="text-gray-500 mt-1 ml-13">Showing: Today's financial data</p>
                  </div>
                  
                  <!-- Time Filter -->
                  <div class="flex flex-wrap items-center gap-3">
                    <select id="filterType" onchange="handleFilterChange()" class="px-4 py-2 border-2 border-gray-200 rounded-xl bg-white focus:border-indigo-500 focus:outline-none transition-all text-sm font-medium">
                      <option value="today">Today</option>
                      <option value="yesterday">Yesterday</option>
                      <option value="thisWeek">This Week</option>
                      <option value="lastWeek">Last Week</option>
                      <option value="thisMonth">This Month</option>
                      <option value="lastMonth">Last Month</option>
                      <option value="thisYear">This Year</option>
                      <option value="custom">Custom Range</option>
                    </select>
                    
                    <div id="customDateRange" class="hidden flex items-center gap-2">
                      <input type="date" id="startDate" class="px-3 py-2 border-2 border-gray-200 rounded-xl bg-white focus:border-indigo-500 focus:outline-none text-sm">
                      <span class="text-gray-400">to</span>
                      <input type="date" id="endDate" class="px-3 py-2 border-2 border-gray-200 rounded-xl bg-white focus:border-indigo-500 focus:outline-none text-sm">
                    </div>
                    
                    <button onclick="refreshAuditData()" class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-4 py-2 rounded-xl font-medium hover:shadow-lg transition-all flex items-center gap-2">
                      <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                      Refresh
                    </button>
                  </div>
                </div>
                <script>lucide.createIcons();</script>

                <!-- Financial Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6" data-aos="fade-up">
                    <!-- Total Sales -->
                    <div class="dashboard-card card-sales p-6 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 id="salesLabel" class="text-gray-600 font-medium">Total Sales</h3>
                                <p id="Todays-sell" class="value-display text-yellow-900 mt-3">Loading...</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-xl">
                                <i data-lucide="shopping-bag" class="w-8 h-8 text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500 flex items-center">
                            <span class="pulse"></span>
                            <span id="salesSubLabel">Updated in real-time</span>
                        </div>
                    </div>

                    <!-- Net Profit -->
                    <div class="dashboard-card card-profit p-6 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 id="profitLabel" class="text-gray-600 font-medium">Net Profit</h3>
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
                            <div class="flex justify-between text-xs">
                                <span>Operating: <span id="operating-exp">₹0</span></span>
                                <span>Salary: <span id="salary-exp">₹0</span></span>
                            </div>
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
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6 mt-6" data-aos="fade-up" data-aos-delay="100">
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
                                <p id="avgDailyProfit" class="text-xl font-bold text-blue-700">₹0</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 flex items-center">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i data-lucide="credit-card" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Efficiency</p>
                                <p id="paymentEfficiency" class="text-xl font-bold text-green-700">0%</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 flex items-center">
                            <div class="bg-amber-100 p-3 rounded-lg mr-4">
                                <i data-lucide="alert-circle" class="w-6 h-6 text-amber-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pending Collections</p>
                                <p id="pendingCollections" class="text-xl font-bold text-amber-700">₹0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>

    <!-- Get Net profit , Total Expenses -->
    <script>
        // DataTable instances for destruction/recreation
        let unpaidTable, phonePeTable, prevPaymentTable, stockPaymentTable;
        
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
            
            // Set default dates for custom range
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('startDate').value = today;
            document.getElementById('endDate').value = today;

            // Initial load
            refreshAuditData();
        });
        
        // Handle filter type change
        function handleFilterChange() {
            const filterType = document.getElementById('filterType').value;
            const customRange = document.getElementById('customDateRange');
            
            if (filterType === 'custom') {
                customRange.classList.remove('hidden');
            } else {
                customRange.classList.add('hidden');
                refreshAuditData();
            }
        }
        
        // Get filter dates based on selection
        function getFilterDates() {
            const filterType = document.getElementById('filterType').value;
            const today = new Date();
            let startDate, endDate;
            
            switch(filterType) {
                case 'today':
                    startDate = endDate = formatDate(today);
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    startDate = endDate = formatDate(yesterday);
                    break;
                case 'thisWeek':
                    const weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());
                    startDate = formatDate(weekStart);
                    endDate = formatDate(today);
                    break;
                case 'lastWeek':
                    const lastWeekEnd = new Date(today);
                    lastWeekEnd.setDate(today.getDate() - today.getDay() - 1);
                    const lastWeekStart = new Date(lastWeekEnd);
                    lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
                    startDate = formatDate(lastWeekStart);
                    endDate = formatDate(lastWeekEnd);
                    break;
                case 'thisMonth':
                    startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
                    endDate = formatDate(today);
                    break;
                case 'lastMonth':
                    const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                    startDate = formatDate(lastMonth);
                    endDate = formatDate(lastMonthEnd);
                    break;
                case 'thisYear':
                    startDate = formatDate(new Date(today.getFullYear(), 0, 1));
                    endDate = formatDate(today);
                    break;
                case 'custom':
                    startDate = document.getElementById('startDate').value;
                    endDate = document.getElementById('endDate').value;
                    break;
                default:
                    startDate = endDate = formatDate(today);
            }
            
            return { startDate, endDate, filterType };
        }
        
        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }
        
        // Update filter label
        function updateFilterLabel(filterType, startDate, endDate) {
            const labels = {
                'today': "Today's",
                'yesterday': "Yesterday's",
                'thisWeek': "This Week's",
                'lastWeek': "Last Week's",
                'thisMonth': "This Month's",
                'lastMonth': "Last Month's",
                'thisYear': "This Year's",
                'custom': `${startDate} to ${endDate}`
            };
            
            const label = labels[filterType] || "Today's";
            const periodName = filterType === 'custom' ? 'Period' : label.replace("'s", "");
            
            document.getElementById('filterLabel').textContent = `Showing: ${label} financial data`;
            document.getElementById('salesLabel').textContent = `${periodName} Sales`;
            document.getElementById('profitLabel').textContent = `${periodName} Net Profit`;
            document.getElementById('salesSubLabel').textContent = filterType === 'today' ? 'Updated in real-time' : `From ${startDate} to ${endDate}`;
        }
        
        // Main refresh function
        function refreshAuditData() {
            const { startDate, endDate, filterType } = getFilterDates();
            
            // Validate custom dates
            if (filterType === 'custom' && (!startDate || !endDate)) {
                toastr.warning('Please select both start and end dates');
                return;
            }
            
            updateFilterLabel(filterType, startDate, endDate);
            
            // Show loading state
            document.getElementById('total-expenses').innerHTML = '<span class="animate-pulse">Loading...</span>';
            document.getElementById('net-profit').innerHTML = '<span class="animate-pulse">Loading...</span>';
            document.getElementById('Todays-sell').innerHTML = '<span class="animate-pulse">Loading...</span>';
            
            // Fetch all filtered data
            fetchFilteredStats(startDate, endDate);
            fetchFilteredCashFlow(startDate, endDate);
            fetchFilteredLists(startDate, endDate);
        }
        
        // Fetch filtered statistics
        function fetchFilteredStats(startDate, endDate) {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_FILTERED_AUDIT_STATS",
                    "START_DATE": startDate,
                    "END_DATE": endDate
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            document.getElementById('net-profit').innerHTML = "₹" + data.netprofit;
                            document.getElementById('total-expenses').innerHTML = "₹" + data.totalexpenses;
                            document.getElementById('operating-exp').innerHTML = "₹" + data.operatingexpense;
                            document.getElementById('salary-exp').innerHTML = "₹" + data.salarypayment;
                            
                            // Update profit color based on value
                            const profitEl = document.getElementById('net-profit');
                            if (parseFloat(data.netprofit) < 0) {
                                profitEl.classList.remove('text-green-600');
                                profitEl.classList.add('text-red-600');
                            } else {
                                profitEl.classList.remove('text-red-600');
                                profitEl.classList.add('text-green-600');
                            }
                            
                            // Update Daily Financial Overview
                            const income = parseFloat(data.income) || 0;
                            const totalExp = parseFloat(data.totalexpenses) || 0;
                            const netProfit = parseFloat(data.netprofit) || 0;
                            const stockPay = parseFloat(data.stockpayment) || 0;
                            
                            // Avg daily profit (net profit for the period)
                            document.getElementById('avgDailyProfit').textContent = '₹' + netProfit.toLocaleString('en-IN');
                            
                            // Payment efficiency = paid / total income
                            const efficiency = income > 0 ? Math.round((income - stockPay) / income * 100) : 0;
                            document.getElementById('paymentEfficiency').textContent = Math.min(100, Math.max(0, efficiency)) + '%';
                            
                            // Pending collections = stock payment still owed
                            const pending = stockPay > 0 ? stockPay : 0;
                            document.getElementById('pendingCollections').textContent = '₹' + pending.toLocaleString('en-IN');
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                        toastr.error("Failed to parse stats data.");
                    }
                },
                error: function() {
                    toastr.error("Failed to load stats data.");
                }
            });
        }
        
        // Fetch filtered cash flow
        function fetchFilteredCashFlow(startDate, endDate) {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_FILTERED_CASH_FLOW",
                    "START_DATE": startDate,
                    "END_DATE": endDate
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            document.getElementById("cashflow").innerHTML = "₹" + data.cash;
                            document.getElementById("phonepeflow").innerHTML = "₹" + data.phonepe;
                            document.getElementById("unpaidflow").innerHTML = "₹" + data.unpaid;
                            document.getElementById("Todays-sell").innerHTML = "₹" + data.totalsales;
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                    }
                },
                error: function() {
                    toastr.error("Failed to load cash flow data.");
                }
            });
        }
        
        // Fetch filtered lists
        function fetchFilteredLists(startDate, endDate) {
            // Destroy existing tables
            if (unpaidTable) unpaidTable.destroy();
            if (phonePeTable) phonePeTable.destroy();
            if (prevPaymentTable) prevPaymentTable.destroy();
            if (stockPaymentTable) stockPaymentTable.destroy();
            
            // Clear table bodies
            $('#unpaidlist').empty();
            $('#phonepelist').empty();
            $('#previouspaymentlist').empty();
            $('#stockpayments').empty();
            
            // Fetch unpaid list (always shows all unpaid, not filtered)
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { "RESULT_TYPE": "GET_UNPAID_LIST" },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    unpaidTable = new DataTable("#unpaidlist", {
                        columns: [{ title: "Counter" }, { title: "Bill Amount" }, { title: "Paid Amount" }],
                        data: jobj,
                        responsive: true,
                        pageLength: 5,
                        lengthMenu: [5, 10, 15]
                    });
                }
            });
            
            // Fetch PhonePe list (filtered)
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { 
                    "RESULT_TYPE": "GET_FILTERED_PHONEPE_LIST",
                    "START_DATE": startDate,
                    "END_DATE": endDate
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    phonePeTable = new DataTable("#phonepelist", {
                        columns: [{ title: "Counter" }, { title: "Amount Paid" }, { title: "Date" }],
                        data: jobj,
                        responsive: true,
                        pageLength: 5
                    });
                }
            });
            
            // Fetch previous payments (filtered)
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { 
                    "RESULT_TYPE": "GET_FILTERED_PAYMENT_LIST",
                    "START_DATE": startDate,
                    "END_DATE": endDate
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    prevPaymentTable = new DataTable("#previouspaymentlist", {
                        columns: [
                            { title: "Counter" },
                            { title: "Bill Date" },
                            { title: "Payment Date" },
                            { title: "Method" },
                            { title: "Amount" }
                        ],
                        data: jobj,
                        responsive: true,
                        pageLength: 5
                    });
                }
            });
            
            // Fetch stock payments (filtered)
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { 
                    "RESULT_TYPE": "GET_FILTERED_STOCK_PAYMENTS",
                    "START_DATE": startDate,
                    "END_DATE": endDate
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    stockPaymentTable = new DataTable("#stockpayments", {
                        columns: [
                            { title: "Product" },
                            { title: "Qty" },
                            { title: "Bill Amt" },
                            { title: "Paid" },
                            { title: "Method" },
                            { title: "Date" },
                            { title: "Agency" }
                        ],
                        data: jobj,
                        responsive: true,
                        pageLength: 5
                    });
                }
            });
        }
    </script>
</body>

</html>