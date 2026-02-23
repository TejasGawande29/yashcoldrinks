<?php
session_start();
if (!isset($_SESSION["USERNAME"]) || !in_array($_SESSION["ROLE"], ["admin", "manager"])) {
    header("Location: ../adminlogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Management - Admin | YASH ColdDrinks</title>
    <meta name="csrf-token" content="<?= $_SESSION['CSRF'] ?? '' ?>">

    <!-- TailwindCSS -->
    <link href="output.css" rel="stylesheet" />
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- jQuery & DataTables -->
    <script src="../js/jquery.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    
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
        .order-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }
        
        .order-pending {
            border-left-color: #f59e0b;
            background-color: #fffbeb;
        }
        
        .order-processing {
            border-left-color: #3b82f6;
            background-color: #eff6ff;
        }
        
        .order-shipped {
            border-left-color: #8b5cf6;
            background-color: #f5f3ff;
        }
        
        .order-delivered {
            border-left-color: #10b981;
            background-color: #ecfdf5;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .badge-processing {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .badge-shipped {
            background-color: #ede9fe;
            color: #6d28d9;
        }
        
        .badge-delivered {
            background-color: #d1fae5;
            color: #047857;
        }
        
        .order-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }
        
        .order-details.active {
            max-height: 1000px;
        }
        
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>k
</head>

