<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Yash Coldrinks</title>
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
        .step { display: none; }
        .step.active { display: block; }
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.1);
        }
        .step-indicator.completed {
            background: #10b981;
            color: white;
        }
    </style>
</head>

<body class="login-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl">
        <div class="glass-card rounded-3xl shadow-2xl overflow-hidden md:flex">
            <!-- Left Side - Form -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12">
                <div class="text-center mb-6">
                    <img class="mx-auto w-16 h-16 md:hidden rounded-2xl shadow-lg floating" src="/YashColdrinks/assets/images/logo.png" alt="Yash Coldrinks">
                    <h1 class="mt-4 md:mt-0 text-2xl sm:text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                        Reset Password
                    </h1>
                    <p class="mt-2 text-gray-500 text-sm sm:text-base">Recover access to your admin account</p>
                </div>

                <!-- Step Indicators -->
                <div class="flex items-center justify-center gap-2 mb-8">
                    <div id="stepInd1" class="step-indicator active w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 border-violet-300">1</div>
                    <div class="w-8 h-0.5 bg-gray-200 rounded" id="stepLine1"></div>
                    <div id="stepInd2" class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 border-gray-200 text-gray-400">2</div>
                    <div class="w-8 h-0.5 bg-gray-200 rounded" id="stepLine2"></div>
                    <div id="stepInd3" class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 border-gray-200 text-gray-400">3</div>
                </div>

                <!-- Step 1: Verify Mobile -->
                <div id="step1" class="step active">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>
                                Registered Mobile Number
                            </label>
                            <input id="resetMobile" type="number" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter your registered mobile number">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                                Username
                            </label>
                            <input id="resetUsername" type="text" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter your username to verify identity">
                        </div>
                        <button onclick="verifyIdentity()" id="verifyBtn"
                            class="btn-primary w-full py-3 text-white font-semibold rounded-xl flex items-center justify-center gap-2">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                            Verify Identity
                        </button>
                    </div>
                </div>

                <!-- Step 2: Security Question -->
                <div id="step2" class="step">
                    <div class="space-y-5">
                        <div class="bg-violet-50 border border-violet-100 rounded-xl p-4 text-center">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-500 inline"></i>
                            <p class="text-violet-700 font-medium mt-1">Identity verified for: <span id="verifiedUser" class="font-bold"></span></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="help-circle" class="w-4 h-4 inline mr-1"></i>
                                Security Verification
                            </label>
                            <p class="text-xs text-gray-500 mb-2">Enter the last 4 digits of your mobile number to confirm</p>
                            <input id="securityAnswer" type="number" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Last 4 digits of mobile">
                        </div>
                        <button onclick="verifySecurityAnswer()" id="securityBtn"
                            class="btn-primary w-full py-3 text-white font-semibold rounded-xl flex items-center justify-center gap-2">
                            <i data-lucide="check" class="w-5 h-5"></i>
                            Verify & Continue
                        </button>
                    </div>
                </div>

                <!-- Step 3: New Password -->
                <div id="step3" class="step">
                    <div class="space-y-5">
                        <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-center">
                            <i data-lucide="shield-check" class="w-6 h-6 text-green-500 inline"></i>
                            <p class="text-green-700 font-medium mt-1">Verified! Set your new password</p>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                                New Password
                            </label>
                            <input id="newPassword" type="password" 
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Enter new password">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                                Confirm Password
                            </label>
                            <input id="confirmPassword" type="password" onkeypress="if(event.key==='Enter') resetPassword();"
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:outline-none" 
                                placeholder="Confirm new password">
                        </div>
                        <!-- Password strength indicator -->
                        <div id="passwordStrength" class="hidden">
                            <div class="flex gap-1 mb-1">
                                <div id="str1" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                                <div id="str2" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                                <div id="str3" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                                <div id="str4" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                            </div>
                            <p id="strText" class="text-xs text-gray-500"></p>
                        </div>
                        <button onclick="resetPassword()" id="resetBtn"
                            class="btn-primary w-full py-3 text-white font-semibold rounded-xl flex items-center justify-center gap-2">
                            <i data-lucide="key" class="w-5 h-5"></i>
                            Reset Password
                        </button>
                    </div>
                </div>

                <!-- Success State -->
                <div id="successState" class="step">
                    <div class="text-center py-6">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="check-circle" class="w-10 h-10 text-green-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Password Reset Successful!</h3>
                        <p class="text-gray-500 mb-6">Your password has been changed. You can now login with your new password.</p>
                        <a href="adminlogin.php" 
                            class="btn-primary inline-flex py-3 px-8 text-white font-semibold rounded-xl items-center gap-2">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                            Go to Login
                        </a>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="adminlogin.php" class="text-violet-600 hover:text-violet-800 text-sm font-medium flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Login
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
                    <p class="text-violet-200 mb-6">Password Recovery</p>
                    <div class="space-y-3 text-left bg-white/10 rounded-2xl p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Step 1: Verify Mobile & Username</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="shield" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Step 2: Security Verification</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i data-lucide="key" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm">Step 3: Set New Password</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        let verifiedUserId = null;
        let verifiedMobile = '';

        // ─── Step Navigation ────────────────────────────────────
        function goToStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');

            // Update indicators
            for (let i = 1; i <= 3; i++) {
                const ind = document.getElementById('stepInd' + i);
                ind.classList.remove('active', 'completed');
                ind.classList.add(i < step ? 'completed' : (i === step ? 'active' : ''));
                if (i < step) {
                    ind.innerHTML = '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>';
                }
            }
            // Update lines
            if (step >= 2) document.getElementById('stepLine1').classList.add('bg-green-400');
            if (step >= 3) document.getElementById('stepLine2').classList.add('bg-green-400');

            lucide.createIcons();
        }

        // ─── Step 1: Verify Identity ────────────────────────────
        function verifyIdentity() {
            const mobile = document.getElementById('resetMobile').value.trim();
            const username = document.getElementById('resetUsername').value.trim();

            if (!mobile || !username) {
                toastr.warning('Please enter both mobile number and username');
                return;
            }

            const btn = document.getElementById('verifyBtn');
            btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Verifying...';
            btn.disabled = true;
            lucide.createIcons();

            $.ajax({
                url: 'functions.php',
                type: 'POST',
                data: {
                    RESULT_TYPE: 'FORGOT_VERIFY_IDENTITY',
                    mobile: mobile,
                    username: username
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            verifiedUserId = data.userId;
                            verifiedMobile = mobile;
                            document.getElementById('verifiedUser').textContent = data.username;
                            toastr.success('Identity verified!');
                            goToStep(2);
                        } else {
                            toastr.error(data.message || 'Verification failed');
                        }
                    } catch(e) {
                        toastr.error('Server error');
                    }
                    btn.innerHTML = '<i data-lucide="shield-check" class="w-5 h-5"></i> Verify Identity';
                    btn.disabled = false;
                    lucide.createIcons();
                },
                error: function() {
                    toastr.error('Connection error');
                    btn.innerHTML = '<i data-lucide="shield-check" class="w-5 h-5"></i> Verify Identity';
                    btn.disabled = false;
                    lucide.createIcons();
                }
            });
        }

        // ─── Step 2: Security Answer ────────────────────────────
        function verifySecurityAnswer() {
            const answer = document.getElementById('securityAnswer').value.trim();

            if (!answer) {
                toastr.warning('Please enter the last 4 digits');
                return;
            }

            const last4 = verifiedMobile.slice(-4);
            if (answer !== last4) {
                toastr.error('Incorrect. Please enter the last 4 digits of your mobile number.');
                return;
            }

            toastr.success('Security check passed!');
            goToStep(3);
        }

        // ─── Password Strength ──────────────────────────────────
        document.addEventListener('DOMContentLoaded', function() {
            const pwInput = document.getElementById('newPassword');
            if (pwInput) {
                pwInput.addEventListener('input', function() {
                    const pw = this.value;
                    const strengthDiv = document.getElementById('passwordStrength');
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
                        const el = document.getElementById('str' + i);
                        el.className = 'h-1 flex-1 rounded-full ' + (i <= score ? colors[score - 1] : 'bg-gray-200');
                    }
                    document.getElementById('strText').textContent = texts[score - 1] || '';
                    document.getElementById('strText').className = 'text-xs ' + (
                        score <= 1 ? 'text-red-500' : score === 2 ? 'text-orange-500' : score === 3 ? 'text-yellow-600' : 'text-green-600'
                    );
                });
            }
        });

        // ─── Step 3: Reset Password ─────────────────────────────
        function resetPassword() {
            const newPw = document.getElementById('newPassword').value;
            const confirmPw = document.getElementById('confirmPassword').value;

            if (!newPw || !confirmPw) {
                toastr.warning('Please fill in both password fields');
                return;
            }
            if (newPw.length < 4) {
                toastr.warning('Password must be at least 4 characters');
                return;
            }
            if (newPw !== confirmPw) {
                toastr.error('Passwords do not match');
                return;
            }

            const btn = document.getElementById('resetBtn');
            btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Resetting...';
            btn.disabled = true;
            lucide.createIcons();

            $.ajax({
                url: 'functions.php',
                type: 'POST',
                data: {
                    RESULT_TYPE: 'FORGOT_RESET_PASSWORD',
                    userId: verifiedUserId,
                    mobile: verifiedMobile,
                    newPassword: newPw
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        if (data.success) {
                            toastr.success('Password reset successfully!');
                            // Show success state
                            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
                            document.getElementById('successState').classList.add('active');
                            // Update all indicators to completed
                            for (let i = 1; i <= 3; i++) {
                                const ind = document.getElementById('stepInd' + i);
                                ind.classList.remove('active');
                                ind.classList.add('completed');
                                ind.innerHTML = '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>';
                            }
                            lucide.createIcons();
                        } else {
                            toastr.error(data.message || 'Reset failed');
                            btn.innerHTML = '<i data-lucide="key" class="w-5 h-5"></i> Reset Password';
                            btn.disabled = false;
                            lucide.createIcons();
                        }
                    } catch(e) {
                        toastr.error('Server error');
                        btn.innerHTML = '<i data-lucide="key" class="w-5 h-5"></i> Reset Password';
                        btn.disabled = false;
                        lucide.createIcons();
                    }
                },
                error: function() {
                    toastr.error('Connection error');
                    btn.innerHTML = '<i data-lucide="key" class="w-5 h-5"></i> Reset Password';
                    btn.disabled = false;
                    lucide.createIcons();
                }
            });
        }
    </script>
</body>
</html>
