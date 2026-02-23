<?php
session_start();
if (isset($_SESSION["USERNAME"]) && isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] == "admin") {
    // User is authenticated - admin only page
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

    <!-- tailwindcss -->
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
    <title>Account Management</title>
    <style>
        .fade-in { animation: fadeIn 0.3s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .password-container { position: relative; }
        .toggle-password { position: absolute; right: 12px; top: 12px; cursor: pointer; }
    </style>
</head>

<body class="bg-gradient-to-br from-sky-100 to-white min-h-screen text-gray-800 font-sans">

    <section class="max-w-screen-2xl mx-auto p-4">
        <div class="grid lg:grid-cols-[18rem_auto] gap-6">

            <!-- Sidebar -->
            <?php include 'layouts/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 transition-colors duration-500 ease-in-out fade-in">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-4xl font-extrabold text-sky-700 drop-shadow-md">
                        👤 Account Management
                    </h1>
                    <button onclick="document.getElementById('accountModal').classList.remove('hidden')" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2 transition-all">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        Add New Account
                    </button>
                </div>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-center">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 shadow-inner">
                    <div class="overflow-x-auto">
                        <table id="accountsTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Username</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Mobile</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Admin</td>
                                    <td class="px-6 py-4">1234567890</td>
                                    <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">admin</span></td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <button onclick="toastr.info('Demo mode')" class="px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg flex items-center gap-1">
                                                <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                            </button>
                                            <button onclick="toastr.info('Demo mode')" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg flex items-center gap-1">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add/Edit Account Modal -->
    <div id="accountModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 fade-in">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-sky-700">Add New Account</h3>
                <button onclick="document.getElementById('accountModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Username</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent" required>
                </div>

                <div class="password-container">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent" required>
                    <p class="text-xs text-gray-500 mt-1">Password will be encrypted with MD5</p>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Mobile</label>
                    <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Role</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('accountModal').classList.add('hidden')" class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium">Cancel</button>
                    <button type="button" onclick="toastr.info('Demo mode - Feature under development'); document.getElementById('accountModal').classList.add('hidden')" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Save Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
        toastr.options = { positionClass: "toast-top-right", timeOut: 3000, closeButton: true, progressBar: true };
        $(document).ready(function() {
            $('#accountsTable').DataTable();
        });
    </script>
</body>
</html>
