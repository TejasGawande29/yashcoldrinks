<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Logout - Admin | YASH ColdDrinks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
            min-height: 100vh;
        }
        
        .logout-container {
            background: linear-gradient(135deg, #ffffff 0%, #f9f7ff 100%);
            box-shadow: 0 10px 30px rgba(109, 40, 217, 0.15);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .logout-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(109, 40, 217, 0.2);
        }
        
        .logout-header {
            background: linear-gradient(135deg, #7e22ce 0%, #6d28d9 100%);
        }
        
        .confirmation-text {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-cancel {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            transition: all 0.3s ease;
        }
        
        .btn-cancel:hover {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            transform: translateY(-2px);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
        }
        
        .wave-pattern {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%237e22ce' fill-opacity='0.1' d='M0,160L48,165.3C96,171,192,181,288,197.3C384,213,480,235,576,229.3C672,224,768,192,864,181.3C960,171,1056,181,1152,192C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div 
        x-data="{ showLogoutModal: true }"
        x-show="showLogoutModal"
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-[9999]"
        x-cloak
        x-transition
    >
        <div class="logout-container w-full max-w-md overflow-hidden">
            <div class="logout-header p-6 text-center">
                <div class="flex justify-center mb-4 floating">
                    <div class="bg-white/20 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-white">Logout Confirmation</h2>
            </div>
            
            <div class="p-8 text-center relative">
                <div class="absolute -top-10 left-1/2 transform -translate-x-1/2">
                    <div class="bg-white rounded-full p-2 shadow-lg pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#7e22ce" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold mb-2 confirmation-text">Are you sure you want to log out?</h3>
                <p class="text-gray-600 mb-6">You'll need to sign in again to access your admin dashboard</p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button 
                        @click="showLogoutModal = false; setTimeout(() => window.location.href = 'dashboard.php', 300)"
                        class="btn-cancel px-6 py-3 rounded-lg font-semibold text-gray-700 flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        Cancel
                    </button>
                    
                    <button 
                        @click="showLogoutModal = false; setTimeout(() => window.location.href = 'logout.php', 500)"
                        class="btn-logout px-6 py-3 rounded-lg font-semibold text-white flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </button>
                </div>
                
                <div class="mt-8 text-gray-500 text-sm flex flex-col items-center">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span class="ml-2">Logged in as: <span class="font-semibold">Yash Walivakar</span></span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                        <span class="ml-2">Role: <span class="font-semibold">Administrator</span></span>
                    </div>
                </div>
            </div>
            
            <div class="wave-pattern"></div>
        </div>
    </div>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Add a subtle animation to the logout button
        document.querySelector('.btn-logout').addEventListener('mouseover', function() {
            this.classList.add('animate-pulse');
        });
        
        document.querySelector('.btn-logout').addEventListener('mouseout', function() {
            this.classList.remove('animate-pulse');
        });
        
        // Prevent accidental closing of modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>