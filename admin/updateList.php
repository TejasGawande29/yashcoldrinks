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
    <!-- taliwindcss -->
    <link rel="stylesheet" href="output.css">
    <!-- jquery -->
    <script src="/YashColdrinks/assets/js/jquery.js"></script>
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

    <title>Dashboard</title>
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
                      <i data-lucide="settings" class="w-5 h-5"></i>
                    </span>
                    Update Dashboard
                  </h1>
                  <p class="text-gray-500 mt-1 ml-13">Manage products, agencies, and counters.</p>
                </div>
                
                <script>lucide.createIcons();</script>

                <!-- Input Sections -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                    <!-- Product Input -->
                    <div class="bg-gradient-to-br from-violet-50 to-purple-50 rounded-2xl border border-violet-100 p-6">
                        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i data-lucide="package" class="w-5 h-5 text-violet-500"></i>
                            Add Product
                        </h3>
                        <input
                            type="text"
                            id="productName"
                            placeholder="Enter Product Name"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-violet-500 focus:outline-none transition-all mb-4">
                        <button
                            onclick="addProductName();"
                            class="w-full bg-gradient-to-r from-violet-500 to-purple-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-violet-500/30 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add Product
                        </button>
                    </div>

                    <!-- Agency Input -->
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl border border-teal-100 p-6">
                        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i data-lucide="building-2" class="w-5 h-5 text-teal-500"></i>
                            Add Agency
                        </h3>
                        <input
                            type="text"
                            id="agencyName"
                            placeholder="Enter Agency Name"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-teal-500 focus:outline-none transition-all mb-4">
                        <button
                            onclick="addAgencyName();"
                            class="w-full bg-gradient-to-r from-teal-500 to-cyan-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-teal-500/30 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add Agency
                        </button>
                    </div>
                    <!-- Conter Input -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-100 p-6">
                        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i data-lucide="store" class="w-5 h-5 text-amber-500"></i>
                            Add Counter
                        </h3>
                        <input
                            type="text"
                            id="countername"
                            placeholder="Enter Counter Name"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-amber-500 focus:outline-none transition-all mb-4">
                        <button
                            onclick="addCounterName();"
                            class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-amber-500/30 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add Counter
                        </button>
                    </div>
                </div>

                <!-- Tables -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">

                    <!-- Product Table -->
<div class="rounded-2xl overflow-hidden shadow-xl bg-white/80 backdrop-blur p-6 border border-gray-200 hover:shadow-2xl transition h-full flex flex-col min-h-[300px]">
    <h2 class="text-2xl font-bold text-center mb-4 text-violet-700">🧾 Product List</h2>
    <table id="prductNameList" class="display w-full text-sm text-gray-700"></table>
