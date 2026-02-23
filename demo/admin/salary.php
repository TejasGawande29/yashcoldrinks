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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Salary Management - YASH ColdDrinks</title>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen font-sans text-gray-800">
    <section class="max-w-screen-2xl mx-auto p-4 lg:p-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <?php include_once("layouts/sidebar.php") ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0 bg-white p-6 lg:p-8 rounded-2xl shadow-xl">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
                        <span class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-teal-500/30">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </span>
                        Salary Management
                    </h1>
                    <p class="text-gray-500 mt-1 ml-13">Manage employees and salary disbursements.</p>
                </div>

                <script>lucide.createIcons();</script>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-center">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl border border-teal-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center text-white">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Employees</p>
                                <p class="text-2xl font-bold text-teal-600">4</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white">
                                <i data-lucide="user-check" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Active Employees</p>
                                <p class="text-2xl font-bold text-green-600">3</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                                <i data-lucide="indian-rupee" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Monthly Payroll</p>
                                <p class="text-2xl font-bold text-blue-600">₹48,000</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl border border-purple-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                                <i data-lucide="wallet" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Paid This Month</p>
                                <p class="text-2xl font-bold text-purple-600">₹36,000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Employee Button -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-700">👥 Employee List</h2>
                    <button onclick="toastr.info('Demo mode - Feature under development')" class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-6 py-2 rounded-xl font-medium flex items-center gap-2 hover:scale-105 transition">
                        <i data-lucide="user-plus" class="w-5 h-5"></i> Add Employee
                    </button>
                </div>

                <!-- Employee Table -->
                <div class="bg-gray-50 rounded-2xl p-6 shadow-inner">
                    <table id="employeeTable" class="display w-full text-sm text-gray-700">
                        <thead>
                            <tr class="bg-gray-100">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Monthly Salary</th>
                                <th>Status</th>
                                <th>Last Paid</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Rahul Kumar</td>
                                <td>Delivery Boy</td>
                                <td>₹12,000</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span></td>
                                <td>2026-01-28</td>
                                <td>
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700 mr-2"><i data-lucide="banknote" class="w-5 h-5 inline"></i></button>
                                    <button onclick="toastr.info('Demo mode')" class="text-yellow-500 hover:text-yellow-700 mr-2"><i data-lucide="edit" class="w-5 h-5 inline"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Suresh Patil</td>
                                <td>Counter Staff</td>
                                <td>₹15,000</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span></td>
                                <td>2026-01-28</td>
                                <td>
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700 mr-2"><i data-lucide="banknote" class="w-5 h-5 inline"></i></button>
                                    <button onclick="toastr.info('Demo mode')" class="text-yellow-500 hover:text-yellow-700 mr-2"><i data-lucide="edit" class="w-5 h-5 inline"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Pooja Gaikwad</td>
                                <td>Accountant</td>
                                <td>₹18,000</td>
                                <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span></td>
                                <td>2026-01-28</td>
                                <td>
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700 mr-2"><i data-lucide="banknote" class="w-5 h-5 inline"></i></button>
                                    <button onclick="toastr.info('Demo mode')" class="text-yellow-500 hover:text-yellow-700 mr-2"><i data-lucide="edit" class="w-5 h-5 inline"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Vikram Jadhav</td>
                                <td>Helper</td>
                                <td>₹8,000</td>
                                <td><span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Inactive</span></td>
                                <td>2025-12-25</td>
                                <td>
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700 mr-2"><i data-lucide="banknote" class="w-5 h-5 inline"></i></button>
                                    <button onclick="toastr.info('Demo mode')" class="text-yellow-500 hover:text-yellow-700 mr-2"><i data-lucide="edit" class="w-5 h-5 inline"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Salary History -->
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">💰 Recent Salary Payments</h2>
                    <div class="bg-gray-50 rounded-2xl p-6 shadow-inner">
                        <table id="salaryHistory" class="display w-full text-sm text-gray-700">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Amount</th>
                                    <th>Mode</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Rahul Kumar</td>
                                    <td>₹12,000</td>
                                    <td>Bank Transfer</td>
                                    <td>2026-01-28</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Suresh Patil</td>
                                    <td>₹15,000</td>
                                    <td>Cash</td>
                                    <td>2026-01-28</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Pooja Gaikwad</td>
                                    <td>₹18,000</td>
                                    <td>Bank Transfer</td>
                                    <td>2026-01-28</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        lucide.createIcons();
        toastr.options = { positionClass: "toast-top-right", timeOut: 3000, closeButton: true, progressBar: true };
        $(document).ready(function() {
            $('#employeeTable').DataTable({ pageLength: 10, order: [[0, 'asc']] });
            $('#salaryHistory').DataTable({ pageLength: 5, order: [[4, 'desc']] });
        });
    </script>
</body>
</html>