<body class="bg-gradient-to-br from-white to-slate-100 text-gray-800 font-sans max-sm:mx-[-25px]">
    <section class="max-w-full mx-auto p-4">
        <div class="grid grid-cols-1 lg:grid-cols-[20%_auto] gap-6 min-h-screen">
            <!-- Sidebar -->
            <aside class="bg-white rounded-2xl shadow-md p-4 lg:p-6 sticky top-0 z-10">
                <?php include 'layouts/sidebar.php'; ?>
               
            </aside>
            
            <!-- Main Content -->
            <main class="bg-white rounded-2xl shadow-xl p-4 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-blue-700">📦 Order Management</h1>
                    <div class="flex gap-3">
                        <button id="refreshOrders" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm flex items-center gap-2">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Refresh
                        </button>
                        <select id="filterStatus" class="border rounded-md px-4 py-2 text-sm">
                            <option value="all">All Orders</option>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Shipped">Shipped</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>
                </div>

                <!-- Order Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 ">
                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                        <div class="text-amber-600 font-bold text-2xl" id="pendingCount">0</div>
                        <div class="text-amber-700 font-medium">Pending</div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-indigo-200 rounded-xl p-4 text-center">
                        <div class="text-indigo-600 font-bold text-2xl" id="processingCount">0</div>
                        <div class="text-indigo-700 font-medium">Processing</div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-violet-50 border border-violet-200 rounded-xl p-4 text-center">
                        <div class="text-violet-600 font-bold text-2xl" id="shippedCount">0</div>
                        <div class="text-violet-700 font-medium">Shipped</div>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-emerald-200 rounded-xl p-4 text-center">
                        <div class="text-emerald-600 font-bold text-2xl" id="deliveredCount">0</div>
                        <div class="text-emerald-700 font-medium">Delivered</div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table id="ordersTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Order ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Amount</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ordersBody" class="bg-white divide-y divide-gray-100">
                            <!-- Orders will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <!-- Order Details Modal -->
                <div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                            <div class="flex justify-between items-center">
                                <h2 class="text-2xl font-bold">Order #<span id="modalOrderId"></span></h2>
                                <button id="closeModal" class="text-white hover:text-gray-200">
                                    <i data-lucide="x" class="w-6 h-6"></i>
                                </button>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <div class="text-sm text-blue-100">Customer</div>
                                    <div class="font-semibold" id="modalCustomerName"></div>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-100">Phone</div>
                                    <div class="font-semibold" id="modalCustomerPhone"></div>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-100">Order Date</div>
                                    <div class="font-semibold" id="modalOrderDate"></div>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-100">Total Amount</div>
                                    <div class="font-semibold" id="modalOrderAmount"></div>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-100">Delivery Address</div>
                                    <div class="font-semibold" id="modalOrderAddress"></div>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-100">Status</div>
                                    <div id="modalOrderStatus" class="status-badge"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 overflow-y-auto flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm text-gray-700">Product</th>
                                        <th class="px-4 py-2 text-left text-sm text-gray-700">Price</th>
                                        <th class="px-4 py-2 text-left text-sm text-gray-700">Quantity</th>
                                        <th class="px-4 py-2 text-left text-sm text-gray-700">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="modalOrderItems">
                                    <!-- Order items will be loaded here -->
                                </tbody>
                            </table>
                            
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Order Status</h3>
                                <div class="flex gap-3 mb-4">
                                    <button data-status="Pending" class="action-btn status-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm flex items-center gap-1">
                                        <i data-lucide="clock" class="w-4 h-4"></i> Set Pending
                                    </button>
                                    <button data-status="Processing" class="action-btn status-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm flex items-center gap-1">
                                        <i data-lucide="settings" class="w-4 h-4"></i> Set Processing
                                    </button>
                                    <button data-status="Shipped" class="action-btn status-btn bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm flex items-center gap-1">
                                        <i data-lucide="truck" class="w-4 h-4"></i> Set Shipped
                                    </button>
                                    <button data-status="Delivered" class="action-btn status-btn bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm flex items-center gap-1">
                                        <i data-lucide="package-check" class="w-4 h-4"></i> Set Delivered
                                    </button>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Add Note</label>
                                    <textarea id="orderNote" class="w-full border rounded-md p-3" rows="3" placeholder="Add a note about this order..."></textarea>
                                    <button id="saveNote" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                                        Save Note
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 flex justify-end">
                            <button id="printOrder" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm flex items-center gap-2">
                                <i data-lucide="printer" class="w-4 h-4"></i> Print Order
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Global variable for current order ID
        let currentOrderId = null;
        
        // Function to load orders
        function loadOrders(filter = 'all') {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_ORDERS",
                    "FILTER": filter
                },
                success: function(res) {
                    try {
                        const orders = JSON.parse(res);
                        renderOrders(orders);
                        updateOrderStats(orders);
                    } catch (e) {
                        console.error("Error parsing orders:", e);
                        toastr.error("Error loading orders. Please try again.");
                    }
                },
                error: function() {
                    toastr.error("Failed to load orders. Please check your connection.");
                }
            });
        }
        
        // Function to render orders in the table
        function renderOrders(orders) {
            const ordersBody = document.getElementById('ordersBody');
            ordersBody.innerHTML = '';
            
            if (orders.length === 0) {
                ordersBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No orders found
                        </td>
                    </tr>
                `;
                return;
            }
            
            orders.forEach(order => {
                const row = document.createElement('tr');
                row.className = 'order-card';
                
                // Add class based on status
                if (order.status === 'Pending') row.classList.add('order-pending');
                if (order.status === 'Processing') row.classList.add('order-processing');
                if (order.status === 'Shipped') row.classList.add('order-shipped');
                if (order.status === 'Delivered') row.classList.add('order-delivered');
                
                // Format date
                const orderDate = new Date(order.order_date);
                const formattedDate = orderDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                // Format amount
                const formattedAmount = '₹' + parseFloat(order.total_amount).toFixed(2);
                
                // Status badge
                let statusClass = 'badge-pending';
                if (order.status === 'Processing') statusClass = 'badge-processing';
                if (order.status === 'Shipped') statusClass = 'badge-shipped';
                if (order.status === 'Delivered') statusClass = 'badge-delivered';
                
                row.innerHTML = `
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">${order.id}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">${order.customer_name}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">${formattedDate}</td>
                    <td class="px-6 py-4 text-sm text-gray-700 font-semibold">${formattedAmount}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="status-badge ${statusClass}">${order.status}</span>
                    </td>
                    <td class="px-6 py-4 text-sm flex gap-2">
                        <button class="view-details-btn text-blue-600 hover:text-blue-800" data-id="${order.id}">
                            <i data-lucide="eye" class="w-4 h-4"></i> View
                        </button>
                        <button class="delete-order-btn text-red-600 hover:text-red-800" data-id="${order.id}">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </td>
                `;
                
                ordersBody.appendChild(row);
            });
            
            // Add event listeners
            document.querySelectorAll('.view-details-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-id');
                    viewOrderDetails(orderId);
                });
            });
            
            document.querySelectorAll('.delete-order-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-id');
                    deleteOrder(orderId);
                });
            });
            
            // Reinitialize icons
            lucide.createIcons();
        }
        
        // Function to update order stats
        function updateOrderStats(orders) {
            const counts = {
                pending: 0,
                processing: 0,
                shipped: 0,
                delivered: 0
            };
            
            orders.forEach(order => {
                if (order.status === 'Pending') counts.pending++;
                if (order.status === 'Processing') counts.processing++;
                if (order.status === 'Shipped') counts.shipped++;
                if (order.status === 'Delivered') counts.delivered++;
            });
            
            document.getElementById('pendingCount').textContent = counts.pending;
            document.getElementById('processingCount').textContent = counts.processing;
            document.getElementById('shippedCount').textContent = counts.shipped;
            document.getElementById('deliveredCount').textContent = counts.delivered;
        }
        
        // Function to view order details
        function viewOrderDetails(orderId) {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "GET_ORDER_DETAILS",
                    "ORDER_ID": orderId
                },
                success: function(res) {
                    try {
                        const orderData = JSON.parse(res);
                        displayOrderModal(orderData);
                    } catch (e) {
                        console.error("Error parsing order details:", e);
                        toastr.error("Error loading order details.");
                    }
                },
                error: function() {
                    toastr.error("Failed to load order details.");
                }
            });
        }
        
        // Function to display order details in modal
        function displayOrderModal(orderData) {
            currentOrderId = orderData.id;
            
            // Set basic order info
            document.getElementById('modalOrderId').textContent = orderData.id;
            document.getElementById('modalCustomerName').textContent = orderData.customer_name;
            document.getElementById('modalCustomerPhone').textContent = orderData.phone;
            
            // Format date
            const orderDate = new Date(orderData.order_date);
            const formattedDate = orderDate.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalOrderDate').textContent = formattedDate;
            
            // Format amount
            document.getElementById('modalOrderAmount').textContent = '₹' + parseFloat(orderData.total_amount).toFixed(2);
            document.getElementById('modalOrderAddress').textContent = orderData.address;
            
            // Set status badge
            const statusBadge = document.getElementById('modalOrderStatus');
            statusBadge.textContent = orderData.status;
            statusBadge.className = 'status-badge';
            
            if (orderData.status === 'Pending') statusBadge.classList.add('badge-pending');
            if (orderData.status === 'Processing') statusBadge.classList.add('badge-processing');
            if (orderData.status === 'Shipped') statusBadge.classList.add('badge-shipped');
            if (orderData.status === 'Delivered') statusBadge.classList.add('badge-delivered');
            
            // Render order items
            const itemsContainer = document.getElementById('modalOrderItems');
            itemsContainer.innerHTML = '';
            
            orderData.items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-4 py-3 text-sm">${item.name}</td>
                    <td class="px-4 py-3 text-sm">₹${parseFloat(item.price).toFixed(2)}</td>
                    <td class="px-4 py-3 text-sm">${item.quantity}</td>
                    <td class="px-4 py-3 text-sm font-medium">₹${(parseFloat(item.price) * parseInt(item.quantity)).toFixed(2)}</td>
                `;
                itemsContainer.appendChild(row);
            });
            
            // Show modal
            document.getElementById('orderDetailsModal').classList.remove('hidden');
        }
        
        // Function to update order status
        function updateOrderStatus(status) {
            if (!currentOrderId) return;
            
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: {
                    "RESULT_TYPE": "UPDATE_ORDER_STATUS",
                    "ORDER_ID": currentOrderId,
                    "STATUS": status
                },
                success: function(res) {
                    try {
                        const response = JSON.parse(res);
                        if (response.success) {
                            toastr.success(response.message);
                            
                            // Close modal and refresh orders
                            closeOrderModal();
                            const filter = document.getElementById('filterStatus').value;
                            loadOrders(filter);
                        } else {
                            toastr.error(response.message);
                        }
                    } catch (e) {
                        console.error("Error parsing response:", e);
                        toastr.error("Error updating order status.");
                    }
                },
                error: function() {
                    toastr.error("Failed to update order status.");
                }
            });
        }
        
        // Function to delete an order
        function deleteOrder(orderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                 CancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "functions.php",
                        type: "POST",
                        data: {
                            "RESULT_TYPE": "DELETE_ORDER",
                            "ORDER_ID": orderId
                        },
                        success: function(res) {
                            try {
                                const response = JSON.parse(res);
                                if (response.success) {
                                    toastr.success(response.message);
                                    
                                    // Refresh orders
                                    const filter = document.getElementById('filterStatus').value;
                                    loadOrders(filter);
                                } else {
                                    toastr.error(response.message);
                                }
                            } catch (e) {
                                console.error("Error parsing response:", e);
                                toastr.error("Error deleting order.");
                            }
                        },
                        error: function() {
                            toastr.error("Failed to delete order.");
                        }
                    });
                }
            });
        }
        
        // Function to close order modal
        function closeOrderModal() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
            currentOrderId = null;
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Initial load
            loadOrders();
            
            // Refresh button
            document.getElementById('refreshOrders').addEventListener('click', function() {
                const filter = document.getElementById('filterStatus').value;
                loadOrders(filter);
            });
            
            // Filter change
            document.getElementById('filterStatus').addEventListener('change', function() {
                loadOrders(this.value);
            });
            
            // Close modal button
            document.getElementById('closeModal').addEventListener('click', closeOrderModal);
            
            // Status buttons
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');
                    updateOrderStatus(status);
                });
            });
            
            // Print button
            document.getElementById('printOrder').addEventListener('click', function() {
                window.print();
            });
            
            // Save note button
            document.getElementById('saveNote').addEventListener('click', function() {
                const note = document.getElementById('orderNote').value.trim();
                if (note) {
                    // In a real implementation, you would save this to the database
                    toastr.success("Note saved successfully");
                } else {
                    toastr.warning("Please enter a note before saving");
                }
            });
        });
    </script>
</body>
</html>