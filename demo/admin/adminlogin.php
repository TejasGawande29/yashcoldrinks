<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Yash Coldrinks</title>
    <link rel="stylesheet" href="output.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
                    <img class="mx-auto w-16 h-16 md:hidden rounded-2xl shadow-lg floating" src="../assets/images/logo.png" alt="Yash Coldrinks">
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
                </div>
            </div>

            <!-- Right Side - Branding -->
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-violet-600 to-purple-700 p-12 items-center justify-center">
                <div class="text-center text-white">
                    <div class="w-32 h-32 bg-white/20 rounded-3xl mx-auto flex items-center justify-center mb-6 floating">
                        <img src="../assets/images/logo.png" alt="Logo" class="w-24 h-24 rounded-2xl">
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

        function login() {
            const mobile = document.getElementById('mobile');
            const password = document.getElementById('password');
            
            if (mobile.value !== "" && password.value !== "") {
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
