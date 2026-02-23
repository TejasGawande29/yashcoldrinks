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
    <title>Order Management - Admin | YASH ColdDrinks</title>

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

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .order-card { transition: all 0.3s ease; border-left: 4px solid; }
        .order-pending { border-left-color: #f59e0b; background-color: #fffbeb; }
        .order-processing { border-left-color: #3b82f6; background-color: #eff6ff; }
        .order-shipped { border-left-color: #8b5cf6; background-color: #f5f3ff; }
        .order-delivered { border-left-color: #10b981; background-color: #ecfdf5; }
        .status-badge { padding: 4px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .badge-pending { background-color: #fef3c7; color: #d97706; }
        .badge-processing { background-color: #dbeafe; color: #1d4ed8; }
        .badge-shipped { background-color: #ede9fe; color: #6d28d9; }
        .badge-delivered { background-color: #d1fae5; color: #047857; }
    </style>
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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-blue-700">🛒 Order Management</h1>
                    <button onclick="toastr.info('Demo mode')" class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i> Refresh
                    </button>
                </div>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-center">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-amber-600">3</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Processing</p>
                        <p class="text-2xl font-bold text-blue-600">2</p>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Shipped</p>
                        <p class="text-2xl font-bold text-purple-600">1</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Delivered</p>
                        <p class="text-2xl font-bold text-green-600">5</p>
                    </div>
                </div>

                <!-- Order Cards -->
                <div class="space-y-4">
                    <div class="order-card order-pending rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">#ORD-001 - Raj Patel</h3>
                                <p class="text-sm text-gray-500">📞 9876543210 | 📅 2026-02-10</p>
                                <p class="text-sm mt-1">ThumsUp-250 x5, Sprite-250 x3</p>
                            </div>
                            <div class="text-right">
                                <span class="status-badge badge-pending">Pending</span>
                                <p class="text-lg font-bold mt-2">₹4,100</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-card order-processing rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">#ORD-002 - Amit Shah</h3>
                                <p class="text-sm text-gray-500">📞 8765432109 | 📅 2026-02-11</p>
                                <p class="text-sm mt-1">Fanta-250 x10, Maaza-250 x5</p>
                            </div>
                            <div class="text-right">
                                <span class="status-badge badge-processing">Processing</span>
                                <p class="text-lg font-bold mt-2">₹6,050</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-card order-delivered rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">#ORD-003 - Neha Sharma</h3>
                                <p class="text-sm text-gray-500">📞 7654321098 | 📅 2026-02-09</p>
                                <p class="text-sm mt-1">Coca-Cola-250 x20</p>
                            </div>
                            <div class="text-right">
                                <span class="status-badge badge-delivered">Delivered</span>
                                <p class="text-lg font-bold mt-2">₹10,400</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-card order-shipped rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">#ORD-004 - Priya Desai</h3>
                                <p class="text-sm text-gray-500">📞 6543210987 | 📅 2026-02-12</p>
                                <p class="text-sm mt-1">Limca-250 x8, ThumsUp-250 x12</p>
                            </div>
                            <div class="text-right">
                                <span class="status-badge badge-shipped">Shipped</span>
                                <p class="text-lg font-bold mt-2">₹9,920</p>
                            </div>
                        </div>
                    </div>
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
