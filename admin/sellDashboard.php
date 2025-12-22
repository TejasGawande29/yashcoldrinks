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

  <meta name="csrf-token" content="<?= $_SESSION['CSRF'] ?? '' ?>">

  <!-- TailwindCSS -->
  <link href="dist/output.css" rel="stylesheet" />

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <!-- jQuery & DataTables -->
  <script src="../js/jquery.js"></script>
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
    .payment-badge {
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: bold;
    }

    .paid {
      background-color: #d4edda;
      color: #155724;
    }

    .unpaid {
      background-color: #f8d7da;
      color: #721c24;
    }

    .partial {
      background-color: #fff3cd;
      color: #856404;
    }
  </style>
</head>

<body class="bg-gray-100">
  <div class="max-w-screen-2xl mx-auto p-4">
    <div class="grid lg:grid-cols-[18rem_auto] gap-6">
      <?php include 'layouts/sidebar.php'; ?>

      <main class="bg-white h-[95vh] overflow-y-scroll rounded-2xl shadow-xl p-6">
        <h1 class="text-3xl font-bold text-blue-700 mb-6">💰 Payment Management</h1>

        <div class="mb-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Bills Overview</h2>
            <div class="flex space-x-2">
              <button id="refreshBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                Refresh
              </button>
            </div>
          </div>

          <table id="billsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr >
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
              <!-- Dynamically populated -->
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  <!-- Payment Modal -->
  <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg w-full max-w-md">
      <div class="p-6">
        <h3 class="text-xl font-bold mb-4">Manage Payments</h3>
        <div id="paymentDetails" class="mb-4">
          <!-- Payment details will be loaded here -->
        </div>

        <div class="mt-4">
          <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {

      
      // Load bills
      function loadBills() {
        $.ajax({
          url: "functions.php",
          type: "POST",
          data: {
            "RESULT_TYPE": "GET_BILLS"
          },
          success: function(res) {
            const bills = JSON.parse(res);
            let html = '';
            

            bills.forEach(bill => {
              let statusClass = '';
              if (bill.payment_status === 'Paid') statusClass = 'paid';
              if (bill.payment_status === 'Unpaid') statusClass = 'unpaid';
              if (bill.payment_status === 'Partially Paid') statusClass = 'partial';

              html += `
                        <tr>
                            <td class="px-6 py-4">${bill.id}</td>
                            <td class="px-6 py-4">${bill.bill_date}</td>
                            <td class="px-6 py-4">${bill.counter_name}</td>
                            <td class="px-6 py-4">₹${parseFloat(bill.total_bill_amount).toFixed(2)}</td>
                            <td class="px-6 py-4">₹${parseFloat(bill.paid_amount).toFixed(2)}</td>
                            <td class="px-6 py-4">
                                <span class="payment-badge ${statusClass}">${bill.payment_status}</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="viewBill(${bill.id})" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                                    View
                                </button>
                            </td>
                        </tr>`;
            });

            $('#billsTable tbody').html(html);
          }
        });
      }

      // Initial load
      loadBills();

      // Refresh button
      $('#refreshBtn').click(loadBills);
    });

    function viewBill(billId) {
      $.ajax({
        url: "functions.php",
        type: "POST",
        data: {
          "RESULT_TYPE": "GET_BILL_DETAILS",
          "BILL_ID": billId
        },
        success: function(res) {
          const bill = JSON.parse(res);
          let html = `
                    <div class="mb-4 p-4 border rounded-lg">
                        <h4 class="font-bold">Bill #${bill.id}</h4>
                        <p>Date: ${bill.bill_date}</p>
                        <p>Counter: ${bill.counter_name}</p>
                        <p class="font-bold">Total: ₹${parseFloat(bill.total_bill_amount).toFixed(2)}</p>
                        <p>Status: <span class="payment-badge ${bill.payment_status.toLowerCase()}">${bill.payment_status}</span></p>
                    </div>
                    
                    <h4 class="font-bold mb-2">Items:</h4>
                    <ul class="mb-4 max-h-40 overflow-y-auto">`;

           bill.items.forEach(item => {
            html += `<li class="py-1 border-b">${item.productname} - ${item.quantity} x ₹${parseFloat(item.priceperbox).toFixed(2)
                       } = ₹${parseFloat(item.totalamount).toFixed(2)
                      }</li>
                      `;
          });

          // Inside viewBill function, update payments display:
          html += `<h4 class="font-bold mb-2">Payments:</h4>
         <ul id="paymentsList" class="mb-4 border rounded-lg p-2">`;

          if (bill.payments.length > 0) {
            bill.payments.forEach(payment => {
              const type = payment.payment_type === 'full' ?
                '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">full</span>' :
                '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">partial</span>';

              html += `<li class="py-2 border-b flex justify-between items-center">
                    <div>
                        <span class="font-medium">₹${parseFloat(payment.amount_paid).toFixed(2)}</span>
                        via ${payment.payment_method} ${type}
                    </div>
                    <span class="text-gray-500 text-sm">${payment.payment_date}</span>
                </li>`;
            });
          } else {
            html += `<li class="py-2 text-gray-500">No payments recorded</li>`;
          }

          html += `</ul>`;
          if (bill.payment_status !== 'Paid') {
            html += `<button onclick="openPaymentModal(${bill.id}, ${bill.total_bill_amount}, ${bill.paid_amount})" 
                 class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg">
                 Make Payment
             </button>`;
          }

          $('#paymentDetails').html(html);
          $('#paymentModal').removeClass('hidden');
        }
      });
    }

    function openPaymentModal(billId, totalAmount, paidAmount) {
      const remaining = totalAmount - paidAmount;

      Swal.fire({
        title: 'Make Payment',
        html: `
            <div class="text-left mb-4">
                <p class="font-semibold">Total Amount: ₹${totalAmount.toFixed(2)}</p>
                <p class="font-semibold">Paid Amount: ₹${paidAmount.toFixed(2)}</p>
                <p class="font-semibold text-red-600">Remaining: ₹${remaining.toFixed(2)}</p>
            </div>
            <input type="number" id="paymentAmount" class="swal2-input" 
                   placeholder="Enter amount" min="1" max="${remaining}" 
                   step="0.01" value="${remaining}" required>
            <select id="paymentMethod" class="swal2-select mt-2">
                <option value="Cash">Cash</option>
                <option value="PhonePe">PhonePe</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Pay Now',
        cancelButtonText: 'Cancel',
        focusConfirm: false,
        preConfirm: () => {
          const amount = parseFloat(document.getElementById('paymentAmount').value);
          const method = document.getElementById('paymentMethod').value;

          if (!amount || amount <= 0 || amount > remaining) {
            Swal.showValidationMessage(`Please enter valid amount (1-${remaining})`);
            return false;
          }
          return {
            amount,
            method
          };
        }
      }).then(result => {
        if (result.isConfirmed) {
          const {
            amount,
            method
          } = result.value;
          makePayment(billId, amount, method);
        }
      });
    }

    function makePayment(billId, amount, method) {
      $.ajax({
        url: "functions.php",
        type: "POST",
        data: {
          "RESULT_TYPE": "MAKE_PAYMENT",
          "BILL_ID": billId,
          "AMOUNT": amount,
          "METHOD": method
        },
        success: function(response) {
          const res = JSON.parse(response);
          if (res.success) {
            toastr.success(res.message);
            // Refresh bill details and table
            viewBill(billId);
            loadBills();
          } else {
            toastr.error(res.message);
          }
        },
        error: function() {
          toastr.error("Error processing payment");
        }
      });
    }


    // function paybill(billId){
    //   Swal.fire({
    //     title : 'Pay Bill',
    //     html : `<input type="number" id="amount" class="swal2-input" placeholder="Enter amount to pay">`,
    //     showCancelButton: true,
    //     confirmButtonText: 'Pay',
    //     preconfirmButtonColor: '#3085d6',
    //     cancelButton: 'Cancel',
    //     focusConfirm: false,
    //     didOpen: () => {
    //       const amountInput = Swal.getInput();
    //       amountInput
    //     }
    //   })
    // }
    // Close modal
    $('#closeModal').click(function() {
      $('#paymentModal').addClass('hidden');
      window.location.replace('sellDashboard.php'); //Refresh the page to reload the bills
    });
  </script>
</body>

</html>