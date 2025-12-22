<!-- sidebar.php -->
<div x-data="{ open: true, showLogoutModal: false }" class="lg:sticky top-6">

    <!-- User Profile -->
    <div class="flex items-center justify-between mb-4 px-2">
        <div class="flex items-center gap-3">
            <img src="../image/logo.png" alt="User" class="w-10 h-10 rounded-full border-2 border-violet-500 shadow-sm">
            <div class="block">
                <p class="text-sm font-semibold text-violet-700">Yash Walivakar</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
        <button @click="open = !open" class="lg:hidden text-violet-700 font-bold">
            <i data-lucide="menu"></i>
        </button>
    </div>

    <!-- Sidebar Nav -->
    <div
        x-show="open"
        x-transition:enter="transition transform duration-300 ease-out"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="bg-white/70 backdrop-blur-md border border-white/40 rounded-2xl shadow-xl p-4 space-y-4">
        <h2 onclick="changePage(this)" id="dashboard" class="text-xl font-bold text-violet-700 flex items-center gap-2">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="lg:inline">Dashboard</span>
        </h2>

        <ul class="space-y-2 text-gray-700 font-medium text-sm">
            <li id="viewstocks" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="box" class="w-5 h-5"></i>
                <span class="inline">View Stock</span>
            </li>
            <li id="order_management" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="box" class="w-5 h-5"></i>
                <span class="inline">Order Management</span>
            </li>
            <li id="sellReceipt" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="receipt" class="w-5 h-5"></i>
                <span class="hinline">Receipt</span>
            </li>
            <li id="sellDashboard" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                <span class="hinline">Sell Dashboard</span>
            </li>
            <li id="expense" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="between-horizontal-end"></i>
                <span class="inline">Expense</span>
            </li>
            <li id="audit" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="notebook-tabs"></i>
                <span class="inline">Audit</span>
            </li>
            <li id="addStock" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span class="inline">Add Stock</span>
            </li>
            <li id="updateList" onclick="changePage(this)" class="sidebar-link">
                <i data-lucide="edit" class="w-5 h-5"></i>
                <span class="inline">Update List</span>
            </li>
            <li id="account" onclick="changePage(this)" class="sidebar-link border-t pt-3 mt-3">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span class="inline">Account</span>
            </li>
            <li onclick="logout();" class="sidebar-link text-red-600 hover:bg-red-100 hover:text-red-700">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="inline">Logout</span>
            </li>
        </ul>
    </div>


</div>
<!-- Logout Confirmation Modal (place this outside sidebar.php, e.g., in main page layout) -->

<script>
    function logout() {
       
        window.location.href = "./logout_modal.php";
    }
    lucide.createIcons();

    function changePage(ele) {
        window.location.href = ele.id + ".php";
    }

    document.addEventListener("DOMContentLoaded", () => {
        const page = window.location.pathname.split("/").pop().replace(".php", "");
        const active = document.getElementById(page);
        if (active) {
            active.classList.add("bg-violet-100", "text-violet-700", "font-semibold");
        }
    });
</script>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: #f5f3ff;
        /* hover:bg-violet-50 */
    }
</style>