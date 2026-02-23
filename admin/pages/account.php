<?php
session_start();
if (isset($_SESSION["USERNAME"]) && isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] == "admin") {
  // User is authenticated - admin only page
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
  <script src="../js/jquery.js"></script>

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

  <title>Account Management</title>
  <style>
    .fade-in {
      animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .password-container {
      position: relative;
    }
    
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 12px;
      cursor: pointer;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-sky-100 to-white min-h-screen text-gray-800 font-sans">

  <section class="max-w-screen-2xl mx-auto p-4">
    <div class="grid lg:grid-cols-[18rem_auto] gap-6">

      <!-- Sidebar -->
      <?php include 'layouts/sidebar.php'; ?>

      <!-- Main Content -->
      <div class="bg-white rounded-3xl shadow-2xl p-8 transition-colors duration-500 ease-in-out fade-in-up">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-4xl font-extrabold text-sky-700 drop-shadow-md">
            👤 Account Management
          </h1>
          <button id="addAccountBtn" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2 transition-all">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            Add New Account
          </button>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 shadow-inner">
          <div class="overflow-x-auto">
            <table id="accountsTable" class="min-w-full divide-y divide-gray-200">
              <thead class="bg-sky-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Username</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Mobile</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Role</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <!-- Data will be loaded via AJAX -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Add/Edit Account Modal -->
  <div id="accountModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 fade-in">
      <div class="flex justify-between items-center mb-4">
        <h3 id="modalTitle" class="text-2xl font-bold text-sky-700">Add New Account</h3>
        <button id="closeModal" class="text-gray-500 hover:text-gray-700">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>
      
      <form id="accountForm" class="space-y-4">
        <input type="hidden" id="accountId">
        
        <div>
          <label for="username" class="block text-gray-700 mb-2">Username</label>
          <input type="text" id="username" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent" required>
        </div>
        
        <div class="password-container">
          <label for="password" class="block text-gray-700 mb-2">Password</label>
          <input type="password" id="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent" required>
          <span class="toggle-password text-gray-500">
            <i data-lucide="eye" class="w-5 h-5"></i>
          </span>
          <p class="text-xs text-gray-500 mt-1">Password will be encrypted with MD5</p>
        </div>
        
        <div>
          <label for="mobile" class="block text-gray-700 mb-2">Mobile</label>
          <input type="tel" id="mobile" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent" required>
        </div>
        
        <div>
          <label for="role" class="block text-gray-700 mb-2">Role</label>
          <select id="role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent">
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="staff">Staff</option>
          </select>
        </div>
        
        <div class="flex justify-end gap-3 pt-4">
          <button type="button" id="cancelBtn" class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium">Cancel</button>
          <button type="submit" id="saveBtn" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i>
            Save Account
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Password visibility toggle
    function setupPasswordToggle() {
      $('.toggle-password').click(function() {
        const icon = $(this).find('i');
        const passwordInput = $(this).siblings('input');
        
        if (passwordInput.attr('type') === 'password') {
          passwordInput.attr('type', 'text');
          icon.replaceWith('<i data-lucide="eye-off" class="w-5 h-5"></i>');
        } else {
          passwordInput.attr('type', 'password');
          icon.replaceWith('<i data-lucide="eye" class="w-5 h-5"></i>');
        }
        lucide.createIcons();
      });
    }

    // Initialize DataTable
    $(document).ready(function() {
      // Function to fetch accounts
      function fetchAccounts() {
        return $.ajax({
          url: 'functions.php',
          type: 'POST',
          data: { 
            RESULT_TYPE: 'GET_ADMIN_ACCOUNTS'
          },
          dataType: 'json'
        });
      }

      // Initialize DataTable with accounts
      const accountsTable = $('#accountsTable').DataTable({
        data: [],
        columns: [
          { data: 'id' },
          { data: 'username' },
          { data: 'mobile' },
          { 
            data: 'role',
            render: function(data) {
              const badgeClass = data === 'admin' ? 'bg-purple-100 text-purple-800' : 
                               data === 'manager' ? 'bg-blue-100 text-blue-800' : 
                               'bg-green-100 text-green-800';
              return `<span class="px-3 py-1 rounded-full text-sm font-medium ${badgeClass}">${data}</span>`;
            }
          },
          {
            data: 'id',
            render: function(data, type, row) {
              return `
                <div class="flex gap-2">
                  <button class="edit-btn px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg flex items-center gap-1" data-id="${data}">
                    <i data-lucide="edit" class="w-4 h-4"></i> Edit
                  </button>
                  <button class="delete-btn px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg flex items-center gap-1" data-id="${data}">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                  </button>
                </div>
              `;
            }
          }
        ]
      });

      // Load accounts into DataTable
      fetchAccounts().done(function(data) {
        accountsTable.clear().rows.add(data).draw();
      }).fail(function() {
        toastr.error('Failed to load accounts');
      });

      // Modal elements
      const modal = $('#accountModal');
      const modalTitle = $('#modalTitle');
      const accountForm = $('#accountForm');
      const accountId = $('#accountId');
      const username = $('#username');
      const password = $('#password');
      const mobile = $('#mobile');
      const role = $('#role');

      // Open modal for adding new account
      $('#addAccountBtn').click(function() {
        accountForm.trigger('reset');
        accountId.val('');
        modalTitle.text('Add New Account');
        modal.removeClass('hidden');
        password.attr('required', true);
        setupPasswordToggle();
      });

      // Close modal
      $('#closeModal, #cancelBtn').click(function() {
        modal.addClass('hidden');
      });

      // Handle edit button
      $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        
        // Fetch account data
        fetchAccounts().done(function(accounts) {
          const account = accounts.find(a => a.id == id);
          if (account) {
            // Fill form with account data
            accountId.val(account.id);
            username.val(account.username);
            mobile.val(account.mobile);
            role.val(account.role);
            
            // Password is not fetched for security, so we remove required attribute
            password.removeAttr('required');
            password.val('');
            
            // Change title and show modal
            modalTitle.text('Edit Account');
            modal.removeClass('hidden');
            setupPasswordToggle();
          } else {
            toastr.error('Account not found');
          }
        });
      });

      // Handle delete button
      $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        if(confirm('Are you sure you want to delete this account?')) {
          $.ajax({
            url: 'functions.php',
            type: 'POST',
            data: { 
              RESULT_TYPE: 'DELETE_ADMIN_ACCOUNT',
              id: id
            },
            success: function(response) {
              if (response.success) {
                toastr.success('Account deleted successfully!');
                fetchAccounts().done(function(data) {
                  accountsTable.clear().rows.add(data).draw();
                });
              } else {
                toastr.error(response.message || 'Failed to delete account');
              }
            },
            error: function() {
              toastr.error('Error deleting account');
            }
          });
        }
      });

      // Form submission
      accountForm.submit(function(e) {
        e.preventDefault();
        
        const formData = {
          id: accountId.val(),
          username: username.val(),
          password: password.val(),
          mobile: mobile.val(),
          role: role.val()
        };
        
        const resultType = formData.id ? 'UPDATE_ADMIN_ACCOUNT' : 'ADD_ADMIN_ACCOUNT';
        
        $.ajax({
          url: 'functions.php',
          type: 'POST',
          data: {
            RESULT_TYPE: resultType,
            ...formData
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              toastr.success(response.message);
              modal.addClass('hidden');
              fetchAccounts().done(function(data) {
                accountsTable.clear().rows.add(data).draw();
              });
            } else {
              toastr.error(response.message || 'Operation failed');
            }
          },
          error: function() {
            toastr.error('Error processing request');
          }
        });
      });

      // Initialize Toastr
      toastr.options = {
        positionClass: "toast-top-right",
        timeOut: 3000,
        closeButton: true,
        progressBar: true
      };
    });
  </script>
</body>
</html>