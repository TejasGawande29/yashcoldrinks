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
  <script src="/YashColdrinks/assets/js/jquery.js"></script>

  <!-- Fingerprint Auth -->
  <script src="js/fingerprint.js"></script>

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

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen text-gray-800 font-sans">

  <section class="max-w-screen-2xl mx-auto p-4 lg:p-6">
    <div class="flex flex-col lg:flex-row gap-6">

      <!-- Sidebar -->
      <?php include 'layouts/sidebar.php'; ?>

      <!-- Main Content -->
      <div class="flex-1 min-w-0 bg-white rounded-2xl shadow-xl p-6 lg:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
              <span class="w-10 h-10 bg-gradient-to-r from-sky-500 to-blue-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-sky-500/30">
                <i data-lucide="users" class="w-5 h-5"></i>
              </span>
              Account Management
            </h1>
            <p class="text-gray-500 mt-1 ml-13">Manage user accounts and permissions.</p>
          </div>
          <button id="addAccountBtn" class="bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2 transition-all shadow-lg shadow-violet-500/30">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            Add New Account
          </button>
        </div>
        
        <script>lucide.createIcons();</script>

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

        <!-- Fingerprint Management Section -->
        <div class="mt-8 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 shadow-inner border border-emerald-100" id="fingerprintSection">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/>
                  <path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/>
                  <path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/>
                  <path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/>
                  <path d="M8.65 22c.21-.66.45-1.32.57-2"/>
                  <path d="M14 13.12c0 2.38 0 6.38-1 8.88"/>
                  <path d="M2 16h.01"/>
                  <path d="M21.8 16c.2-2 .131-5.354 0-6"/>
                  <path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/>
                </svg>
              </span>
              <div>
                <h2 class="text-xl font-bold text-emerald-800">Fingerprint Login</h2>
                <p class="text-emerald-600 text-sm">Register your fingerprint for quick biometric login</p>
              </div>
            </div>
            <button id="registerFingerprintBtn" onclick="registerFingerprint()" 
              class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2 transition-all shadow-lg shadow-emerald-500/30">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14"/><path d="M5 12h14"/>
              </svg>
              Register Fingerprint
            </button>
          </div>

          <div id="fingerprintNotSupported" class="hidden bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
            <p class="text-amber-700 font-medium">⚠️ Fingerprint login is not supported on this device/browser. Use a device with a biometric sensor and a compatible browser (Chrome, Edge, Safari).</p>
          </div>

          <div id="fingerprintList" class="space-y-3">
            <!-- Registered fingerprints will be loaded here -->
          </div>

          <div id="noFingerprints" class="hidden text-center py-8 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/>
              <path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/>
              <path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/>
              <path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/>
              <path d="M8.65 22c.21-.66.45-1.32.57-2"/>
              <path d="M14 13.12c0 2.38 0 6.38-1 8.88"/>
              <path d="M2 16h.01"/>
              <path d="M21.8 16c.2-2 .131-5.354 0-6"/>
              <path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/>
            </svg>
            <p class="font-medium">No fingerprints registered yet</p>
            <p class="text-sm mt-1">Click "Register Fingerprint" to add your first biometric login</p>
          </div>
        </div>

        <!-- Admin Approval Code Section -->
        <div class="mt-8 bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 shadow-inner border border-amber-100">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-4">
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                <i data-lucide="key-round" class="w-5 h-5"></i>
              </span>
              <div>
                <h2 class="text-xl font-bold text-amber-800">Registration Approval Code</h2>
                <p class="text-amber-600 text-sm">Share this code with new users who need to register</p>
              </div>
            </div>
            <button onclick="regenerateCode()" id="regenCodeBtn"
              class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-5 py-2.5 rounded-xl font-medium flex items-center gap-2 transition-all shadow-lg shadow-amber-500/30 text-sm">
              <i data-lucide="refresh-cw" class="w-4 h-4"></i>
              Generate New Code
            </button>
          </div>

          <div id="approvalCodeContainer" class="bg-white rounded-xl p-4 border border-amber-100">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs text-gray-500 mb-1">Current Approval Code</p>
                <div class="flex items-center gap-3">
                  <code id="approvalCodeDisplay" class="text-lg font-mono font-bold text-amber-700 bg-amber-50 px-4 py-2 rounded-lg">Loading...</code>
                  <button onclick="copyApprovalCode()" class="text-amber-600 hover:text-amber-800 transition-colors" title="Copy code">
                    <i data-lucide="copy" class="w-5 h-5"></i>
                  </button>
                </div>
              </div>
              <div class="text-right">
                <p class="text-xs text-gray-500">Last updated</p>
                <p id="codeUpdatedAt" class="text-sm text-gray-600">-</p>
              </div>
            </div>
            <p class="text-xs text-amber-600 mt-3 flex items-center gap-1">
              <i data-lucide="info" class="w-3.5 h-3.5"></i>
              New users enter this code when registering at <strong>register.php</strong>. Generate a new code after sharing to maintain security.
            </p>
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
            dataType: 'json',
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

      // ─── Fingerprint Management ───────────────────────────────
      initFingerprint();
    });

    // ═══════════════════════════════════════════════════════════════
    // FINGERPRINT FUNCTIONS
    // ═══════════════════════════════════════════════════════════════

    async function initFingerprint() {
      const section = document.getElementById('fingerprintSection');
      const regBtn = document.getElementById('registerFingerprintBtn');
      const notSupported = document.getElementById('fingerprintNotSupported');

      if (typeof FingerprintAuth === 'undefined' || !FingerprintAuth.isSupported()) {
        regBtn.classList.add('hidden');
        notSupported.classList.remove('hidden');
        return;
      }

      const available = await FingerprintAuth.isPlatformAvailable();
      if (!available) {
        regBtn.classList.add('hidden');
        notSupported.classList.remove('hidden');
        return;
      }

      // Load registered fingerprints
      loadFingerprints();
    }

    async function loadFingerprints() {
      try {
        const data = await FingerprintAuth.getCredentials();
        const listEl = document.getElementById('fingerprintList');
        const noFp = document.getElementById('noFingerprints');

        if (data.credentials && data.credentials.length > 0) {
          noFp.classList.add('hidden');
          listEl.innerHTML = data.credentials.map(cred => `
            <div class="flex items-center justify-between bg-white rounded-xl p-4 shadow-sm border border-emerald-100 hover:shadow-md transition-shadow">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                  <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/>
                    <path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/>
                    <path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/>
                    <path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/>
                    <path d="M8.65 22c.21-.66.45-1.32.57-2"/>
                    <path d="M14 13.12c0 2.38 0 6.38-1 8.88"/>
                    <path d="M2 16h.01"/>
                    <path d="M21.8 16c.2-2 .131-5.354 0-6"/>
                    <path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/>
                  </svg>
                </div>
                <div>
                  <p class="font-semibold text-gray-800">${cred.credential_name}</p>
                  <p class="text-sm text-gray-500">
                    Registered: ${new Date(cred.created_at).toLocaleDateString()}
                    ${cred.last_used ? ' · Last used: ' + new Date(cred.last_used).toLocaleDateString() : ''}
                  </p>
                </div>
              </div>
              <button onclick="deleteFingerprint(${cred.id})" 
                class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg flex items-center gap-1 transition-colors">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Remove
              </button>
            </div>
          `).join('');
          lucide.createIcons();
        } else {
          noFp.classList.remove('hidden');
          listEl.innerHTML = '';
        }
      } catch (err) {
        console.error('Failed to load fingerprints:', err);
      }
    }

    async function registerFingerprint() {
      const btn = document.getElementById('registerFingerprintBtn');
      const originalHTML = btn.innerHTML;

      // Prompt for a name
      const name = prompt('Give this fingerprint a name (e.g., "Laptop", "Phone"):', 'My Fingerprint');
      if (!name) return;

      btn.innerHTML = '<svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Scanning...';
      btn.disabled = true;

      try {
        const result = await FingerprintAuth.register(name);
        if (result.success) {
          toastr.success(result.message || 'Fingerprint registered successfully!');
          loadFingerprints();
        } else {
          toastr.error(result.error || 'Registration failed');
        }
      } catch (err) {
        toastr.error(err.message);
      } finally {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
      }
    }

    async function deleteFingerprint(credId) {
      if (!confirm('Remove this fingerprint? You will no longer be able to login with it.')) return;

      try {
        const result = await FingerprintAuth.deleteCredential(credId);
        if (result.success) {
          toastr.success('Fingerprint removed');
          loadFingerprints();
        } else {
          toastr.error(result.error || 'Failed to remove fingerprint');
        }
      } catch (err) {
        toastr.error(err.message);
      }
    }

    // ═══════════════════════════════════════════════════════════════
    // APPROVAL CODE MANAGEMENT
    // ═══════════════════════════════════════════════════════════════

    $(document).ready(function() {
      loadApprovalCode();
    });

    function loadApprovalCode() {
      $.ajax({
        url: 'functions.php',
        type: 'POST',
        data: { RESULT_TYPE: 'GET_APPROVAL_CODE' },
        success: function(res) {
          try {
            const data = typeof res === 'string' ? JSON.parse(res) : res;
            if (data.success) {
              document.getElementById('approvalCodeDisplay').textContent = data.code;
              document.getElementById('codeUpdatedAt').textContent = data.updatedAt ? new Date(data.updatedAt).toLocaleDateString() : '-';
            } else {
              document.getElementById('approvalCodeDisplay').textContent = 'Not set';
            }
          } catch(e) {
            document.getElementById('approvalCodeDisplay').textContent = 'Error';
          }
        }
      });
    }

    function regenerateCode() {
      if (!confirm('Generate a new approval code? The old code will stop working.')) return;

      const btn = document.getElementById('regenCodeBtn');
      btn.disabled = true;
      btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Generating...';
      lucide.createIcons();

      $.ajax({
        url: 'functions.php',
        type: 'POST',
        data: { RESULT_TYPE: 'REGENERATE_APPROVAL_CODE' },
        success: function(res) {
          try {
            const data = typeof res === 'string' ? JSON.parse(res) : res;
            if (data.success) {
              toastr.success('New code: ' + data.code + '<br>Share this with new users!', 'Code Generated', {
                timeOut: 10000,
                extendedTimeOut: 5000,
                closeButton: true
              });
              // Show the plaintext code briefly
              document.getElementById('approvalCodeDisplay').textContent = data.code;
              document.getElementById('codeUpdatedAt').textContent = 'Just now';

              // After 30 seconds, reload the hashed version
              setTimeout(loadApprovalCode, 30000);
            } else {
              toastr.error(data.message || 'Failed to generate code');
            }
          } catch(e) {
            toastr.error('Server error');
          }
          btn.disabled = false;
          btn.innerHTML = '<i data-lucide="refresh-cw" class="w-4 h-4"></i> Generate New Code';
          lucide.createIcons();
        },
        error: function() {
          toastr.error('Connection error');
          btn.disabled = false;
          btn.innerHTML = '<i data-lucide="refresh-cw" class="w-4 h-4"></i> Generate New Code';
          lucide.createIcons();
        }
      });
    }

    function copyApprovalCode() {
      const code = document.getElementById('approvalCodeDisplay').textContent;
      navigator.clipboard.writeText(code).then(() => {
        toastr.info('Code copied to clipboard!');
      }).catch(() => {
        // Fallback
        const temp = document.createElement('textarea');
        temp.value = code;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        toastr.info('Code copied!');
      });
    }
  </script>
</body>
</html>