</div>


                    <!-- Agency Table -->
                    <div class="rounded-2xl overflow-hidden shadow-xl bg-white/80 backdrop-blur p-6 border border-gray-200 hover:shadow-2xl transition">
                        <h2 class="text-2xl font-bold text-center mb-4 text-teal-700">🏢 Agency List</h2>
                        <table id="agencyList" class="display w-full text-sm text-gray-700"></table>
                    </div>
                    <!-- Counter Table -->
                    <div class="rounded-2xl overflow-hidden shadow-xl bg-white/80 backdrop-blur p-6 border border-gray-200 hover:shadow-2xl transition h-full flex flex-col min-h-[300px]">
                        <h2 class="text-2xl font-bold text-center mb-4 text-red-700">🎯 Counter List</h2>
                        <table id="counterList" class="display w-full text-sm text-gray-700"></table>
                    </div>



                </div>
            </div>
        </div>
    </section>



    <!-- Tailwind Custom Animations -->
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

        @keyframes fade-in-left {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fade-in-right {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.6s ease-out both;
        }

        .animate-fade-in-left {
            animation: fade-in-left 0.6s ease-out both;
        }

        .animate-fade-in-right {
            animation: fade-in-right 0.6s ease-out both;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out both;
        }
    </style>

    <script>
        var tableData = "";

        function addAgencyName() {
            if (agencyName.value != "") {
                $.ajax({
                    url: "functions.php",
                    type: "POST",
                    data: {
                        "RESULT_TYPE": "ADD_AGENCY_NAME",
                        "AGENCYNAME": agencyName.value
                    },
                    success: function(res) {
                        console.log(res);
                        console.log("rspn");
                        var jobj = JSON.parse(res);
                        toastr.success(jobj.message);



                        $.ajax({
                            url: "functions.php",
                            type: "POST",
                            data: {
                                "RESULT_TYPE": "SHOW_INSERTED_AGENCYNAME"
                            },
                            success: function(res) {
                                console.log(res);

                                var jobj = JSON.parse(res);

                                tableData = jobj;
                                const table = $('#agencyList').DataTable();
                                table.clear().rows.add(tableData).draw();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            }

                        });
                    }
                });
            } else {
                toastr.error("Please Select All Filds....!");
            }
        }

        function addProductName() {
            if (productName.value != "") {
                $.ajax({
                    url: "functions.php",
                    type: "POST",
                    data: {
                        "RESULT_TYPE": "ADD_PRODUCT_NAME",
                        "PRODUCTNAME": productName.value
                    },
                    success: function(res) {
                        console.log(res);
                        console.log("rspn");
                        var jobj = JSON.parse(res);
                        toastr.success(jobj.message);



                        $.ajax({
                            url: "functions.php",
                            type: "POST",
                            data: {
                                "RESULT_TYPE": "SHOW_INSERTED_PRODUCTLIST"
                            },
                            success: function(res) {
                                console.log(res);

                                var jobj = JSON.parse(res);

                                tableData = jobj;
                                const table = $('#prductNameList').DataTable();
                                table.clear().rows.add(tableData).draw();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            }

                        });
                    }
                });
            } else {
                toastr.error("Please Select All Filds....!");
            }
        }

        function addCounterName() {
            if (countername.value != "") {
                $.ajax({
                    url: "functions.php",
                    type: "POST",
                    data: {
                        "RESULT_TYPE": "ADD_COUNTER_NAME",
                        "COUNTERNAME": countername.value
                    },
                    success: function(res) {
                        console.log(res);
                        console.log("rspn");
                        var jobj = JSON.parse(res);
                        toastr.success(jobj.message);



                        $.ajax({
                            url: "functions.php",
                            type: "POST",
                            data: {
                                "RESULT_TYPE": "SHOW_INSERTED_COUNTERNAME"
                            },
                            success: function(res) {
                                console.log(res);
                                var jobj = JSON.parse(res);
                                console.log("Response");

                                tableData = jobj;
                                const table = $('#counterList').DataTable();
                                table.clear().rows.add(tableData).draw();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            }

                        });
                    }
                });
            } else {
                toastr.error("Please Select All Filds....!");
            }
        }

        $(document).ready(function() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "SHOW_INSERTED_PRODUCTLIST"
                },
                success: function(res) {
                    var jobj = JSON.parse(res);
                    tableData = jobj;
                    console.log(tableData)
                    $('#prductNameList').DataTable({
                        columns: [{
                                title: 'id'
                            },
                            {
                                title: 'productName'
                            }
                        ],
                        data: tableData
                    });
                }
            });
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "SHOW_INSERTED_AGENCYNAME"
                },
                success: function(res) {
                    var jobj = JSON.parse(res);
                    tableData = jobj;
                    console.log(tableData)
                    $('#agencyList').DataTable({
                        columns: [{
                                title: 'id'
                            },
                            {
                                title: 'AgencyName'
                            }
                        ],
                        data: tableData
                    });
                }
            });
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "SHOW_INSERTED_COUNTERNAME"
                },
                success: function(res) {
                    var jobj = JSON.parse(res);
                    tableData = jobj;
                    console.log(tableData)
                    $('#counterList').DataTable({
                        columns: [{
                                title: 'id'
                            },
                            {
                                title: 'CounterName'
                            }
                        ],
                        data: tableData
                    });
                }
            });


        });
    </script>

</body>

</html>