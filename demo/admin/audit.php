<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || $_SESSION["ROLE"] !== "admin") {
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        :root {
            --primary: #4361ee; --secondary: #3f37c9; --success: #4cc9f0;
            --warning: #f72585; --dark: #1d3557; --light: #f8f9fa;
        }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #e4e7f1 100%); min-height: 100vh; }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1); transition: all 0.3s ease; overflow: hidden; position: relative;
        }
        .dashboard-card:hover { transform: translateY(-5px); box-shadow: 0 12px 40px rgba(31, 38, 135, 0.2); }
        .dashboard-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; border-radius: 16px 16px 0 0; }
        .card-sales::before { background: linear-gradient(90deg, #ff9a9e 0%, #fad0c4 100%); }
        .card-profit::before { background: linear-gradient(90deg, #a1c4fd 0%, #c2e9fb 100%); }
        .card-expenses::before { background: linear-gradient(90deg, #ffecd2 0%, #fcb69f 100%); }
        .card-cashflow::before { background: linear-gradient(90deg, #84fab0 0%, #8fd3f4 100%); }
    </style>
</head>

<body>
    <div class="max-w-screen-2xl mx-auto p-4">
        <div class="grid lg:grid-cols-[18rem_auto] gap-6">
            <?php include 'layouts/sidebar.php'; ?>

            <main class="space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">📊 Audit Dashboard</h1>
                        <p class="text-gray-500 mt-1">Financial overview and analytics</p>
                    </div>
                    <div class="flex gap-3">
                        <select class="border rounded-xl px-4 py-2 bg-white shadow-sm">
                            <option>This Month</option>
                            <option>Last Month</option>
                            <option>This Quarter</option>
                            <option>This Year</option>
                        </select>
                    </div>
                </div>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only with sample data. Backend functionality is under development.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
                    <div class="dashboard-card card-sales p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total Sales</p>
                                <h3 class="text-2xl font-bold text-gray-800">₹1,25,400</h3>
                                <p class="text-xs text-green-500 mt-1">↑ 12.5% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-6 h-6 text-rose-500"></i>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card card-profit p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Net Profit</p>
                                <h3 class="text-2xl font-bold text-gray-800">₹42,800</h3>
                                <p class="text-xs text-green-500 mt-1">↑ 8.3% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="indian-rupee" class="w-6 h-6 text-blue-500"></i>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card card-expenses p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total Expenses</p>
                                <h3 class="text-2xl font-bold text-gray-800">₹82,600</h3>
                                <p class="text-xs text-red-500 mt-1">↑ 3.1% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="trending-down" class="w-6 h-6 text-orange-500"></i>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card card-cashflow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Cash Flow</p>
                                <h3 class="text-2xl font-bold text-gray-800">₹42,800</h3>
                                <p class="text-xs text-green-500 mt-1">Positive cash flow</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="wallet" class="w-6 h-6 text-green-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up">
                    <div class="dashboard-card p-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">📈 Sales vs Expenses</h3>
                        <canvas id="salesChart" height="200"></canvas>
                    </div>
                    <div class="dashboard-card p-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">🍩 Category Breakdown</h3>
                        <canvas id="categoryChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="dashboard-card p-6" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">📋 Recent Transactions</h3>
                    <table id="transactionsTable" class="display w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2026-02-13</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Sale</span></td>
                                <td>ThumsUp-250 x20 boxes</td>
                                <td class="text-green-600 font-bold">+₹10,400</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Completed</span></td>
                            </tr>
                            <tr>
                                <td>2026-02-12</td>
                                <td><span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">Purchase</span></td>
                                <td>Stock purchase - Coca-Cola</td>
                                <td class="text-red-600 font-bold">-₹13,000</td>
                                <td><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Unpaid</span></td>
                            </tr>
                            <tr>
                                <td>2026-02-11</td>
                                <td><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">Expense</span></td>
                                <td>Electricity bill</td>
                                <td class="text-red-600 font-bold">-₹1,800</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Paid</span></td>
                            </tr>
                            <tr>
                                <td>2026-02-10</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Sale</span></td>
                                <td>Sprite-250 x15 boxes</td>
                                <td class="text-green-600 font-bold">+₹7,500</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Completed</span></td>
                            </tr>
                            <tr>
                                <td>2026-02-10</td>
                                <td><span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">Salary</span></td>
                                <td>Employee salary - Rahul Kumar</td>
                                <td class="text-red-600 font-bold">-₹12,000</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Paid</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script>
        AOS.init({ duration: 600, once: true });
        lucide.createIcons();
        toastr.options = { positionClass: "toast-top-right", timeOut: 3000, closeButton: true, progressBar: true };

        $(document).ready(function() {
            $('#transactionsTable').DataTable({ pageLength: 10, order: [[0, 'desc']] });
        });

        // Sales Chart
        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    { label: 'Sales', data: [95000, 125400, 0, 0, 0, 0], backgroundColor: 'rgba(59, 130, 246, 0.7)', borderRadius: 8 },
                    { label: 'Expenses', data: [78000, 82600, 0, 0, 0, 0], backgroundColor: 'rgba(249, 115, 22, 0.7)', borderRadius: 8 }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, ticks: { callback: v => '₹' + (v/1000) + 'K' } } }
            }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['Stock Purchase', 'Salary', 'Utilities', 'Transport', 'Rent', 'Other'],
                datasets: [{
                    data: [45000, 36000, 1800, 800, 15000, 2000],
                    backgroundColor: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444', '#6b7280'],
                    borderWidth: 2, borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
</body>
</html>
