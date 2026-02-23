<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !in_array($_SESSION["ROLE"], ["admin", "manager"])) {
  header("Location: ../adminlogin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stock Dashboard</title>

  <!-- Tailwind CSS -->
  <link rel="stylesheet" href="output.css" />

  <!-- jQuery -->
  <script src="../js/jquery.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />

  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- SweetAlert (optional for alerts) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-white text-gray-900 font-sans transition-all duration-300 ease-in-out">

  <section class="max-w-full lg:max-w-[1500px] mx-auto min-h-screen p-4">
    <div class="grid lg:grid-cols-[20%_auto] gap-4">

      <!-- Sidebar: keep your sidebar exactly as is -->
      <?php include 'layouts/sidebar.php'; ?>

      <!-- Main content -->
      <div class="rounded-lg shadow-lg bg-sky-50 p-6 animate-fade-in">
        <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">📦 Total Stock Overview</h1>
        <div class="overflow-x-auto rounded-lg border border-blue-100">
          <table id="stock" class="display w-full text-sm"></table>
        </div>
      </div>

    </div>
  </section>

  <!-- Payment Modal -->
  <!-- Replace your existing payment modal with this code -->
  <div id="paymentModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-gray-600 bg-opacity-50">
    <div class="modal-content relative bg-white rounded-lg shadow-xl w-full max-w-md p-6">
      <div class="text-center">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Make Payment</h3>
        <div class="mt-4">
          <p class="text-sm text-gray-600">
            Product: <span id="modalProduct" class="font-medium"></span><br>
            Agency: <span id="modalAgency" class="font-medium"></span><br>
            Total Bill: <span id="modalTotal" class="font-medium"></span><br>
            Paid: <span id="modalPaid" class="font-medium"></span><br>
            Remaining: <span id="modalRemaining" class="font-bold text-blue-600"></span>
          </p>
          <form id="paymentForm" class="mt-6 space-y-4">
            <input type="hidden" id="stockId">
            <div>
              <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
              <input type="number" step="0.01" min="0" id="amount" name="amount"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
              <label for="method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
              <select id="method" name="method"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="Cash">Cash</option>
                <option value="PhonePe">PhonePe</option>
                <option value="Bank Transfer">Bank Transfer</option>
              </select>
            </div>
          </form>
        </div>
        <div class="mt-6 flex justify-center space-x-3">
          <button id="cancelPayment"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
            Cancel
          </button>
          <button id="submitPayment"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
            Submit Payment
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Payment Modal -->
  <div id="viewPaymentModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-gray-600 bg-opacity-50">
    <div class="modal-content relative bg-white rounded-lg shadow-xl w-full max-w-md p-6">
      <div class="text-center">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Details</h3>
        <div class="mt-4">
          <p class="text-sm text-gray-600 text-left">
            Product: <span id="viewProduct" class="font-medium"></span><br>
            Agency: <span id="viewAgency" class="font-medium"></span><br>
            Total Bill: ₹<span id="viewTotal" class="font-medium"></span><br>
            Paid Amount: ₹<span id="viewPaid" class="font-medium"></span><br>
            Payment Status: <span id="viewStatus" class="font-medium"></span><br>
            Payment Method: <span id="viewMethod" class="font-medium"></span><br>
            Payment Date: <span id="viewDate" class="font-medium"></span>
          </p>
        </div>
        <div class="mt-6 flex justify-center">
          <button id="closeViewModal"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
    // View payment details
    $(document).on('click', '.btn-view', function() {
      var id = $(this).data('id');

      $.ajax({
        url: 'functions.php',
        type: 'POST',
        data: {
          RESULT_TYPE: 'GET_PAYMENT_DETAILS',
          stock_id: id
        },
        success: function(response) {
          var res = JSON.parse(response);
          if (res.success) {
            $('#viewProduct').text(res.data.productname);
            $('#viewAgency').text(res.data.agencyname);
            $('#viewTotal').text(parseFloat(res.data.totalbillamount).toFixed(2));
            $('#viewPaid').text(parseFloat(res.data.paid_amount).toFixed(2));
            $('#viewStatus').text(res.data.payment_status);
            $('#viewMethod').text(res.data.payment_mode || 'N/A');
            $('#viewDate').text(res.data.payment_date || 'N/A');
            $('#viewPaymentModal').removeClass('hidden').addClass('flex');
          } else {
            toastr.error(res.message);
          }
        },
        error: function() {
          toastr.error('Error loading payment details');
        }
      });
    });

    $('#closeViewModal').click(function() {
      $('#viewPaymentModal').removeClass('flex').addClass('hidden');
    });
    $(document).ready(function() {
      var table;

      function loadStockData() {
        $.ajax({
          url: "functions.php",
          type: "POST",
          data: {
            "RESULT_TYPE": "GET_TOTAL_STOCK"
          },
          success: function(res) {
            const jobj = JSON.parse(res);
            console.log(jobj);

            if ($.fn.DataTable.isDataTable('#stock')) {
              table.destroy();
            }

            table = new DataTable("#stock", {
              data: jobj,
              columns: [{
                  data: 'id',
                  title: 'ID',
                  visible: true
                }, // CHANGED: Made ID visible
                {
                  data: 'productname',
                  title: 'Product Name'
                },
                {
                  data: 'quantity',
                  title: 'Quantity'
                },
                {
                  data: 'totalbillamount',
                  title: 'Total Bill Amount',
                  render: DataTable.render.number(',', '.', 2)
                },
                {
                  data: 'paid_amount',
                  title: 'Paid Amount',
                  render: DataTable.render.number(',', '.', 2)
                },
                {
                  data: 'payment_status',
                  title: 'Payment Status'
                },
                {
                  data: 'agencyname',
                  title: 'Agency Name'
                },
                {
                  data: null,
                  title: 'Action',
                  render: function(data, type, row) {
                    let buttons = '';
                    if (row.payment_status === 'Unpaid' || row.payment_status === 'Partial') {
                      buttons += '<button class="btn-pay bg-blue-500 text-white px-2 py-1 rounded mr-2" data-id="' + row.id + '" data-product="' + row.productname + '" data-agency="' + row.agencyname + '" data-total="' + row.totalbillamount + '" data-paid="' + row.paid_amount + '">Pay</button>';
                    }

                    if (row.paid_amount > 0) {
                      buttons += '<button class="btn-view bg-green-500 text-white px-2 py-1 rounded" data-id="' + row.id + '">View</button>';
                    }
                    return buttons;
                  }
                },
                {
                  data: 'buydate',
                  title: 'Buy Date'
                }
              ],
              responsive: true
            });
          },
          error: function() {
            toastr.error("Failed to load stock data.");
          }
        });
      }

      loadStockData();

      // Payment modal handling
      $(document).on('click', '.btn-pay', function() {
        var id = $(this).data('id');
        var product = $(this).data('product');
        var agency = $(this).data('agency');
        var total = parseFloat($(this).data('total'));
        var paid = parseFloat($(this).data('paid'));
        var remaining = total - paid;

        console.log("Payment button clicked:", id, product, agency, total, paid, remaining); // Debug log

        $('#stockId').val(id);
        $('#modalProduct').text(product);
        $('#modalAgency').text(agency);
        $('#modalTotal').text(total.toFixed(2));
        $('#modalPaid').text(paid.toFixed(2));
        $('#modalRemaining').text(remaining.toFixed(2));

        // Set max for amount input
        $('#amount').attr('max', remaining);
        $('#amount').val(remaining); // Default to remaining amount

        $('#paymentModal').removeClass('hidden').addClass('flex');
      });

      $('#cancelPayment').click(function() {
        $('#paymentModal').removeClass('flex').addClass('hidden');
      });
      $('#submitPayment').click(function(e) {
        e.preventDefault();
        var stockId = $('#stockId').val();
        var amount = parseFloat($('#amount').val());
        var method = $('#method').val();

        console.log("Submitting payment:", stockId, amount, method); // Debug log

        if (isNaN(amount)) {
          toastr.error('Please enter a valid amount');
          return;
        }

        if (amount <= 0) {
          toastr.error('Amount must be greater than zero');
          return;
        }

        var remaining = parseFloat($('#modalRemaining').text());
        if (amount > remaining) {
          toastr.error('Amount cannot exceed remaining amount');
          return;
        }

        $.ajax({
          url: 'functions.php',
          type: 'POST',
          data: {
            RESULT_TYPE: 'UPDATE_STOCK_PAYMENT',
            stock_id: stockId,
            amount: amount,
            method: method
          },
          success: function(response) {
            console.log("Payment response:", response); // Debug log
            var res = JSON.parse(response);
            if (res.success) {
              toastr.success(res.message);
              $('#paymentModal').addClass('hidden');
              // Reload the DataTable
              loadStockData();
            } else {
              toastr.error(res.message);
            }
          },
          error: function(xhr, status, error) {
            console.log("Payment error:", error); // Debug log
            toastr.error('Error processing payment');
          }
        });
      });
    });
  </script>

  <style>
    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fade-in 0.6s ease-out;
    }

    .modal {
      display: none;
      z-index: 1000;
    }

    .modal-content {
      animation: fade-in 0.3s ease-out;
    }
  </style>

</body>

</html>