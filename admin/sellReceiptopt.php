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
    <meta name="csrf-token" content="<?= $_SESSION['CSRF'] ?? '' ?>">

    <!-- TailwindCSS -->
    <link href="output.css" rel="stylesheet" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- jQuery & DataTables -->
    <script src="/YashColdrinks/assets/js/jquery.js"></script>
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

                <!-- Form -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <select id="productname" onchange="getQuantity(this);" class="border rounded-md px-4 py-2 w-full">
                        <option value="">Select Product</option>
                        <!-- Options loaded dynamically -->
                    </select>

                    <input id="inptquantity" type="number" min="1" placeholder="Quantity" class="border rounded-md px-4 py-2 w-full" />

                    <select id="inpscheme" class="border rounded-md px-4 py-2 w-full">
                        <option value="0">Select Scheme</option>
                        <option value="RIO-1000">RIO-1000</option>
                        <option value="SpriteCan-125">SpriteCan-125</option>
                        <option value="ThumpsUpCan-125">ThumpsUpCan-125</option>
                        <option value="CocaColaCan-125">CocaColaCan-125</option>
                        <!-- Options loaded dynamically -->
                    </select>
                    <input id="schemebottles" type="text" placeholder="Scheme Bottles Number" value="" class="border rounded-md px-4 py-2 w-full" />

                    <input id="inpprice" type="number" min="0" step="0.01" placeholder="Price" class="border rounded-md px-4 py-2 w-full" />

                    <input id="billamount" type="number" readonly placeholder="Amount" class="border rounded-md px-4 py-2 w-full bg-gray-100" />

                    <select onchange="validateNoneOption(this);" id="countername" class="border rounded-md px-4 py-2 w-full">
                        <option value="">Select Counter</option>
                        <option value="None">None</option>
                        <!-- Options loaded dynamically -->
                    </select>
                    <input id="nonecounter" type="text" value="" placeholder="Enter Counter" class="border rounded-md px-4 py-2 w-full bg-gray-100" hidden>
                </div>

                <div class="text-center mb-8">
                    <button id="sellbtn" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-full shadow-lg hover:scale-105 transition duration-300">
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
                                <!-- Added Counter column here -->
                                <th class="px-6 py-3 text-left text-sm font-semibold">Counter</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="receiptBody" class="bg-white divide-y divide-gray-100">
                            <!-- Rows will be added dynamically -->
                        </tbody>
                        <!-- Add this tfoot section -->
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="5" class="px-6 py-3 text-right text-sm font-semibold">Total Amount:</td>
                                <td id="totalAmountCell" class="px-6 py-3 text-sm font-bold text-gray-900">₹0.00</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="mt-6 text-center">
                        <button id="generateBillBtn"
                            onclick="generateBill()"
                            class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-8 py-3 rounded-full shadow-lg hover:scale-105 transition duration-300">
                            🧾 Generate Bill
                        </button>
                    </div>

                </div>
            </main>
        </div>
    </section>
    <!-- To validate None Option -->
    <script>
        function validateNoneOption(ele) {
            if (ele.value == "None") {
                document.getElementById('nonecounter').hidden = false;
                document.getElementById('nonecounter').value = "";
            } else {
                document.getElementById('nonecounter').hidden = true;
                document.getElementById('nonecounter').value = "";
            }
        }
    </script>

    <!-- For dynamically add rows -->
    <script>
        // Function to calculate amount
        function calculateAmount() {
            const qty = parseInt(document.getElementById('inptquantity').value);
            const price = parseFloat(document.getElementById('inpprice').value);
            const billInput = document.getElementById('billamount');

            if (!isNaN(qty) && !isNaN(price)) {
                billInput.value = (qty * price).toFixed(2);
            } else {
                billInput.value = '';
            }
        }

        // Function to edit a row
        function editRow(row) {
            const cells = row.querySelectorAll('td');

            // Populate inputs
            document.getElementById('productname').value = cells[0].textContent;
            document.getElementById('inptquantity').value = cells[1].textContent;
            document.getElementById('inpscheme').value = cells[2].textContent !== '-' ? cells[2].textContent : '';
            document.getElementById('schemebottles').value = cells[3].textContent !== '-' ? cells[3].textContent : '';
            document.getElementById('inpprice').value = cells[4].textContent;
            document.getElementById('billamount').value = cells[5].textContent;

            // Counter handling
            const counterValue = cells[6].textContent;
            if (counterValue === 'None') {
                document.getElementById('countername').value = 'None';
                document.getElementById('nonecounter').hidden = false;
                document.getElementById('nonecounter').value = '';
            } else {
                document.getElementById('countername').value = counterValue;
                document.getElementById('nonecounter').hidden = true;
            }

            // Remove the row to allow re-adding after editing
            row.remove();
        }

        // Listen for input to auto-calculate bill amount
        document.getElementById('inptquantity').addEventListener('input', calculateAmount);
        document.getElementById('inpprice').addEventListener('input', calculateAmount);

        // Add sell receipt row
        document.getElementById('sellbtn').addEventListener('click', function() {
            const product = document.getElementById('productname').value;
            const quantity = parseInt(document.getElementById('inptquantity').value);
            const scheme = document.getElementById('inpscheme').value;
            const schemebottles = document.getElementById('schemebottles').value;
            const price = parseFloat(document.getElementById('inpprice').value);

            // Get counter name properly
            const counterSelect = document.getElementById('countername');
            let counterName = '';

            if (counterSelect.value === 'None') {
                counterName = document.getElementById('nonecounter').value || 'None';
            } else {
                counterName = counterSelect.value;
            }

            if (!product || isNaN(quantity) || isNaN(price)) {
                toastr.error('Please fill all required fields (Product, Quantity, Price).');
                return;
            }

            const amount = quantity * price;

            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class="px-6 py-4 text-sm text-gray-700">${product}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${quantity}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${scheme || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${schemebottles || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${price.toFixed(2)}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${amount.toFixed(2)}</td>
                <!-- Added Counter column here -->
                <td class="px-6 py-4 text-sm text-gray-700">${counterName || '-'}</td>
            
                <td class="px-6 py-4 text-sm flex space-x-2">
                    <button class="edit-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition duration-200">Edit</button>
                    <button class="delete-btn bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition duration-200">Delete</button>
                </td>
            `;

            document.getElementById('receiptBody').appendChild(newRow);
            updateTotalAmount(); // Add this line

            // In your edit button event handler, modify to:
            newRow.querySelector('.edit-btn').addEventListener('click', () => {
                editRow(newRow);
                updateTotalAmount(); // Add this line
            });
            // In your delete button event handler, modify to:
            newRow.querySelector('.delete-btn').addEventListener('click', () => {
                newRow.remove();
                updateTotalAmount(); // Add this line
            });

            // Clear form
            document.getElementById('productname').value = '';
            document.getElementById('inptquantity').value = '';
            document.getElementById('inpscheme').value = '';
            document.getElementById('schemebottles').value = '';
            document.getElementById('inpprice').value = '';
            document.getElementById('billamount').value = '';

            // Clear counter fields
            document.getElementById('countername').value = '';
            document.getElementById('nonecounter').value = '';
            document.getElementById('nonecounter').hidden = true;
        });
    </script>
    <!-- For Dynamically Load Products -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "UPDATE_SELECT_PRODUCT"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    const productSelect = document.getElementById('productname');
                    for (var i = 0; i < jobj.length; i++) {
                        const option = document.createElement('option');
                        option.value = jobj[i][0];
                        option.textContent = jobj[i][0];
                        productSelect.appendChild(option);
                    }
                },
                error: function() {
                    toastr.error("Failed to load stock data.");
                }
            });
        });
    </script>
    <!-- For Dynamically Load Counters -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_COUNTERSLIST"
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    const counterSelect = document.getElementById('countername');
                    for (var i = 0; i < jobj.length; i++) {
                        const option = document.createElement('option');
                        option.value = jobj[i][1];
                        option.textContent = jobj[i][1];
                        counterSelect.appendChild(option);
                    }
                },
                error: function() {
                    toastr.error("Failed to load counter data.");
                }
            });
        });
    </script>
    <script>
        // Initialize AOS animation
        AOS.init();
    </script>
    <!-- For Validation of Quantity -->
    <script>
        function getQuantity(ele) {
            var opt = ele.value;

            // Clear quantity input on product change
            document.getElementById('inptquantity').value = '';
            document.getElementById('billamount').value = '';

            if (!opt) return;

            // Store the stock quantity in a data attribute for later access
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_PRODUCT_QUANTITY",
                    "PRODUCTNAME": opt
                },
                success: function(res) {
                    const jobj = JSON.parse(res);
                    const dbquantity = parseInt(jobj.total_quantity);

                    // Store it temporarily in a data attribute
                    $('#inptquantity').data('dbquantity', dbquantity);
                },
                error: function() {
                    toastr.error("Failed to load stock data.");
                }
            });
        }

        // Real-time validation when user enters quantity
        $('#inptquantity').on('input', function() {
            const enteredQty = parseInt($(this).val());
            const dbQty = $(this).data('dbquantity');

            if (!isNaN(enteredQty) && !isNaN(dbQty)) {
                if (enteredQty > dbQty) {
                    this.classList.add('bg-red-100');
                    toastr.options.timeOut = 1000;
                    toastr.error("Entered quantity exceeds available stock.");

                    // Disable other input fields
                    $('#inpscheme, #inpprice, #sellbtn').prop('disabled', true);
                    $('#billamount').val('');
                } else {
                    this.classList.remove('bg-red-100');
                    $('#inpscheme, #inpprice, #sellbtn').prop('disabled', false);
                    calculateAmount();
                }
            } else {
                $('#inpscheme, #inpprice, #sellbtn').prop('disabled', false);
                $('#billamount').val('');
            }
        });
    </script>
    <!-- To Generate Bill -->
    <script>
        function generateBill() {

            const receiptBody = document.getElementById('receiptBody');
    if (receiptBody.children.length === 0) {
        toastr.options.timeOut = 1000;
        toastr.error("No products added to the receipt.");
        return;
    }

    let billData = [];
    let totalAmount = 0;
    const sellDate = new Date().toISOString().slice(0, 19).replace('T', ' '); // Moved this line up
    
    // Calculate total amount
    const amountCells = document.querySelectorAll('#receiptBody td:nth-child(6)');
    amountCells.forEach(cell => {
        const amount = parseFloat(cell.textContent);
        if (!isNaN(amount)) {
            totalAmount += amount;
        }
    });

    for (let row of receiptBody.children) {
        const cells = row.querySelectorAll('td');
        const product = cells[0].textContent;
        const quantity = parseInt(cells[1].textContent);
        const scheme = cells[2].textContent;
        const schemebottles = cells[3].textContent;
        const price = parseFloat(cells[4].textContent);
        const amount = parseFloat(cells[5].textContent);
        const counterName = cells[6].textContent;
        
        billData.push({
            productname: product,
            quantity: quantity,
            scheme: scheme,
            schemebottles: schemebottles,
            priceperbox: price,
            totalbillamount: amount,
            countername: counterName,
            sellDate: sellDate // Now using the defined variable
        });
    }


            // Send bill data to PHP using AJAX
            $.ajax({
                url: 'functions.php',
                type: 'POST',
                data: {
                    "RESULT_TYPE": 'INSERT_BILLDATA',
                    "BILLDATA": JSON.stringify(billData)
                },
                success: function(response) {
                    console.log(response);

                    try {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            toastr.success("Bill recorded successfully!");
                            setTimeout(() => {
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Bill Generated Successfully!',
                                    html: '<button id="printBillBtn" class="swal2-confirm swal2-styled" style="margin: 10px 5px;">🖨️ Print Bill</button>',
                                    showConfirmButton: false,
                                    allowOutsideClick: true,
                                    allowEscapeKey: true,
                                    didOpen: () => {
                                        // Attach click event to custom print button inside SweetAlert
                                        document.getElementById('printBillBtn').addEventListener('click', () => {
                                            showPrintableReceipt(billData, totalAmount);
                                        });
                                    }
                                }).then(() => {
                                    // After closing the popup, clicking anywhere on the screen will reload the page
                                    document.body.addEventListener('click', handleReloadOnce, {
                                        once: true
                                    });
                                });

                                function handleReloadOnce() {
                                    location.reload();
                                }

                                // Save bill data in a global variable for printing later
                                window.generatedBillData = billData;
                                window.generatedTotalAmount = totalAmount;
                            }, 500);
                        } else {
                            toastr.error("Error: " + res.message);
                        }
                    } catch (e) {
                        toastr.error("Unexpected server response.");
                    }
                },
                error: function(xhr) {
                    toastr.error("AJAX error: " + xhr.status);
                }
            });
        }

        // PrintBill
        function showPrintableReceipt() {
            const billData = window.generatedBillData;
            const totalAmount = window.generatedTotalAmount;

            if (!billData || !totalAmount) {
                toastr.error("No bill data available.");
                return;
            }

            let content = `
      <html><head><title>Sell Receipt</title>
      <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 20px; text-align: right; }
      </style>
     </head><body>
     <div class="header">
        <h2>YASH ColdDrinks - Sell Receipt</h2>
        <p>Date: ${new Date().toLocaleString()}</p>
     </div>
     <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Scheme</th>
                <th>Scheme Bottles</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Counter</th>
            </tr>
        </thead>
        <tbody>
      `;

            billData.forEach(item => {
                content += `
            <tr>
                <td>${item.productname}</td>
                <td>${item.quantity}</td>
                <td>${item.scheme || '-'}</td>
                <td>${item.schemebottles || '-'}</td>
                <td>₹${item.priceperbox.toFixed(2)}</td>
                <td>₹${item.totalbillamount.toFixed(2)}</td>
                <td>${item.countername || '-'}</td>
            </tr>
            
        `;
            });

            content += `
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right;"><strong>Total</strong></td>
                <td><strong>₹${totalAmount.toFixed(2)}</strong></td>
            </tr>
         </tfoot>
        </table>
       <div class="footer">
        <p>Thank you for your business!</p>
      </div>
      </body></html>
      `;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(content);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
    <script>
        // Function to update the total amount display
        function updateTotalAmount() {
            const rows = document.getElementById('receiptBody').children;
            let total = 0;

            for (let row of rows) {
                const amountCell = row.querySelector('td:nth-child(6)'); // 6th column is amount
                if (amountCell) {
                    const amount = parseFloat(amountCell.textContent);
                    if (!isNaN(amount)) {
                        total += amount;
                    }
                }
            }

            // Update the footer display
            document.getElementById('totalAmountCell').textContent = `₹${total.toFixed(2)}`;
        }
    </script>
</body>

</html>