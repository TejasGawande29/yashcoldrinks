<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin | Yash Coldrinks</title>
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="output.css">
    <!-- Jquery -->
    <script src="/YashColdrinks/assets/js/jquery.js"></script>
    <!--Toastr-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .login-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>

<body class="login-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl">
        <div class="glass-card rounded-3xl shadow-2xl overflow-hidden md:flex">
            <!-- Left Side - Registration Form -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12">
                <!-- Registration Form -->
                <div id="registerForm">
                    <div class="text-center mb-6">
                        <img class="mx-auto w-16 h-16 md:hidden rounded-2xl shadow-lg floating" src="/YashColdrinks/assets/images/logo.png" alt="Yash Coldrinks">
                        <h1 class="mt-4 md:mt-0 text-2xl sm:text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            Create Account
                        </h1>
                        <p class="mt-2 text-gray-500 text-sm sm:text-base">Register a new admin account</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                                Full Name
                            </label>
                            <input id="regUsername" type="text" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter your full name">
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>
                                Mobile Number
                            </label>
                            <input id="regMobile" type="number" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter 10-digit mobile number">
                        </div>

                        <!-- Password -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                                Password
                            </label>
                            <div class="relative">
                                <input id="regPassword" type="password" 
                                    class="input-field w-full px-4 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                    placeholder="Create a password">
                                <button type="button" id="toggleRegPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                                Confirm Password
                            </label>
                            <input id="regConfirmPassword" type="password" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Confirm your password">
                        </div>

                        <!-- Password Strength -->
                        <div id="regPasswordStrength" class="hidden">
                            <div class="flex gap-1 mb-1">
                                <div id="regStr1" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                                <div id="regStr2" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                                <div id="regStr3" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                                <div id="regStr4" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                            </div>
                            <p id="regStrText" class="text-xs text-gray-500"></p>
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i data-lucide="shield" class="w-4 h-4 inline mr-1"></i>
                                Role
                            </label>
                            <select id="regRole" class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none bg-white">
                                <option value="staff">Staff</option>
                                <option value="manager">Manager</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Admin role can only be assigned by existing admins</p>
                        </div>

                        <!-- Admin Approval Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i data-lucide="key-round" class="w-4 h-4 inline mr-1"></i>
                                Admin Approval Code
                            </label>
                            <input id="regApprovalCode" type="password" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter code provided by admin">
                            <p class="text-xs text-gray-400 mt-1">Ask your administrator for the approval code</p>
                        </div>

                        <!-- Register Button -->
                        <button onclick="registerAdmin()" id="registerBtn" 
                            class="btn-primary w-full py-3 text-white font-semibold rounded-xl flex items-center justify-center gap-2">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                            Create Account
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-gray-500 text-sm">Already have an account?</p>
                        <a href="adminlogin.php" class="text-violet-600 hover:text-violet-800 text-sm font-medium flex items-center justify-center gap-2 mt-1">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Back to Login
                        </a>
                    </div>
                </div>

                <!-- Success State -->
                <div id="registerSuccess" class="hidden">
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="check-circle" class="w-10 h-10 text-green-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Account Created!</h3>
                        <p class="text-gray-500 mb-6">Your admin account has been registered successfully. You can now sign in.</p>
                        <a href="adminlogin.php" 
                            class="btn-primary inline-flex py-3 px-8 text-white font-semibold rounded-xl items-center gap-2">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                            Go to Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side - Branding -->
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-violet-600 to-purple-700 p-12 items-center justify-center">
                <div class="text-center text-white">
                    <div class="w-32 h-32 bg-white/20 rounded-3xl mx-auto flex items-center justify-center mb-6 floating">
                        <img src="/YashColdrinks/assets/images/logo.png" alt="Logo" class="w-24 h-24 rounded-2xl">
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Yash Coldrinks</h2>
                    <p class="text-violet-200 mb-6">Join the Admin Team</p>
                    <div class="space-y-3 text-left bg-white/10 rounded-2xl p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Secure Registration</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="key-round" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Approval Code Required</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Role-Based Access</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // ─── Toggle Password Visibility ─────────────────────────
        document.getElementById('toggleRegPassword').addEventListener('click', function() {
            const pwInput = document.getElementById('regPassword');
            const icon = this.querySelector('i');
            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                pwInput.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });

        // ─── Password Strength Indicator ────────────────────────
        document.getElementById('regPassword').addEventListener('input', function() {
            const pw = this.value;
            const strengthDiv = document.getElementById('regPasswordStrength');
            if (pw.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }
            strengthDiv.classList.remove('hidden');

            let score = 0;
            if (pw.length >= 6) score++;
            if (pw.length >= 8) score++;
            if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
            if (/[0-9]/.test(pw) && /[^A-Za-z0-9]/.test(pw)) score++;

            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-400'];
            const texts = ['Weak', 'Fair', 'Good', 'Strong'];

            for (let i = 1; i <= 4; i++) {
                const el = document.getElementById('regStr' + i);
                el.className = 'h-1 flex-1 rounded-full ' + (i <= score ? colors[score - 1] : 'bg-gray-200');
            }
            document.getElementById('regStrText').textContent = texts[score - 1] || '';
            document.getElementById('regStrText').className = 'text-xs ' + (
                score <= 1 ? 'text-red-500' : score === 2 ? 'text-orange-500' : score === 3 ? 'text-yellow-600' : 'text-green-600'
            );
        });

        // ─── Register Admin ─────────────────────────────────────
        function registerAdmin() {
            const username = document.getElementById('regUsername').value.trim();
            const mobile = document.getElementById('regMobile').value.trim();
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const role = document.getElementById('regRole').value;
            const approvalCode = document.getElementById('regApprovalCode').value.trim();

            // Validation
            if (!username) {
                toastr.warning('Please enter your full name');
                return;
            }
            if (username.length < 2) {
                toastr.warning('Name must be at least 2 characters');
                return;
            }
            if (!mobile || mobile.length < 10) {
                toastr.warning('Please enter a valid 10-digit mobile number');
                return;
            }
            if (!password) {
                toastr.warning('Please create a password');
                return;
            }
            if (password.length < 4) {
                toastr.warning('Password must be at least 4 characters');
                return;
            }
            if (password !== confirmPassword) {
                toastr.error('Passwords do not match');
                return;
            }
            if (!approvalCode) {
                toastr.warning('Please enter the admin approval code');
                return;
            }

            const btn = document.getElementById('registerBtn');
            btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Creating Account...';
            btn.disabled = true;
            lucide.createIcons();

            $.ajax({
                url: 'functions.php',
                type: 'POST',
                data: {
                    RESULT_TYPE: 'REGISTER_NEW_ADMIN',
                    username: username,
                    mobile: mobile,
                    password: password,
                    role: role,
                    approvalCode: approvalCode
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            toastr.success(data.message || 'Account created!');
                            document.getElementById('registerForm').classList.add('hidden');
                            document.getElementById('registerSuccess').classList.remove('hidden');
                            lucide.createIcons();
                        } else {
                            toastr.error(data.message || 'Registration failed');
                            btn.innerHTML = '<i data-lucide="user-plus" class="w-5 h-5"></i> Create Account';
                            btn.disabled = false;
                            lucide.createIcons();
                        }
                    } catch(e) {
                        toastr.error('Server error. Please try again.');
                        btn.innerHTML = '<i data-lucide="user-plus" class="w-5 h-5"></i> Create Account';
                        btn.disabled = false;
                        lucide.createIcons();
                    }
                },
                error: function() {
                    toastr.error('Connection error. Please try again.');
                    btn.innerHTML = '<i data-lucide="user-plus" class="w-5 h-5"></i> Create Account';
                    btn.disabled = false;
                    lucide.createIcons();
                }
            });
        }

        // Enter key support
        document.getElementById('regApprovalCode').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') registerAdmin();
        });
    </script>
</body>
</html>
