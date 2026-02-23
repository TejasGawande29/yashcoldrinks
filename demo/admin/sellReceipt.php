<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || $_SESSION["ROLE"] !== "admin") {
    header("Location: adminlogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sell Receipt - Admin | YASH ColdDrinks</title>

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
</head>

<body class="bg-gradient-to-br from-white to-slate-100 text-gray-800 font-sans">

    <section class="max-w-full mx-auto p-4">
        <div class="grid grid-cols-1 lg:grid-cols-[20%_auto] gap-6 min-h-screen">

            <!-- Sidebar -->
            <aside class="bg-white rounded-2xl shadow-md p-4 lg:p-6 sticky top-0 z-10" data-aos="fade-right">
                <?php include 'layouts/sidebar.php'; ?>
            </aside>

            <!-- Main Content -->
            <main class="bg-white rounded-2xl shadow-xl p-4 lg:p-8" data-aos="fade-up">
                <h1 class="text-3xl font-bold text-blue-700 text-center mb-6">📦 Sell Receipt</h1>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-center">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <!-- Form -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <select id="productname" class="border rounded-md px-4 py-2 w-full">
                        <option value="">Select Product</option>
                        <option value="ThumsUp-250">ThumsUp-250</option>
                        <option value="Sprite-250">Sprite-250</option>
                        <option value="Fanta-250">Fanta-250</option>
                        <option value="Coca-Cola-250">Coca-Cola-250</option>
                        <option value="Limca-250">Limca-250</option>
                        <option value="Maaza-250">Maaza-250</option>
                    </select>

                    <input id="inptquantity" type="number" min="1" placeholder="Quantity" class="border rounded-md px-4 py-2 w-full" />

                    <select id="inpscheme" class="border rounded-md px-4 py-2 w-full">
                        <option value="-">Select Scheme</option>
                        <option value="RIO-1000">RIO-1000</option>
                        <option value="SpriteCan-125">SpriteCan-125</option>
                        <option value="ThumpsUpCan-125">ThumpsUpCan-125</option>
                        <option value="CocaColaCan-125">CocaColaCan-125</option>
                    </select>
                    <input id="schemebottles" type="text" placeholder="Scheme Bottles Number" class="border rounded-md px-4 py-2 w-full" />

                    <input id="inpprice" type="number" min="0" step="0.01" placeholder="Price" class="border rounded-md px-4 py-2 w-full" />
                    <input id="billamount" type="number" readonly placeholder="Amount" class="border rounded-md px-4 py-2 w-full bg-gray-100" />
                </div>

                <div class="text-center mb-8">
                    <button onclick="toastr.info('Demo mode - Feature under development')" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-full shadow-lg hover:scale-105 transition duration-300">
                        ➕ Add Product
                    </button>
                </div>

                <!-- Sell Receipt Table -->
                <div class="mb-8 overflow-x-auto">
                    <table id="receiptTable" class="min-w-full divide-y divide-gray-200 border rounded-xl overflow-hidden shadow-md">
                        <thead class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Product</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Quantity</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Scheme</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Scheme Bottles</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Price</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Amount</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample static data for demo -->
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3">ThumsUp-250</td>
                                <td class="px-6 py-3">5</td>
                                <td class="px-6 py-3">RIO-1000</td>
                                <td class="px-6 py-3">2</td>
                                <td class="px-6 py-3">₹520</td>
                                <td class="px-6 py-3">₹2,600</td>
                                <td class="px-6 py-3"><button class="text-red-500 hover:text-red-700">🗑️</button></td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3">Sprite-250</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">-</td>
                                <td class="px-6 py-3">0</td>
                                <td class="px-6 py-3">₹500</td>
                                <td class="px-6 py-3">₹1,500</td>
                                <td class="px-6 py-3"><button class="text-red-500 hover:text-red-700">🗑️</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bill Section -->
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-2xl p-6 shadow-inner mb-6">
                    <h2 class="text-xl font-bold text-indigo-700 mb-4">🧾 Bill Summary</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <select class="border rounded-md px-4 py-2 w-full">
                            <option value="">Select Counter</option>
                            <option value="Counter 1">Counter 1</option>
                            <option value="Counter 2">Counter 2</option>
                            <option value="Counter 3">Counter 3</option>
                        </select>
                        <select class="border rounded-md px-4 py-2 w-full">
                            <option value="">Payment Method</option>
                            <option value="Cash">Cash</option>
                            <option value="PhonePe">PhonePe</option>
                            <option value="GPay">GPay</option>
                            <option value="Paytm">Paytm</option>
                        </select>
                        <div class="text-lg font-bold text-indigo-700 flex items-center">
                            Total: ₹4,100
                        </div>
                        <button onclick="toastr.info('Demo mode - Feature under development')" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-full shadow-lg hover:scale-105 transition duration-300">
                            💾 Submit Bill
                        </button>
                    </div>
                </div>

                <!-- Sell History -->
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">📊 Recent Sales History</h2>
                    <table class="min-w-full divide-y divide-gray-200 border rounded-xl overflow-hidden shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Product</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Qty</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Counter</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Amount</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3">ThumsUp-250</td>
                                <td class="px-4 py-3">10</td>
                                <td class="px-4 py-3">Counter 1</td>
                                <td class="px-4 py-3">₹5,200</td>
                                <td class="px-4 py-3">2026-02-10</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3">Sprite-250</td>
                                <td class="px-4 py-3">8</td>
                                <td class="px-4 py-3">Counter 2</td>
                                <td class="px-4 py-3">₹4,000</td>
                                <td class="px-4 py-3">2026-02-11</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </section>

    <script>
        AOS.init({ duration: 600, once: true });
        lucide.createIcons();
        toastr.options = { positionClass: "toast-top-right", timeOut: 3000, closeButton: true, progressBar: true };
    </script>
</body>
</html>
