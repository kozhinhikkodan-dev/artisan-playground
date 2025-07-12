<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ session('artisan_playground_theme', config('artisan-playground.ui.theme.default', 'light')) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Artisan Playground</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/artisan-playground/css/app.css') }}" rel="stylesheet">
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
        }

        [data-bs-theme="dark"] {
            --light: #1e293b;
            --dark: #0f172a;
            --gray-50: #1e293b;
            --gray-100: #334155;
            --gray-200: #475569;
            --gray-300: #64748b;
            --gray-400: #94a3b8;
            --gray-500: #cbd5e1;
            --gray-600: #e2e8f0;
            --gray-700: #f1f5f9;
            --gray-800: #f8fafc;
            --gray-900: #ffffff;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .login-card {
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            position: relative;
        }

        [data-bs-theme="dark"] .login-card {
            background: var(--gray-800);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        /* Header */
        .login-header {
            text-align: center;
            padding: 3rem 2rem 2rem;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--light) 100%);
        }

        [data-bs-theme="dark"] .login-header {
            background: linear-gradient(135deg, var(--gray-700) 0%, var(--gray-600) 100%);
        }

        .logo {
            font-weight: 800;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .login-subtitle {
            color: var(--gray-600);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        [data-bs-theme="dark"] .login-subtitle {
            color: var(--gray-400);
        }

        /* Form */
        .login-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        [data-bs-theme="dark"] .form-label {
            color: var(--gray-300);
        }

        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 0.875rem 1rem;
            background: var(--gray-50);
            color: var(--gray-900);
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        [data-bs-theme="dark"] .form-control {
            background: var(--gray-700);
            border-color: var(--gray-600);
            color: var(--gray-100);
        }

        [data-bs-theme="dark"] .form-control:focus {
            background: var(--gray-600);
        }

        .input-group-text {
            background: var(--gray-100);
            border: 2px solid var(--gray-200);
            border-right: none;
            color: var(--gray-500);
        }

        [data-bs-theme="dark"] .input-group-text {
            background: var(--gray-600);
            border-color: var(--gray-500);
            color: var(--gray-400);
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group .form-control:focus {
            border-left: none;
        }

        /* Buttons */
        .btn {
            border-radius: var(--radius);
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Error Messages */
        .alert {
            border: none;
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        [data-bs-theme="dark"] .alert-danger {
            background: #450a0a;
            color: #fca5a5;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 2rem;
            right: 2rem;
            width: 3rem;
            height: 3rem;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            color: var(--gray-700);
            font-size: 1.1rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        [data-bs-theme="dark"] .theme-toggle {
            background: rgba(30, 41, 59, 0.9);
            color: var(--gray-300);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-xl);
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid currentColor;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-form {
                padding: 1.5rem;
            }
            
            .logo {
                font-size: 1.75rem;
            }
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="90" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="90" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
            z-index: -1;
        }
    </style>
</head>
<body class="login-page">
    <!-- Theme Toggle -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card fade-in-up">
            <!-- Header -->
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-terminal"></i>
                    Artisan Playground
                </div>
                <p class="login-subtitle">Execute Laravel Artisan commands with ease</p>
            </div>

            <!-- Form -->
            <div class="login-form">
                @if($errors->any())
                <div class="alert alert-danger">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Login Failed</strong>
                    </div>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('artisan-playground.login') }}" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email"
                                   required 
                                   autocomplete="email"
                                   autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   required 
                                   autocomplete="current-password">
                            <button type="button" 
                                    class="btn btn-outline-secondary" 
                                    id="togglePassword"
                                    style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="remember" 
                                   name="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="loginBtn">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Sign In
                    </button>
                </form>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">
                        Secure access to Laravel Artisan commands
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme switching
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('artisan_playground_theme', newTheme);
            
            const icon = document.getElementById('themeIcon');
            icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        }

        // Initialize theme
        function initializeTheme() {
            const savedTheme = localStorage.getItem('artisan_playground_theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
                const icon = document.getElementById('themeIcon');
                icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
        }

        // Password toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="spinner me-2"></span>Signing In...';
        });

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            initializeTheme();
            
            document.getElementById('themeToggle').addEventListener('click', toggleTheme);
            document.getElementById('togglePassword').addEventListener('click', togglePassword);
            
            // Focus on email field
            document.getElementById('email').focus();
        });
    </script>
</body>
</html> 
</html> 