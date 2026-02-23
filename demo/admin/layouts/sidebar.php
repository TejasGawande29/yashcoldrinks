<!-- sidebar.php - Demo Version -->
<div x-data="{ open: true, showLogoutModal: false }" class="w-full lg:w-64 flex-shrink-0 lg:sticky lg:top-6 lg:self-start">

    <!-- User Profile Header -->
    <div class="bg-gradient-to-r from-violet-600 to-purple-600 rounded-t-2xl p-4 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <img src="../assets/images/logo.png" alt="Logo" class="w-10 h-10 rounded-full object-cover">
                </div>
                <div>
                    <p class="font-bold text-lg"><?= $_SESSION['USERNAME'] ?? 'Admin' ?></p>
                    <p class="text-xs text-violet-200 capitalize"><?= $_SESSION['ROLE'] ?? 'Administrator' ?></p>
                </div>
            </div>
            <button @click="open = !open" class="lg:hidden text-white p-2 hover:bg-white/20 rounded-lg transition">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar Nav -->
    <div
        x-show="open"
        x-transition:enter="transition transform duration-300 ease-out"
        x-transition:enter-start="-translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition transform duration-300 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="-translate-x-full opacity-0"
        class="bg-white border border-gray-200 rounded-b-2xl shadow-xl p-4">
        
        <!-- Main Navigation -->
        <nav class="space-y-1">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2">Main Menu</p>
            
            <a href="index.php" id="index" class="sidebar-link group">
                <div class="sidebar-icon bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </div>
                <span>Dashboard</span>
            </a>
            
            <a href="viewstocks.php" id="viewstocks" class="sidebar-link group">
                <div class="sidebar-icon bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white">
                    <i data-lucide="package" class="w-5 h-5"></i>
                </div>
                <span>View Stock</span>
            </a>

            <a href="addStock.php" id="addStock" class="sidebar-link group">
                <div class="sidebar-icon bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                </div>
                <span>Add Stock</span>
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 mt-4">Sales & Billing</p>

            <a href="sellReceipt.php" id="sellReceipt" class="sidebar-link group">
                <div class="sidebar-icon bg-orange-100 text-orange-600 group-hover:bg-orange-600 group-hover:text-white">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <span>Create Receipt</span>
            </a>

            <a href="sellDashboard.php" id="sellDashboard" class="sidebar-link group">
                <div class="sidebar-icon bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span>Payment Management</span>
            </a>

            <a href="order_management.php" id="order_management" class="sidebar-link group">
                <div class="sidebar-icon bg-cyan-100 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </div>
                <span>Online Orders</span>
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 mt-4">Reports & Settings</p>

            <a href="expense.php" id="expense" class="sidebar-link group">
                <div class="sidebar-icon bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white">
                    <i data-lucide="trending-down" class="w-5 h-5"></i>
                </div>
                <span>Expenses</span>
            </a>

            <a href="salary.php" id="salary" class="sidebar-link group">
                <div class="sidebar-icon bg-teal-100 text-teal-600 group-hover:bg-teal-600 group-hover:text-white">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </div>
                <span>Salary Management</span>
            </a>

            <a href="audit.php" id="audit" class="sidebar-link group">
                <div class="sidebar-icon bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <span>Audit Report</span>
            </a>

            <a href="updateList.php" id="updateList" class="sidebar-link group">
                <div class="sidebar-icon bg-amber-100 text-amber-600 group-hover:bg-amber-600 group-hover:text-white">
                    <i data-lucide="list-plus" class="w-5 h-5"></i>
                </div>
                <span>Manage Lists</span>
            </a>

            <a href="account.php" id="account" class="sidebar-link group">
                <div class="sidebar-icon bg-slate-100 text-slate-600 group-hover:bg-slate-600 group-hover:text-white">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span>Admin Accounts</span>
            </a>
        </nav>

        <!-- Logout Button -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <button onclick="logout();" class="w-full flex items-center gap-3 px-3 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 font-medium">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </div>
                <span>Logout</span>
            </button>
        </div>
    </div>
</div>

<script>
    function logout() {
        window.location.href = "./logout_modal.php";
    }
    
    lucide.createIcons();

    // Highlight active page
    document.addEventListener("DOMContentLoaded", () => {
        const page = window.location.pathname.split("/").pop().replace(".php", "");
        const active = document.getElementById(page);
        if (active) {
            active.classList.add("sidebar-link-active");
        }
    });
</script>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #374151;
        text-decoration: none;
    }

    .sidebar-link:hover {
        background-color: #f3f4f6;
        transform: translateX(4px);
    }

    .sidebar-link-active {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        color: white !important;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }

    .sidebar-link-active .sidebar-icon {
        background: rgba(255,255,255,0.2) !important;
        color: white !important;
    }

    .sidebar-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
</style>
