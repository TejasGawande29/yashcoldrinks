<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || $_SESSION["ROLE"] !== "admin") {
    header("Location: adminlogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Dashboard - Admin | YASH ColdDrinks</title>

    <!-- TailwindCSS -->
    <link href="output.css" rel="stylesheet" />

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
    <style>
        .payment-badge { padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .paid { background-color: #d4edda; color: #155724; }
        .unpaid { background-color: #f8d7da; color: #721c24; }
        .partial { background-color: #fff3cd; color: #856404; }
    </style>
</head>

<body class="bg-gray-100">
    <div class="max-w-screen-2xl mx-auto p-4">
        <div class="grid lg:grid-cols-[18rem_auto] gap-6">
            <?php include 'layouts/sidebar.php'; ?>

            <main class="bg-white h-[95vh] overflow-y-scroll rounded-2xl shadow-xl p-6">
                <h1 class="text-3xl font-bold text-blue-700 mb-6">💰 Payment Management</h1>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-center">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Bills Overview</h2>
                        <div class="flex space-x-2">
                            <button onclick="toastr.info('Demo mode')" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Refresh</button>
                        </div>
                    </div>

                    <table id="billsTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">Bill ID</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Counter</th>
                                <th class="px-6 py-3 text-left">Total Amount</th>
                                <th class="px-6 py-3 text-left">Paid</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">#1001</td>
                                <td class="px-6 py-4">2026-02-10</td>
                                <td class="px-6 py-4">Counter 1</td>
                                <td class="px-6 py-4">₹5,200</td>
                                <td class="px-6 py-4">₹5,200</td>
                                <td class="px-6 py-4"><span class="payment-badge paid">Paid</span></td>
                                <td class="px-6 py-4">
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">#1002</td>
                                <td class="px-6 py-4">2026-02-11</td>
                                <td class="px-6 py-4">Counter 2</td>
                                <td class="px-6 py-4">₹7,500</td>
                                <td class="px-6 py-4">₹3,000</td>
                                <td class="px-6 py-4"><span class="payment-badge partial">Partial</span></td>
                                <td class="px-6 py-4">
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">#1003</td>
                                <td class="px-6 py-4">2026-02-12</td>
                                <td class="px-6 py-4">Counter 1</td>
                                <td class="px-6 py-4">₹4,800</td>
                                <td class="px-6 py-4">₹0</td>
                                <td class="px-6 py-4"><span class="payment-badge unpaid">Unpaid</span></td>
                                <td class="px-6 py-4">
                                    <button onclick="toastr.info('Demo mode')" class="text-blue-500 hover:text-blue-700">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Details Modal (static demo) -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-indigo-700 mb-3">Payment History Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-xl p-4 shadow text-center">
                            <p class="text-sm text-gray-500">Total Bills</p>
                            <p class="text-2xl font-bold text-blue-600">3</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow text-center">
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="text-2xl font-bold text-green-600">₹17,500</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow text-center">
                            <p class="text-sm text-gray-500">Pending Amount</p>
                            <p class="text-2xl font-bold text-red-600">₹9,300</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        AOS.init({ duration: 600, once: true });
        lucide.createIcons();
        toastr.options = { positionClass: "toast-top-right", timeOut: 3000, closeButton: true, progressBar: true };
    </script>
</body>
</html>
