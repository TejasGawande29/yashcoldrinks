<?php
session_start();
if (isset($_SESSION["USERNAME"]) && isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] == "admin") {
    // User is authenticated
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
    <title>Update Dashboard</title>
    <style>
        @keyframes fade-in-down { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fade-in-left { 0% { opacity: 0; transform: translateX(-20px); } 100% { opacity: 1; transform: translateX(0); } }
        @keyframes fade-in-right { 0% { opacity: 0; transform: translateX(20px); } 100% { opacity: 1; transform: translateX(0); } }
        @keyframes fade-in-up { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-down { animation: fade-in-down 0.6s ease-out both; }
        .animate-fade-in-left { animation: fade-in-left 0.6s ease-out both; }
        .animate-fade-in-right { animation: fade-in-right 0.6s ease-out both; }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out both; }
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
                    🚀 Update Dashboard
                </h1>

                <!-- Demo Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 text-center animate-fade-in-down">
                    <p class="text-amber-700 font-medium">⚠️ Demo Mode - This page shows the UI layout only. Backend functionality is under development.</p>
                </div>

                <!-- Input Sections -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Product Input -->
                    <div class="flex flex-col items-center gap-5 animate-fade-in-left">
                        <input type="text" id="productName" placeholder="Enter Product Name"
                            class="w-full max-w-md px-5 py-3 border border-gray-300 rounded-2xl shadow-inner text-lg bg-white/90 focus:ring-4 focus:ring-violet-400 focus:outline-none transition-transform duration-300 hover:scale-105 placeholder-gray-500">
                        <button onclick="toastr.info('Demo mode - Feature under development')"
                            class="bg-gradient-to-r from-teal-400 to-violet-500 text-white font-semibold px-6 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            + Add Product
                        </button>
                    </div>

                    <!-- Agency Input -->
                    <div class="flex flex-col items-center gap-5 animate-fade-in-right">
                        <input type="text" id="agencyName" placeholder="Enter Agency Name"
                            class="w-full max-w-md px-5 py-3 border border-gray-300 rounded-2xl shadow-inner text-lg bg-white/90 focus:ring-4 focus:ring-teal-400 focus:outline-none transition-transform duration-300 hover:scale-105 placeholder-gray-500">
                        <button onclick="toastr.info('Demo mode - Feature under development')"
                            class="bg-gradient-to-r from-violet-400 to-teal-500 text-white font-semibold px-6 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            + Add Agency
                        </button>
                    </div>

                    <!-- Counter Input -->
                    <div class="flex flex-col items-center gap-5 animate-fade-in-right">
                        <input type="text" id="countername" placeholder="Enter Counter Name"
                            class="w-full max-w-md px-5 py-3 border border-gray-300 rounded-2xl shadow-inner text-lg bg-white/90 focus:ring-4 focus:ring-teal-400 focus:outline-none transition-transform duration-300 hover:scale-105 placeholder-gray-500">
                        <button onclick="toastr.info('Demo mode - Feature under development')"
                            class="bg-gradient-to-r from-violet-400 to-teal-500 text-white font-semibold px-6 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            + Add Counter
                        </button>
                    </div>
                </div>

                <!-- Tables -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-14 animate-fade-in-up">
                    <!-- Product Table -->
                    <div class="rounded-2xl overflow-hidden shadow-xl bg-white/80 backdrop-blur p-6 border border-gray-200 hover:shadow-2xl transition h-full flex flex-col min-h-[300px]">
                        <h2 class="text-2xl font-bold text-center mb-4 text-violet-700">🧾 Product List</h2>
                        <table id="productNameList" class="display w-full text-sm text-gray-700">
                            <thead>
                                <tr><th>ID</th><th>Product Name</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>ThumsUp-250</td></tr>
                                <tr><td>2</td><td>Sprite-250</td></tr>
                                <tr><td>3</td><td>Fanta-250</td></tr>
                                <tr><td>4</td><td>Coca-Cola-250</td></tr>
                                <tr><td>5</td><td>Limca-250</td></tr>
                                <tr><td>6</td><td>Maaza-250</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Agency Table -->
                    <div class="rounded-2xl overflow-hidden shadow-xl bg-white/80 backdrop-blur p-6 border border-gray-200 hover:shadow-2xl transition">
                        <h2 class="text-2xl font-bold text-center mb-4 text-teal-700">🏢 Agency List</h2>
                        <table id="agencyList" class="display w-full text-sm text-gray-700">
                            <thead>
                                <tr><th>ID</th><th>Agency Name</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>Coca-Cola Distributors</td></tr>
                                <tr><td>2</td><td>PepsiCo Agency</td></tr>
                                <tr><td>3</td><td>Local Traders</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Counter Table -->
                    <div class="rounded-2xl overflow-hidden shadow-xl bg-white/80 backdrop-blur p-6 border border-gray-200 hover:shadow-2xl transition h-full flex flex-col min-h-[300px]">
                        <h2 class="text-2xl font-bold text-center mb-4 text-red-700">🎯 Counter List</h2>
                        <table id="counterList" class="display w-full text-sm text-gray-700">
                            <thead>
                                <tr><th>ID</th><th>Counter Name</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>Counter 1</td></tr>
                                <tr><td>2</td><td>Counter 2</td></tr>
                                <tr><td>3</td><td>Counter 3</td></tr>
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
            $('#productNameList').DataTable({ pageLength: 10 });
            $('#agencyList').DataTable({ pageLength: 10 });
            $('#counterList').DataTable({ pageLength: 10 });
        });
    </script>
</body>
</html>
