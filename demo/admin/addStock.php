<?php
session_start();
if (isset($_SESSION["USERNAME"]) && isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] == "admin" || $_SESSION["ROLE"] == "manager")) {
  // User is authenticated
} else {
  header("Location: adminlogin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Stock</title>
  <!-- Tailwind CSS -->
  <link href="output.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen text-gray-800">

  <section class="max-w-[1500px] mx-auto p-4 grid lg:grid-cols-[20%_auto] gap-6">
    <!-- Sidebar -->
    <?php include_once("layouts/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="bg-white bg-opacity-80 backdrop-blur-md shadow-xl rounded-2xl p-6 lg:p-8 transition-all duration-300 hover:shadow-2xl">
      <h1 class="text-3xl font-bold text-blue-700 text-center mb-8 text-shadow-md">📦 Add New Stock</h1>

      <!-- Form -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
        <select id="productname" class="form-select">
          <option value="">🧃 Select Product</option>
        </select>

        <input type="number" id="quantity" value="" placeholder="📦 Total Boxes" class="form-input" />
        <input type="number" id="bottles" value="" placeholder="🍾 Bottles Per Box" class="form-input" />
        <input type="number" value="" id="priceperbox" placeholder="💰 Price Per Box" class="form-input" />
        <input type="number" id="totalbillamount" placeholder="🧾 Total Bill Amount" class="form-input" disabled />

        <select id="agencyname" class="form-select">
          <option value="">🏢 Select Agency</option>
        </select>

       
        <select id="paymentmode" class="form-select" onchange="getInputBox(this);">
          <option value="SelectPayment">🏢 Payment Mode</option>
          <option value="Cash">Cash</option>
          <option value="PhonePe">PhonePe</option>
          <option value="PartialCash">Partial-Cash</option>
          <option value="PartialPhonePe">Partial-PhonePe</option>
          <option value="Unpaid">Unpaid</option>
        </select>
        <input type="number" id="partialpayment" value="0" class="form-input" placeholder="📅 Rs" hidden/>
      </div>

      <!-- Add Stock Button -->
      <div class="text-center mt-6">
        <button onclick="addStock()"
          class="bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-500 hover:to-emerald-600 text-white text-lg font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-300">
          ➕ Add Stock
        </button>
      </div>

      <!-- Table -->
      <div class="mt-10">
        <table id="addStockTable" class="display w-full text-sm rounded-md overflow-hidden"></table>
      </div>
    </div>
  </section>
  <script>
    function updateTotalBill() {
      const quantity = parseFloat(document.getElementById("quantity").value) || 0;
      const pricePerBox = parseFloat(document.getElementById("priceperbox").value) || 0;
      const total = quantity * pricePerBox;
      document.getElementById("totalbillamount").value = total.toFixed(0);
    }

    document.getElementById("quantity").addEventListener("input", updateTotalBill);
    document.getElementById("priceperbox").addEventListener("input", updateTotalBill);
  </script>

  <!-- Styles for Inputs -->
  <style>
    .form-input,
    .form-select {
      width: 100%;
      border-radius: 0.5rem;
      border: 1px solid #d1d5db;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
      padding: 0.75rem;
      font-size: 1rem;
      color: #6b7280;
      transition: all 0.3s;
    }

    .form-input:focus,
    .form-select:focus {
      outline: none;
      box-shadow: 0 0 0 2px #60a5fa;
      border-color: #60a5fa;
    }

    .form-input:hover,
    .form-select:hover {
      transform: scale(1.02);
    }

    .form-select {
      background-color: #ffffff;
    }
  </style>
<!-- Getinput box for partialpayment -->
<script>
  function getInputBox(ele){
    var inpbox = document.getElementById('partialpayment');
    
   if(ele.value == 'PartialCash' || (ele.value == 'PartialPhonePe')){
    inpbox.hidden = false;
    inpbox.classList.add('bg-red-100');
   }else{
    inpbox.hidden = true;
   }
  
  }
</script>
  <!-- JavaScript to Populate Dropdowns and Handle Form Submission -->
  <script>
    // Populate Product Dropdown
    $.post("functions.php", {
      RESULT_TYPE: "GET_PRODUCT_NAME"
    }, function(res) {
      let data = JSON.parse(res);
      data.forEach(item => {
        $('#productname').append(new Option(item[1], item[1]));
      });
    });

    // Populate Agency Dropdown
    $.post("functions.php", {
      RESULT_TYPE: "GET_AGENCY_NAME"
    }, function(res) {
      let data = JSON.parse(res);
      data.forEach(item => {
        $('#agencyname').append(new Option(item[1], item[1]));
      });
    });

    // Add Stock Function
    function addStock() {
      const productname = $('#productname').val();
      const quantity = $('#quantity').val();
      const bottles = $('#bottles').val();
      const priceperbox = $('#priceperbox').val();
      const totalbillamount = $('#totalbillamount').val();
      const agencyname = $('#agencyname').val();
      const partialpayment = $('#partialpayment').val();
      const paymentmode = $('#paymentmode').val();

      if (productname && quantity && bottles && priceperbox && totalbillamount && agencyname && paymentmode) {
        $.post("functions.php", {
            RESULT_TYPE: "INSERT_STOCK",
            PRODUCTNAME: productname,
            QUANTITY: quantity,
            BOTTLES: bottles,
            PRICEPERBOX: priceperbox,
            TOTALBILLAMOUNT: totalbillamount,
            AGENCYNAME: agencyname,
            PARTIALPAYMENT: partialpayment,
            PAYMENTMODE: paymentmode
          },
          function(res) {
            const response = JSON.parse(res);
            toastr.success(response.message);
            setTimeout(() => {
              window.location.reload();
            }, 500);
            loadStockTable();
          });
      } else {
        toastr.error("Please fill in all fields.");
      }
    }

    // Load Stock Table
    function loadStockTable() {
      $.post("functions.php", {
        RESULT_TYPE: "SHOW_INSERTED_STOCK"
      }, function(res) {
        const data = JSON.parse(res);
        $('#addStockTable').DataTable({
          data: data,
          destroy: true,
          columns: [{
              title: 'ID'
            },
            {
              title: 'Product Name'
            },
            {
              title: 'Quantity'
            },
            {
              title: 'Bottles'
            },
            {
              title: 'Price Per Box'
            },
            {
              title: 'Total Bill Amount'
            },
            {
              title: 'Agency Name'
            },
            {
              title: 'Date'
            }
          ]
        });
      });
    }

    // Initialize Table on Document Ready
    $(document).ready(function() {
      loadStockTable();
    });
  </script>

</body>

</html>
