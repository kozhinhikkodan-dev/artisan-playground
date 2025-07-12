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
                            <i class="fas fa-{{ $useCustomCredentials ? 'user' : 'envelope' }}"></i>
                            {{ $useCustomCredentials ? 'Username' : 'Email Address' }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-{{ $useCustomCredentials ? 'user' : 'envelope' }}"></i>
                            </span>
                            <input type="{{ $useCustomCredentials ? 'text' : 'email' }}" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your {{ $useCustomCredentials ? 'username' : 'email' }}"
                                   required 
                                   autocomplete="{{ $useCustomCredentials ? 'username' : 'email' }}"
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