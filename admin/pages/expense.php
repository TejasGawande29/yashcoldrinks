<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !in_array($_SESSION["ROLE"], ["admin", "manager"])) {
    header("Location: ../adminlogin.php");
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
    <script src="../js/jquery.js"></script>
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
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.6s ease-out both;
        }
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
                            <button type="button" onclick="addExpense()"
                                class="bg-gradient-to-r from-violet-500 to-teal-600 text-white font-bold px-8 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                Add Expense
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Expense Table and Filters -->
                <div class="bg-white/80 rounded-2xl shadow-lg p-6 border border-gray-200 animate-fade-in-down">
                    <div class="flex flex-wrap justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-teal-700">📋 Expense Records</h2>
                        <div class="flex flex-wrap gap-3 mt-4 md:mt-0">
                            <button onclick="filterExpenses('today')"
                                class="px-4 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600 transition">Today</button>
                            <button onclick="filterExpenses('week')"
                                class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">This Week</button>
                            <button onclick="filterExpenses('month')"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">This Month</button>
                            <button onclick="filterExpenses('all')"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">All Expenses</button>
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize DataTable
        let expenseTable = null;

        $(document).ready(function() {
            // Initialize DataTable with empty data
            expenseTable = $('#expensesTable').DataTable({
                columns: [{
                        title: 'ID',
                        data: 'id'
                    },
                    {
                        title: 'Date',
                        data: 'expense_date'
                    },
                    {
                        title: 'Type',
                        data: 'expense_type'
                    },
                    {
                        title: 'Amount',
                        data: 'amount',
                        render: function(data, type, row) {
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        title: 'Description',
                        data: 'description'
                    },
                    {
                        title: 'Actions',
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="flex space-x-2">
                                    <button onclick="deleteExpense(${row.id})" class="text-red-500 hover:text-red-700">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [
                    [1, 'desc']
                ]
            });

            // Load expenses initially (today)
            filterExpenses('today');

            // Initialize Lucide icons
            lucide.createIcons();
        });

        function filterExpenses(timeframe) {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_EXPENSES",
                    "TIMEFRAME": timeframe
                },
                success: function(res) {
                    const expenses = JSON.parse(res);
                    expenseTable.clear().rows.add(expenses).draw();
                    lucide.createIcons(); // re-render icons

                    // Update active filter button
                    $('button').removeClass('ring-2 ring-offset-2 ring-violet-500');
                    $(`button:contains('${timeframe.charAt(0).toUpperCase() + timeframe.slice(1)}')`)
                        .addClass('ring-2 ring-offset-2 ring-violet-500');
                },
                error: function() {
                    toastr.error('Failed to load expenses');
                }
            });
        }

        function addExpense() {
            const date = $('#expenseDate').val();
            const type = $('#expenseType').val();
            const amount = $('#amount').val();
            const description = $('#description').val();

            if (!date || !type || !amount) {
                toastr.error('Please fill all required fields');
                return;
            }

            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "ADD_EXPENSE",
                    "expense_date": date,
                    "expense_type": type,
                    "amount": amount,
                    "description": description
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        toastr.success('Expense added successfully!');
                        $('#expenseForm')[0].reset();
                        $('#expenseDate').val();
                        filterExpenses('today');
                    } else {
                        toastr.error(result.message || 'Failed to add expense');
                    }
                },
                error: function() {
                    toastr.error('Error adding expense');
                }
            });
        }

        function deleteExpense(id) {
            if (!confirm('Are you sure you want to delete this expense?')) return;

            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "DELETE_EXPENSE",
                    "id": id
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        toastr.success('Expense deleted successfully!');
                        filterExpenses($('.filter-active').data('timeframe') || 'today');
                    } else {
                        toastr.error(result.message || 'Failed to delete expense');
                    }
                },
                error: function() {
                    toastr.error('Error deleting expense');
                }
            });
        }
    </script>
</body>

</html>