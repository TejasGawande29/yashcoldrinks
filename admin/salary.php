<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !in_array($_SESSION["ROLE"], ["admin", "manager"])) {
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
    <script src="/YashColdrinks/assets/js/jquery.js"></script>
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

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl border border-teal-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center text-white">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Employees</p>
                                <p id="totalEmployees" class="text-2xl font-bold text-teal-600">0</p>
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
                                <p id="activeEmployees" class="text-2xl font-bold text-green-600">0</p>
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
                                <p id="monthlyPayroll" class="text-2xl font-bold text-blue-600">₹0</p>
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
                                <p id="paidThisMonth" class="text-2xl font-bold text-purple-600">₹0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div x-data="{ activeTab: 'employees' }" class="mb-6">
                    <div class="flex gap-2 border-b border-gray-200 mb-6">
                        <button @click="activeTab = 'employees'" 
                            :class="activeTab === 'employees' ? 'border-b-2 border-teal-500 text-teal-600' : 'text-gray-500'"
                            class="px-4 py-2 font-medium transition-colors flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            Employees
                        </button>
                        <button @click="activeTab = 'payments'" 
                            :class="activeTab === 'payments' ? 'border-b-2 border-teal-500 text-teal-600' : 'text-gray-500'"
                            class="px-4 py-2 font-medium transition-colors flex items-center gap-2">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                            Salary Payments
                        </button>
                        <button @click="activeTab = 'history'" 
                            :class="activeTab === 'history' ? 'border-b-2 border-teal-500 text-teal-600' : 'text-gray-500'"
                            class="px-4 py-2 font-medium transition-colors flex items-center gap-2">
                            <i data-lucide="history" class="w-4 h-4"></i>
                            Payment History
                        </button>
                    </div>

                    <!-- Employees Tab -->
                    <div x-show="activeTab === 'employees'" x-transition>
                        <!-- Add Employee Form -->
                        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl border border-teal-100 p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i data-lucide="user-plus" class="w-5 h-5 text-teal-500"></i>
                                Add New Employee
                            </h2>
                            <form id="employeeForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Employee Name *</label>
                                    <input type="text" id="empName" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-teal-500 focus:outline-none transition-all"
                                        placeholder="Full Name">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" id="empPhone"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-teal-500 focus:outline-none transition-all"
                                        placeholder="Mobile Number">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Role/Designation</label>
                                    <input type="text" id="empRole"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-teal-500 focus:outline-none transition-all"
                                        placeholder="e.g. Delivery Boy, Helper">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Monthly Salary *</label>
                                    <input type="number" id="empSalary" required min="0" step="0.01"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-teal-500 focus:outline-none transition-all"
                                        placeholder="₹ Amount">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Join Date</label>
                                    <input type="date" id="empJoinDate"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-teal-500 focus:outline-none transition-all"
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                        Add Employee
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Employees Table -->
                        <div class="overflow-x-auto">
                            <table id="employeesTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Name</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Phone</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Role</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Monthly Salary</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Join Date</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="employeesTableBody" class="bg-white divide-y divide-gray-100">
                                    <!-- Data loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Salary Payments Tab -->
                    <div x-show="activeTab === 'payments'" x-transition>
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100 p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i data-lucide="banknote" class="w-5 h-5 text-green-500"></i>
                                Record Salary Payment
                            </h2>
                            <form id="paymentForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Select Employee *</label>
                                    <select id="payEmployee" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-green-500 focus:outline-none transition-all">
                                        <option value="">Select Employee</option>
                                        <!-- Options loaded dynamically -->
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Amount *</label>
                                    <input type="number" id="payAmount" required min="0" step="0.01"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-green-500 focus:outline-none transition-all"
                                        placeholder="₹ Amount">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Payment Date *</label>
                                    <input type="date" id="payDate" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-green-500 focus:outline-none transition-all"
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Payment Month *</label>
                                    <input type="month" id="payMonth" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-green-500 focus:outline-none transition-all"
                                        value="<?php echo date('Y-m'); ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Payment Method</label>
                                    <select id="payMethod"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-green-500 focus:outline-none transition-all">
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="PhonePe">PhonePe</option>
                                        <option value="UPI">UPI</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Notes</label>
                                    <input type="text" id="payNotes"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-green-500 focus:outline-none transition-all"
                                        placeholder="e.g. Advance, Bonus, Deduction">
                                </div>
                                <div class="md:col-span-3">
                                    <button type="submit"
                                        class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        Record Payment
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Pending Salaries -->
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="clock" class="w-5 h-5 text-orange-500"></i>
                            Pending Salaries (Current Month)
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-orange-500 to-amber-500 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Employee</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Role</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Monthly Salary</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Paid</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Pending</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="pendingSalariesBody" class="bg-white divide-y divide-gray-100">
                                    <!-- Data loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment History Tab -->
                    <div x-show="activeTab === 'history'" x-transition>
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Filter by Month</label>
                                <input type="month" id="filterMonth"
                                    class="px-4 py-2 border-2 border-gray-200 rounded-xl bg-white focus:border-purple-500 focus:outline-none transition-all"
                                    value="<?php echo date('Y-m'); ?>">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Filter by Employee</label>
                                <select id="filterEmployee"
                                    class="px-4 py-2 border-2 border-gray-200 rounded-xl bg-white focus:border-purple-500 focus:outline-none transition-all">
                                    <option value="">All Employees</option>
                                    <!-- Options loaded dynamically -->
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button onclick="loadPaymentHistory()"
                                    class="bg-gradient-to-r from-purple-500 to-violet-500 text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transition-all flex items-center gap-2">
                                    <i data-lucide="search" class="w-4 h-4"></i>
                                    Search
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table id="historyTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-purple-500 to-violet-500 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Employee</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Amount</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Payment Date</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">For Month</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Method</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Notes</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="historyTableBody" class="bg-white divide-y divide-gray-100">
                                    <!-- Data loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize
        $(document).ready(function() {
            lucide.createIcons();
            loadStats();
            loadEmployees();
            loadEmployeeDropdowns();
            loadPendingSalaries();
            loadPaymentHistory();
        });

        // Load Stats
        function loadStats() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { "RESULT_TYPE": "GET_SALARY_STATS" },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            $('#totalEmployees').text(data.total_employees);
                            $('#activeEmployees').text(data.active_employees);
                            $('#monthlyPayroll').text('₹' + parseFloat(data.monthly_payroll).toLocaleString('en-IN'));
                            $('#paidThisMonth').text('₹' + parseFloat(data.paid_this_month).toLocaleString('en-IN'));
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                    }
                }
            });
        }

        // Load Employees
        function loadEmployees() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { "RESULT_TYPE": "GET_EMPLOYEES" },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            const tbody = $('#employeesTableBody');
                            tbody.empty();
                            data.data.forEach(emp => {
                                const statusClass = emp.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                tbody.append(`
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm">${emp.id}</td>
                                        <td class="px-4 py-3 text-sm font-medium">${emp.name}</td>
                                        <td class="px-4 py-3 text-sm">${emp.phone || '-'}</td>
                                        <td class="px-4 py-3 text-sm">${emp.role || '-'}</td>
                                        <td class="px-4 py-3 text-sm font-semibold text-green-600">₹${parseFloat(emp.monthly_salary).toLocaleString('en-IN')}</td>
                                        <td class="px-4 py-3 text-sm">${emp.join_date || '-'}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold ${statusClass}">${emp.status}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <button onclick="editEmployee(${emp.id})" class="text-blue-500 hover:text-blue-700 mr-2">
                                                <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                            </button>
                                            <button onclick="toggleEmployeeStatus(${emp.id}, '${emp.status}')" class="text-orange-500 hover:text-orange-700 mr-2">
                                                <i data-lucide="toggle-left" class="w-4 h-4 inline"></i>
                                            </button>
                                            <button onclick="deleteEmployee(${emp.id})" class="text-red-500 hover:text-red-700">
                                                <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `);
                            });
                            lucide.createIcons();
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                    }
                }
            });
        }

        // Load Employee Dropdowns
        function loadEmployeeDropdowns() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { "RESULT_TYPE": "GET_ACTIVE_EMPLOYEES" },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            const paySelect = $('#payEmployee');
                            const filterSelect = $('#filterEmployee');
                            
                            paySelect.find('option:not(:first)').remove();
                            filterSelect.find('option:not(:first)').remove();
                            
                            data.data.forEach(emp => {
                                paySelect.append(`<option value="${emp.id}" data-salary="${emp.monthly_salary}">${emp.name} (₹${parseFloat(emp.monthly_salary).toLocaleString('en-IN')})</option>`);
                                filterSelect.append(`<option value="${emp.id}">${emp.name}</option>`);
                            });
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                    }
                }
            });
        }

        // Auto-fill salary amount when employee selected
        $('#payEmployee').on('change', function() {
            const salary = $(this).find(':selected').data('salary');
            if (salary) {
                $('#payAmount').val(salary);
            }
        });

        // Load Pending Salaries
        function loadPendingSalaries() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { "RESULT_TYPE": "GET_PENDING_SALARIES" },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            const tbody = $('#pendingSalariesBody');
                            tbody.empty();
                            data.data.forEach(emp => {
                                const pending = emp.monthly_salary - emp.paid;
                                const pendingClass = pending > 0 ? 'text-red-600' : 'text-green-600';
                                tbody.append(`
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-medium">${emp.name}</td>
                                        <td class="px-4 py-3 text-sm">${emp.role || '-'}</td>
                                        <td class="px-4 py-3 text-sm">₹${parseFloat(emp.monthly_salary).toLocaleString('en-IN')}</td>
                                        <td class="px-4 py-3 text-sm text-green-600">₹${parseFloat(emp.paid).toLocaleString('en-IN')}</td>
                                        <td class="px-4 py-3 text-sm font-semibold ${pendingClass}">₹${parseFloat(pending).toLocaleString('en-IN')}</td>
                                        <td class="px-4 py-3 text-sm">
                                            ${pending > 0 ? `<button onclick="quickPay(${emp.id}, '${emp.name.replace(/'/g, "&#39;")}', ${pending})" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Pay ₹${parseFloat(pending).toLocaleString('en-IN')}</button>` : '<span class="text-green-500 font-semibold">✓ Paid</span>'}
                                        </td>
                                    </tr>
                                `);
                            });
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                    }
                }
            });
        }

        // Load Payment History
        function loadPaymentHistory() {
            const month = $('#filterMonth').val();
            const employeeId = $('#filterEmployee').val();
            
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { 
                    "RESULT_TYPE": "GET_SALARY_PAYMENTS",
                    "MONTH": month,
                    "EMPLOYEE_ID": employeeId
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            const tbody = $('#historyTableBody');
                            tbody.empty();
                            data.data.forEach(pay => {
                                tbody.append(`
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm">${pay.id}</td>
                                        <td class="px-4 py-3 text-sm font-medium">${pay.employee_name}</td>
                                        <td class="px-4 py-3 text-sm font-semibold text-green-600">₹${parseFloat(pay.amount).toLocaleString('en-IN')}</td>
                                        <td class="px-4 py-3 text-sm">${pay.payment_date}</td>
                                        <td class="px-4 py-3 text-sm">${pay.payment_month}</td>
                                        <td class="px-4 py-3 text-sm">${pay.payment_method}</td>
                                        <td class="px-4 py-3 text-sm">${pay.notes || '-'}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <button onclick="deletePayment(${pay.id})" class="text-red-500 hover:text-red-700">
                                                <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `);
                            });
                            lucide.createIcons();
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                    }
                }
            });
        }

        // Add Employee Form Submit
        $('#employeeForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "ADD_EMPLOYEE",
                    "NAME": $('#empName').val(),
                    "PHONE": $('#empPhone').val(),
                    "ROLE": $('#empRole').val(),
                    "SALARY": $('#empSalary').val(),
                    "JOIN_DATE": $('#empJoinDate').val()
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            toastr.success(data.message);
                            $('#employeeForm')[0].reset();
                            $('#empJoinDate').val(new Date().toISOString().split('T')[0]);
                            loadEmployees();
                            loadEmployeeDropdowns();
                            loadStats();
                        } else {
                            toastr.error(data.message);
                        }
                    } catch (e) {
                        toastr.error("Error processing request");
                    }
                }
            });
        });

        // Payment Form Submit
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "ADD_SALARY_PAYMENT",
                    "EMPLOYEE_ID": $('#payEmployee').val(),
                    "AMOUNT": $('#payAmount').val(),
                    "PAYMENT_DATE": $('#payDate').val(),
                    "PAYMENT_MONTH": $('#payMonth').val(),
                    "PAYMENT_METHOD": $('#payMethod').val(),
                    "NOTES": $('#payNotes').val()
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            toastr.success(data.message);
                            $('#paymentForm')[0].reset();
                            $('#payDate').val(new Date().toISOString().split('T')[0]);
                            $('#payMonth').val(new Date().toISOString().slice(0, 7));
                            loadPendingSalaries();
                            loadPaymentHistory();
                            loadStats();
                        } else {
                            toastr.error(data.message);
                        }
                    } catch (e) {
                        toastr.error("Error processing request");
                    }
                }
            });
        });

        // Quick Pay
        function quickPay(empId, empName, amount) {
            Swal.fire({
                title: 'Confirm Payment',
                html: `Pay <strong>₹${parseFloat(amount).toLocaleString('en-IN')}</strong> to <strong>${empName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Pay Now'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "functions.php",
                        type: "POST",
                        data: {
                            "RESULT_TYPE": "ADD_SALARY_PAYMENT",
                            "EMPLOYEE_ID": empId,
                            "AMOUNT": amount,
                            "PAYMENT_DATE": new Date().toISOString().split('T')[0],
                            "PAYMENT_MONTH": new Date().toISOString().slice(0, 7),
                            "PAYMENT_METHOD": "Cash",
                            "NOTES": "Quick payment"
                        },
                        success: function(res) {
                            const data = JSON.parse(res);
                            if (data.success) {
                                toastr.success(data.message);
                                loadPendingSalaries();
                                loadPaymentHistory();
                                loadStats();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });
        }

        // Edit Employee
        function editEmployee(id) {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: { "RESULT_TYPE": "GET_EMPLOYEE", "ID": id },
                success: function(res) {
                    const data = JSON.parse(res);
                    if (data.success) {
                        const emp = data.data;
                        Swal.fire({
                            title: 'Edit Employee',
                            html: `
                                <input id="swal-name" class="swal2-input" placeholder="Name" value="${emp.name}">
                                <input id="swal-phone" class="swal2-input" placeholder="Phone" value="${emp.phone || ''}">
                                <input id="swal-role" class="swal2-input" placeholder="Role" value="${emp.role || ''}">
                                <input id="swal-salary" class="swal2-input" type="number" placeholder="Monthly Salary" value="${emp.monthly_salary}">
                            `,
                            showCancelButton: true,
                            confirmButtonColor: '#8b5cf6',
                            confirmButtonText: 'Update',
                            preConfirm: () => {
                                return {
                                    name: document.getElementById('swal-name').value,
                                    phone: document.getElementById('swal-phone').value,
                                    role: document.getElementById('swal-role').value,
                                    salary: document.getElementById('swal-salary').value
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "functions.php",
                                    type: "POST",
                                    data: {
                                        "RESULT_TYPE": "UPDATE_EMPLOYEE",
                                        "ID": id,
                                        "NAME": result.value.name,
                                        "PHONE": result.value.phone,
                                        "ROLE": result.value.role,
                                        "SALARY": result.value.salary
                                    },
                                    success: function(res) {
                                        const data = JSON.parse(res);
                                        if (data.success) {
                                            toastr.success(data.message);
                                            loadEmployees();
                                            loadEmployeeDropdowns();
                                            loadStats();
                                        } else {
                                            toastr.error(data.message);
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }

        // Toggle Employee Status
        function toggleEmployeeStatus(id, currentStatus) {
            const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';
            Swal.fire({
                title: 'Change Status',
                text: `Set employee status to ${newStatus}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                confirmButtonText: 'Yes, Change'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "functions.php",
                        type: "POST",
                        data: { "RESULT_TYPE": "TOGGLE_EMPLOYEE_STATUS", "ID": id, "STATUS": newStatus },
                        success: function(res) {
                            const data = JSON.parse(res);
                            if (data.success) {
                                toastr.success(data.message);
                                loadEmployees();
                                loadEmployeeDropdowns();
                                loadStats();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });
        }

        // Delete Employee
        function deleteEmployee(id) {
            Swal.fire({
                title: 'Delete Employee?',
                text: "This will also delete all payment records!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "functions.php",
                        type: "POST",
                        data: { "RESULT_TYPE": "DELETE_EMPLOYEE", "ID": id },
                        success: function(res) {
                            const data = JSON.parse(res);
                            if (data.success) {
                                toastr.success(data.message);
                                loadEmployees();
                                loadEmployeeDropdowns();
                                loadStats();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });
        }

        // Delete Payment
        function deletePayment(id) {
            Swal.fire({
                title: 'Delete Payment?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "functions.php",
                        type: "POST",
                        data: { "RESULT_TYPE": "DELETE_SALARY_PAYMENT", "ID": id },
                        success: function(res) {
                            const data = JSON.parse(res);
                            if (data.success) {
                                toastr.success(data.message);
                                loadPendingSalaries();
                                loadPaymentHistory();
                                loadStats();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
