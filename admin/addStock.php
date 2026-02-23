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
  <!-- Tailwind CSS v4 -->
  <link href="output.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="/YashColdrinks/assets/js/jquery.js"></script>
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

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen text-gray-800">

  <section class="max-w-screen-2xl mx-auto p-4 lg:p-6">
    <div class="flex flex-col lg:flex-row gap-6">
    <!-- Sidebar -->
    <?php include_once("layouts/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="flex-1 min-w-0 bg-white shadow-xl rounded-2xl p-6 lg:p-8 transition-all duration-300">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
          <span class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
            <i data-lucide="package-plus" class="w-5 h-5"></i>
          </span>
          Add New Stock
        </h1>
        <p class="text-gray-500 mt-1 ml-13">Add new inventory items to your stock.</p>
      </div>

      <!-- Form Card -->
      <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="package" class="w-4 h-4 text-blue-500"></i>
              Product
            </label>
            <select id="productname" class="form-select" onchange="handleDropdownChange(this, 'product')">
              <option value="">Select Product</option>
              <option value="__add_new__" class="text-blue-600 font-medium">+ Add New Product...</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="boxes" class="w-4 h-4 text-blue-500"></i>
              Total Boxes
            </label>
            <input type="number" id="quantity" value="" placeholder="Enter quantity" class="form-input" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="wine" class="w-4 h-4 text-blue-500"></i>
              Bottles Per Box (ml)
            </label>
            <input type="number" id="bottles" value="" placeholder="e.g. 250, 500, 1000" class="form-input" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="indian-rupee" class="w-4 h-4 text-blue-500"></i>
              Price Per Box
            </label>
            <input type="number" value="" id="priceperbox" placeholder="Price per box" class="form-input" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="receipt" class="w-4 h-4 text-green-500"></i>
              Total Bill Amount
            </label>
            <input type="number" id="totalbillamount" placeholder="Auto calculated" class="form-input bg-green-50 font-semibold text-green-700" disabled />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="building-2" class="w-4 h-4 text-blue-500"></i>
              Agency
            </label>
            <select id="agencyname" class="form-select" onchange="handleDropdownChange(this, 'agency')">
              <option value="">Select Agency</option>
              <option value="__add_new__" class="text-emerald-600 font-medium">+ Add New Agency...</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="hash" class="w-4 h-4 text-purple-500"></i>
              Batch Number
            </label>
            <input type="text" id="batchnumber" value="" placeholder="e.g. BATCH-2026-001" class="form-input" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="calendar-clock" class="w-4 h-4 text-red-500"></i>
              Expiry Date
            </label>
            <input type="date" id="expirydate" class="form-input" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
              Low Stock Alert (Boxes)
            </label>
            <input type="number" id="lowstockthreshold" value="5" placeholder="Alert when below" class="form-input" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="credit-card" class="w-4 h-4 text-blue-500"></i>
              Payment Mode
            </label>
            <select id="paymentmode" class="form-select" onchange="getInputBox(this);">
              <option value="SelectPayment">Select Payment</option>
              <option value="Cash">Cash</option>
              <option value="PhonePe">PhonePe</option>
              <option value="PartialCash">Partial-Cash</option>
              <option value="PartialPhonePe">Partial-PhonePe</option>
              <option value="Unpaid">Unpaid</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
              <i data-lucide="wallet" class="w-4 h-4 text-orange-500"></i>
              Partial Amount
            </label>
            <input type="number" id="partialpayment" value="0" class="form-input" placeholder="Enter amount" hidden/>
          </div>
        </div>

        <!-- Add Stock Button -->
        <div class="text-center mt-6">
          <button onclick="addStock()"
            class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white text-base font-semibold px-8 py-3 rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl transition-all transform hover:scale-105 duration-300 flex items-center gap-2 mx-auto">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Add Stock
          </button>
        </div>
      </div>

      <!-- Low Stock Alerts -->
      <div id="lowStockAlerts" class="hidden mb-8 bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl p-6 border border-red-200">
        <h2 class="text-lg font-semibold text-red-700 flex items-center gap-2 mb-4">
          <i data-lucide="alert-triangle" class="w-5 h-5"></i>
          Low Stock Alerts
        </h2>
        <div id="lowStockList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3"></div>
      </div>

      <!-- Recent Stock Table -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-violet-500 to-purple-500 p-4">
          <h2 class="text-lg font-semibold text-white flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5"></i>
            Recently Added Stock
          </h2>
        </div>
        <div class="p-4 overflow-x-auto">
          <table id="addStockTable" class="display w-full text-sm"></table>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Edit Stock Modal -->
  <div id="editStockModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 m-4">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
          <i data-lucide="edit" class="w-5 h-5 text-violet-500"></i>
          Edit Stock Entry
        </h3>
        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>
      <input type="hidden" id="editStockId">
      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Product Name</label>
          <input type="text" id="editProductname" class="form-input" readonly />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Quantity (Boxes)</label>
          <input type="number" id="editQuantity" class="form-input" />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">ML</label>
          <input type="number" id="editMl" class="form-input" />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Price Per Box</label>
          <input type="number" id="editPriceperbox" class="form-input" />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Batch Number</label>
          <input type="text" id="editBatchnumber" class="form-input" />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Expiry Date</label>
          <input type="date" id="editExpirydate" class="form-input" />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Low Stock Threshold</label>
          <input type="number" id="editLowstockthreshold" class="form-input" />
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Agency</label>
          <input type="text" id="editAgencyname" class="form-input" readonly />
        </div>
      </div>
      <div class="flex justify-end gap-3 mt-6">
        <button onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all">Cancel</button>
        <button onclick="updateStock()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-violet-500 to-purple-500 text-white hover:shadow-lg transition-all">Update Stock</button>
      </div>
    </div>
  </div>

  <!-- Add New Product/Agency Modal -->
  <div id="addNewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 m-4 transform transition-all">
      <div class="flex justify-between items-center mb-6">
        <h3 id="addModalTitle" class="text-xl font-bold text-gray-800 flex items-center gap-2">
          <span id="addModalIcon" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-lg">
            <i data-lucide="plus" class="w-5 h-5"></i>
          </span>
          <span id="addModalTitleText">Add New Item</span>
        </h3>
        <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 hover:rotate-90 transition-all">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>
      
      <input type="hidden" id="addModalType" value="">
      
      <div class="space-y-4">
        <div class="space-y-2">
          <label id="addModalLabel" class="text-sm font-medium text-gray-700 flex items-center gap-2">
            <i data-lucide="tag" class="w-4 h-4 text-blue-500"></i>
            Name
          </label>
          <input type="text" id="addModalInput" class="form-input" placeholder="Enter name..." onkeypress="handleAddModalKeypress(event)" />
        </div>
        
        <p id="addModalHint" class="text-xs text-gray-500 bg-gray-50 p-3 rounded-xl">
          <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
          This will be added to the dropdown and saved to the database.
        </p>
      </div>
      
      <div class="flex justify-end gap-3 mt-6">
        <button onclick="closeAddModal()" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all font-medium">
          Cancel
        </button>
        <button id="addModalSubmitBtn" onclick="submitAddModal()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white hover:shadow-lg hover:scale-105 transition-all font-medium flex items-center gap-2">
          <i data-lucide="plus-circle" class="w-4 h-4"></i>
          Add
        </button>
      </div>
    </div>
  </div>
  
  <script>
    lucide.createIcons();
  </script>
  <script>
    // To calculate Real time Bill amount

    function updateTotalBill() {
      const quantity = parseFloat(document.getElementById("quantity").value) || 0;
      const pricePerBox = parseFloat(document.getElementById("priceperbox").value) || 0;
      const total = quantity * pricePerBox;
      document.getElementById("totalbillamount").value = total.toFixed(0); // optional: keep 2 decimals
    }

    // Add real-time event listeners
    document.getElementById("quantity").addEventListener("input", updateTotalBill);
    document.getElementById("priceperbox").addEventListener("input", updateTotalBill);
  </script>

  <!-- Add New Product/Agency Functions -->
  <script>
    function openAddModal(type) {
      const modal = document.getElementById('addNewModal');
      const titleText = document.getElementById('addModalTitleText');
      const label = document.getElementById('addModalLabel');
      const input = document.getElementById('addModalInput');
      const icon = document.getElementById('addModalIcon');
      const submitBtn = document.getElementById('addModalSubmitBtn');
      const hint = document.getElementById('addModalHint');
      
      document.getElementById('addModalType').value = type;
      input.value = '';
      
      if (type === 'product') {
        titleText.textContent = 'Add New Product';
        label.innerHTML = '<i data-lucide="package" class="w-4 h-4 text-blue-500"></i> Product Name';
        input.placeholder = 'e.g. Coca Cola, Pepsi, Sprite...';
        icon.className = 'w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-lg';
        submitBtn.className = 'px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white hover:shadow-lg hover:scale-105 transition-all font-medium flex items-center gap-2';
        hint.innerHTML = '<i data-lucide="info" class="w-4 h-4 inline mr-1"></i> Add a new product to your inventory catalog.';
      } else if (type === 'agency') {
        titleText.textContent = 'Add New Agency';
        label.innerHTML = '<i data-lucide="building-2" class="w-4 h-4 text-emerald-500"></i> Agency Name';
        input.placeholder = 'e.g. Coca Cola Distributors, Local Agency...';
        icon.className = 'w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center text-white shadow-lg';
        submitBtn.className = 'px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-green-500 text-white hover:shadow-lg hover:scale-105 transition-all font-medium flex items-center gap-2';
        hint.innerHTML = '<i data-lucide="info" class="w-4 h-4 inline mr-1"></i> Add a new supplier/agency for stock purchases.';
      }
      
      modal.classList.remove('hidden');
      lucide.createIcons();
      
      // Focus input after modal opens
      setTimeout(() => input.focus(), 100);
    }
    
    function closeAddModal() {
      document.getElementById('addNewModal').classList.add('hidden');
      document.getElementById('addModalInput').value = '';
    }
    
    function handleAddModalKeypress(event) {
      if (event.key === 'Enter') {
        submitAddModal();
      }
    }
    
    function submitAddModal() {
      const type = document.getElementById('addModalType').value;
      const input = document.getElementById('addModalInput');
      const name = input.value.trim();
      
      if (!name) {
        toastr.warning('Please enter a name');
        input.focus();
        return;
      }
      
      // Disable button during submission
      const submitBtn = document.getElementById('addModalSubmitBtn');
      const originalContent = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Adding...';
      lucide.createIcons();
      
      if (type === 'product') {
        $.post("functions.php", {
          RESULT_TYPE: "ADD_PRODUCT_NAME",
          PRODUCTNAME: name
        }, function(res) {
          const response = JSON.parse(res);
          if (response.result === 1 || response.success) {
            toastr.success('Product "' + name + '" added successfully!');
            // Add to dropdown before "Add New" option and select it
            const addNewOption = $('#productname option[value="__add_new__"]');
            addNewOption.before(new Option(name, name, true, true));
            closeAddModal();
          } else {
            toastr.error(response.message || 'Failed to add product');
          }
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalContent;
          lucide.createIcons();
        }).fail(function() {
          toastr.error('Connection error. Please try again.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalContent;
          lucide.createIcons();
        });
      } else if (type === 'agency') {
        $.post("functions.php", {
          RESULT_TYPE: "ADD_AGENCY_NAME",
          AGENCYNAME: name
        }, function(res) {
          const response = JSON.parse(res);
          if (response.result === 1 || response.success) {
            toastr.success('Agency "' + name + '" added successfully!');
            // Add to dropdown before "Add New" option and select it
            const addNewOption = $('#agencyname option[value="__add_new__"]');
            addNewOption.before(new Option(name, name, true, true));
            closeAddModal();
          } else {
            toastr.error(response.message || 'Failed to add agency');
          }
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalContent;
          lucide.createIcons();
        }).fail(function() {
          toastr.error('Connection error. Please try again.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalContent;
          lucide.createIcons();
        });
      }
    }
    
    // Close modal on backdrop click
    document.getElementById('addNewModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeAddModal();
      }
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAddModal();
      }
    });
  </script>

  <!-- Styles for Inputs -->
  <style>
    .form-input,
    .form-select {
      width: 100%;
      border-radius: 0.75rem;
      border: 2px solid #e5e7eb;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      color: #374151;
      transition: all 0.3s ease;
      background-color: #ffffff;
    }

    .form-input:focus,
    .form-select:focus {
      outline: none;
      border-color: #8b5cf6;
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    .form-input:hover,
    .form-select:hover {
      border-color: #a78bfa;
    }

    .form-input::placeholder {
      color: #9ca3af;
    }

    .form-select {
      cursor: pointer;
    }
    
    /* DataTables styling */
    .dataTables_wrapper .dataTables_filter input {
      border: 2px solid #e5e7eb;
      border-radius: 0.5rem;
      padding: 0.5rem 1rem;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: #8b5cf6;
      outline: none;
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
  
  // Handle dropdown change for "Add New" option
  function handleDropdownChange(select, type) {
    if (select.value === '__add_new__') {
      select.value = ''; // Reset selection
      openAddModal(type);
    }
  }
</script>
  <!-- JavaScript to Populate Dropdowns and Handle Form Submission -->
  <script>
    // Populate Product Dropdown (insert before "Add New" option)
    $.post("functions.php", {
      RESULT_TYPE: "GET_PRODUCT_NAME"
    }, function(res) {
      let data = JSON.parse(res);
      const addNewOption = $('#productname option[value="__add_new__"]');
      data.forEach(item => {
        addNewOption.before(new Option(item[1], item[1]));
      });
    });

    // Populate Agency Dropdown (insert before "Add New" option)
    $.post("functions.php", {
      RESULT_TYPE: "GET_AGENCY_NAME"
    }, function(res) {
      let data = JSON.parse(res);
      const addNewOption = $('#agencyname option[value="__add_new__"]');
      data.forEach(item => {
        addNewOption.before(new Option(item[1], item[1]));
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
      const batchnumber = $('#batchnumber').val();
      const expirydate = $('#expirydate').val();
      const lowstockthreshold = $('#lowstockthreshold').val() || 5;

      if (productname && quantity && bottles && priceperbox && totalbillamount && agencyname && paymentmode !== 'SelectPayment') {
        $.post("functions.php", {
            RESULT_TYPE: "INSERT_STOCK",
            PRODUCTNAME: productname,
            QUANTITY: quantity,
            BOTTLES: bottles,
            PRICEPERBOX: priceperbox,
            TOTALBILLAMOUNT: totalbillamount,
            AGENCYNAME: agencyname,
            PARTIALPAYMENT: partialpayment,
            PAYMENTMODE: paymentmode,
            BATCHNUMBER: batchnumber,
            EXPIRYDATE: expirydate,
            LOWSTOCKTHRESHOLD: lowstockthreshold
          },
          function(res) {
            const response = JSON.parse(res);
            if (response.result === 1) {
              toastr.success(response.message);
              setTimeout(() => {
                window.location.reload();
              }, 500);
              loadStockTable();
            } else {
              toastr.error(response.message || 'Failed to add stock');
            }
          });
      } else {
        toastr.error("Please fill in all required fields.");
      }
    }

    // Load Stock Table with Edit/Delete buttons
    function loadStockTable() {
      $.post("functions.php", {
        RESULT_TYPE: "SHOW_INSERTED_STOCK"
      }, function(res) {
        const data = JSON.parse(res);
        $('#addStockTable').DataTable({
          data: data,
          destroy: true,
          columns: [
            { title: 'ID' },
            { title: 'Product' },
            { title: 'Qty' },
            { title: 'ML' },
            { title: '₹/Box' },
            { title: 'Total ₹' },
            { title: 'Agency' },
            { title: 'Batch' },
            { title: 'Expiry' },
            { title: 'Date' },
            { 
              title: 'Actions',
              render: function(data, type, row) {
                return `
                  <div class="flex gap-1">
                    <button onclick="editStock(${row[0]})" class="px-2 py-1 bg-blue-100 text-blue-600 rounded-lg text-xs hover:bg-blue-200">
                      <i data-lucide="edit" class="w-3 h-3 inline"></i>
                    </button>
                    <button onclick="deleteStock(${row[0]})" class="px-2 py-1 bg-red-100 text-red-600 rounded-lg text-xs hover:bg-red-200">
                      <i data-lucide="trash-2" class="w-3 h-3 inline"></i>
                    </button>
                  </div>
                `;
              }
            }
          ],
          drawCallback: function() {
            lucide.createIcons();
          }
        });
      });
      
      // Load low stock alerts
      loadLowStockAlerts();
    }

    // Load Low Stock Alerts
    function loadLowStockAlerts() {
      $.post("functions.php", { RESULT_TYPE: "GET_LOW_STOCK_ALERTS" }, function(res) {
        const data = JSON.parse(res);
        if (data.length > 0) {
          $('#lowStockAlerts').removeClass('hidden');
          let html = '';
          data.forEach(item => {
            const isExpiringSoon = item.days_until_expiry !== null && item.days_until_expiry <= 30;
            html += `
              <div class="bg-white rounded-xl p-3 border ${isExpiringSoon ? 'border-red-300' : 'border-orange-200'} flex justify-between items-center">
                <div>
                  <p class="font-semibold text-gray-800">${item.productname} (${item.ml}ml)</p>
                  <p class="text-sm text-gray-500">Only <span class="font-bold text-red-600">${item.quantity}</span> boxes left</p>
                  ${isExpiringSoon ? `<p class="text-xs text-red-500">⚠️ Expires in ${item.days_until_expiry} days</p>` : ''}
                </div>
                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">Low Stock</span>
              </div>
            `;
          });
          $('#lowStockList').html(html);
        } else {
          $('#lowStockAlerts').addClass('hidden');
        }
      });
    }

    // Edit Stock
    function editStock(id) {
      $.post("functions.php", { RESULT_TYPE: "GET_STOCK_BY_ID", STOCK_ID: id }, function(res) {
        const data = JSON.parse(res);
        if (data.success) {
          const stock = data.data;
          $('#editStockId').val(stock.id);
          $('#editProductname').val(stock.productname);
          $('#editQuantity').val(stock.quantity);
          $('#editMl').val(stock.ml);
          $('#editPriceperbox').val(stock.priceperbox);
          $('#editBatchnumber').val(stock.batch_number);
          $('#editExpirydate').val(stock.expiry_date);
          $('#editLowstockthreshold').val(stock.low_stock_threshold);
          $('#editAgencyname').val(stock.agencyname);
          $('#editStockModal').removeClass('hidden');
          lucide.createIcons();
        }
      });
    }

    function closeEditModal() {
      $('#editStockModal').addClass('hidden');
    }

    function updateStock() {
      const data = {
        RESULT_TYPE: "UPDATE_STOCK",
        STOCK_ID: $('#editStockId').val(),
        QUANTITY: $('#editQuantity').val(),
        ML: $('#editMl').val(),
        PRICEPERBOX: $('#editPriceperbox').val(),
        BATCHNUMBER: $('#editBatchnumber').val(),
        EXPIRYDATE: $('#editExpirydate').val(),
        LOWSTOCKTHRESHOLD: $('#editLowstockthreshold').val()
      };
      
      $.post("functions.php", data, function(res) {
        const response = JSON.parse(res);
        if (response.success) {
          toastr.success(response.message);
          closeEditModal();
          loadStockTable();
        } else {
          toastr.error(response.message);
        }
      });
    }

    // Delete Stock
    function deleteStock(id) {
      if (confirm('Are you sure you want to delete this stock entry?')) {
        $.post("functions.php", { RESULT_TYPE: "DELETE_STOCK", STOCK_ID: id }, function(res) {
          const response = JSON.parse(res);
          if (response.success) {
            toastr.success(response.message);
            loadStockTable();
          } else {
            toastr.error(response.message);
          }
        });
      }
    }

    // Initialize Table on Document Ready
    $(document).ready(function() {
      loadStockTable();
    });
  </script>

</body>

</html>