<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Yash Coldrinks</title>
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="output.css">
    <!-- Jquery -->
    <script src="/YashColdrinks/assets/js/jquery.js"></script>
    <!--Toastr-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Fingerprint Auth -->
    <script src="js/fingerprint.js"></script>
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
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-login:hover {
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
            <!-- Left Side - Login Form -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12">
                <div class="text-center mb-8">
                    <!-- Logo only visible on mobile when right panel is hidden -->
                    <img class="mx-auto w-16 h-16 md:hidden rounded-2xl shadow-lg floating" src="/YashColdrinks/assets/images/logo.png" alt="Yash Coldrinks">
                    <h1 class="mt-4 md:mt-0 text-2xl sm:text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                        Welcome Back
                    </h1>
                    <p class="mt-2 text-gray-500 text-sm sm:text-base">Sign in to your admin account</p>
                </div>

                <div class="space-y-5">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </span>
                            <input id="mobile" type="number" 
                                class="input-field w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter mobile number">
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </span>
                            <input id="password" type="password" onkeypress="rdlogin(event);"
                                class="input-field w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter password">
                            <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <button onclick="login()" 
                        class="btn-login w-full py-3 text-white font-semibold rounded-xl flex items-center justify-center gap-2">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        Sign In
                    </button>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 my-2">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-sm text-gray-400 font-medium">OR</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Fingerprint Login Button -->
                    <button id="fingerprintLoginBtn" onclick="fingerprintLogin()" 
                        class="w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold rounded-xl flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/30 hidden">
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
                        Sign In with Fingerprint
                    </button>
                </div>

                <!-- Forgot Password & Register Links -->
                <div class="mt-6 flex items-center justify-between text-sm">
                    <a href="forgot_password.php" class="text-violet-600 hover:text-violet-800 font-medium flex items-center gap-1 transition-colors">
                        <i data-lucide="key" class="w-3.5 h-3.5"></i>
                        Forgot Password?
                    </a>
                    <a href="register.php" class="text-violet-600 hover:text-violet-800 font-medium flex items-center gap-1 transition-colors">
                        <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                        Register
                    </a>
                </div>

                <div class="mt-4 text-center">
                    <a href="/YashColdrinks/customer/index.php" class="text-gray-400 hover:text-violet-600 text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Website
                    </a>
                </div>
            </div>

            <!-- Right Side - Branding -->
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-violet-600 to-purple-700 p-12 items-center justify-center">
                <div class="text-center text-white">
                    <div class="w-32 h-32 bg-white/20 rounded-3xl mx-auto flex items-center justify-center mb-6 floating">
                        <img src="/YashColdrinks/assets/images/logo.png" alt="Logo" class="w-24 h-24 rounded-2xl">
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Yash Coldrinks</h2>
                    <p class="text-violet-200 mb-6">Admin Control Panel</p>
                    <div class="space-y-3 text-left bg-white/10 rounded-2xl p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="package" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Manage Inventory</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="receipt" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Create Bills & Receipts</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">View Reports & Analytics</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        function rdlogin(event) {
            if (event.key === "Enter") {
                login();
            }
        }

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });

        // ─── Fingerprint Support Detection ───────────────────────
        (async function() {
            if (typeof FingerprintAuth !== 'undefined' && FingerprintAuth.isSupported()) {
                const available = await FingerprintAuth.isPlatformAvailable();
                if (available) {
                    document.getElementById('fingerprintLoginBtn').classList.remove('hidden');
                }
            }
        })();

        // Check for registered fingerprint when mobile number is entered
        let fingerprintCheckTimeout;
        document.getElementById('mobile').addEventListener('input', function() {
            clearTimeout(fingerprintCheckTimeout);
            const btn = document.getElementById('fingerprintLoginBtn');
            
            fingerprintCheckTimeout = setTimeout(async () => {
                if (this.value.length >= 10 && typeof FingerprintAuth !== 'undefined') {
                    try {
                        const result = await FingerprintAuth.checkFingerprint(this.value);
                        if (result.hasFingerprint) {
                            btn.classList.remove('hidden');
                            btn.classList.add('ring-2', 'ring-emerald-300', 'ring-offset-2');
                        } else {
                            btn.classList.remove('ring-2', 'ring-emerald-300', 'ring-offset-2');
                        }
                    } catch(e) { /* ignore */ }
                }
            }, 500);
        });

        // ─── Fingerprint Login ────────────────────────────────────
        async function fingerprintLogin() {
            const mobile = document.getElementById('mobile').value;
            const btn = document.getElementById('fingerprintLoginBtn');
            const originalHTML = btn.innerHTML;
            
            btn.innerHTML = '<svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Scanning...';
            btn.disabled = true;
            
            try {
                const result = await FingerprintAuth.login(mobile);
                if (result.success || result.result == 1) {
                    toastr.success('Fingerprint verified! Redirecting...');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 800);
                } else {
                    toastr.error(result.message || 'Fingerprint login failed');
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }
            } catch (err) {
                toastr.error(err.message);
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        }

        // ─── Password Login ──────────────────────────────────────
        function login() {
            const mobile = document.getElementById('mobile');
            const password = document.getElementById('password');
            
            if (mobile.value !== "" && password.value !== "") {
                // Show loading state
                const btn = document.querySelector('.btn-login');
                btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Signing in...';
                btn.disabled = true;
                lucide.createIcons();
                
                $.ajax({
                    url: "functions.php",
                    type: "POST",
                    data: {
                        "RESULT_TYPE": "LOGIN",
                        "USERNAME": mobile.value,
                        "PASSWORD": password.value
                    },
                    success: function(res) {
                        var jobj = JSON.parse(res);
                        if (jobj.result == 1) {
                            toastr.success("Login Successful! Redirecting...");
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 800);
                        } else {
                            toastr.error(jobj.message);
                            btn.innerHTML = '<i data-lucide="log-in" class="w-5 h-5"></i> Sign In';
                            btn.disabled = false;
                            lucide.createIcons();
                        }
                    },
                    error: function() {
                        toastr.error("Connection error. Please try again.");
                        btn.innerHTML = '<i data-lucide="log-in" class="w-5 h-5"></i> Sign In';
                        btn.disabled = false;
                        lucide.createIcons();
                    }
                });
            } else {
                toastr.warning("Please enter mobile number and password");
            }
        }
    </script>
</body>
</html>