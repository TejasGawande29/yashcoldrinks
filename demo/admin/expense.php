<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || $_SESSION["ROLE"] != "admin") {
    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- tailwindcss -->
    <link rel="stylesheet" href="output.css">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Tables -->
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Expense Management</title>
    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fade-in-down 0.6s ease-out both; }
    </style>
</head>

<body class="bg-gradient-to-tr from-violet-100 to-cyan-100 min-h-screen font-sans text-gray-800">
    <section class="max-w-screen-xl mx-auto px-4 py-8">
        <div class="grid lg:grid-cols-[18%_auto] gap-8">
            <!-- Sidebar -->
            <?php include_once("layouts/sidebar.php") ?>

            <!-- Main Content -->
            <div class="backdrop-blur-md bg-white/60 p-8 rounded-3xl shadow-xl transition hover:shadow-2xl duration-300 border border-white/50">
                <h1 class="text-5xl font-extrabold text-violet-600 text-center mb-10 animate-fade-in-down tracking-tight">
                    💸 Expense Management
                </h1>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-center animate-fade-in-down">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <!-- Expense Form -->
                <div class="bg-white/80 rounded-2xl shadow-lg p-6 mb-10 border border-gray-200 animate-fade-in-down">
                    <h2 class="text-2xl font-bold text-teal-700 mb-4">➕ Add New Expense</h2>
                    <form id="expenseForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Date</label>
                            <input type="date" id="expenseDate"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-inner bg-white focus:ring-4 focus:ring-teal-400 focus:outline-none"
                                value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Expense Type</label>
                            <input type="text" id="expenseType"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-inner bg-white focus:ring-4 focus:ring-teal-400 focus:outline-none"
                                placeholder="e.g. Supplies, Utilities" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Amount (₹)</label>
                            <input type="number" id="amount" step="0.01" min="0"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-inner bg-white focus:ring-4 focus:ring-teal-400 focus:outline-none"
                                placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Description</label>
                            <textarea id="description"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-inner bg-white focus:ring-4 focus:ring-teal-400 focus:outline-none"
                                placeholder="Details about the expense"></textarea>
                        </div>
                        <div class="md:col-span-2 flex justify-center mt-4">
                            <button type="button" onclick="toastr.info('Demo mode - Feature under development')"
                                class="bg-gradient-to-r from-violet-500 to-teal-600 text-white font-bold px-8 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                Add Expense
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Expense Table -->
                <div class="bg-white/80 rounded-2xl shadow-lg p-6 border border-gray-200 animate-fade-in-down">
                    <div class="flex flex-wrap justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-teal-700">📋 Expense Records</h2>
                        <div class="flex flex-wrap gap-3 mt-4 md:mt-0">
                            <button class="px-4 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600 transition ring-2 ring-offset-2 ring-violet-500">Today</button>
                            <button class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">This Week</button>
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">This Month</button>
                            <button class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">All Expenses</button>
                        </div>
                    </div>

                    <table id="expensesTable" class="display w-full text-sm text-gray-700">
                        <thead>
                            <tr class="bg-gray-100">
                                <th>ID</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2026-02-10</td>
                                <td>Supplies</td>
                                <td>₹2,500.00</td>
                                <td>Purchased cleaning supplies</td>
                                <td><button class="text-red-500 hover:text-red-700"><i data-lucide="trash-2" class="w-5 h-5 inline"></i></button></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2026-02-11</td>
                                <td>Utilities</td>
                                <td>₹1,800.00</td>
                                <td>Electricity bill</td>
                                <td><button class="text-red-500 hover:text-red-700"><i data-lucide="trash-2" class="w-5 h-5 inline"></i></button></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>2026-02-12</td>
                                <td>Rent</td>
                                <td>₹15,000.00</td>
                                <td>Monthly shop rent</td>
                                <td><button class="text-red-500 hover:text-red-700"><i data-lucide="trash-2" class="w-5 h-5 inline"></i></button></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>2026-02-13</td>
                                <td>Transport</td>
                                <td>₹800.00</td>
                                <td>Delivery vehicle fuel</td>
                                <td><button class="text-red-500 hover:text-red-700"><i data-lucide="trash-2" class="w-5 h-5 inline"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        lucide.createIcons();
        toastr.options = { positionClass: "toast-top-right", timeOut: 3000, closeButton: true, progressBar: true };
        $(document).ready(function() {
            $('#expensesTable').DataTable({
                pagingType: 'full_numbers',
                pageLength: 10,
                order: [[1, 'desc']]
            });
        });
    </script>
</body>
</html>
