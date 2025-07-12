<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ session('artisan_playground_theme', config('artisan-playground.ui.theme.default', 'light')) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Execute Command - {{ $command['name'] }} - Artisan Playground</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
        <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/artisan-playground/css/app.css') }}" rel="stylesheet">
    
    <style>
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
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--light) 100%);
            min-height: 100vh;
            color: var(--gray-900);
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        [data-bs-theme="dark"] .header {
            background: rgba(30, 41, 59, 0.8);
            border-bottom: 1px solid var(--gray-700);
        }

        .logo {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        [data-bs-theme="dark"] .content-card {
            background: var(--gray-800);
            border-color: var(--gray-700);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        /* Warning Banner */
        .warning-banner {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .warning-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .warning-content {
            position: relative;
            z-index: 1;
        }

        /* Form Elements */
        .form-control, .form-select {
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            background: var(--gray-50);
            color: var(--gray-900);
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background: white;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background: var(--gray-700);
            border-color: var(--gray-600);
            color: var(--gray-100);
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background: var(--gray-600);
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        [data-bs-theme="dark"] .form-label {
            color: var(--gray-300);
        }

        .form-text {
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .argument-required {
            border-left: 4px solid var(--danger);
        }

        .option-flag {
            background: var(--gray-100);
            border: 1px solid var(--gray-300);
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 500;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
        }

        [data-bs-theme="dark"] .option-flag {
            background: var(--gray-600);
            border-color: var(--gray-500);
        }

        /* Buttons */
        .btn {
            border-radius: var(--radius);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        /* Badges */
        .badge {
            border-radius: var(--radius);
            font-weight: 600;
            padding: 0.5rem 0.75rem;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        [data-bs-theme="dark"] .badge-secondary {
            background: var(--gray-600);
            color: var(--gray-200);
        }

        /* Command Output */
        .command-output {
            background: var(--dark);
            color: #e2e8f0;
            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            max-height: 500px;
            overflow-y: auto;
            white-space: pre-wrap;
            font-size: 0.875rem;
            line-height: 1.6;
            border: 1px solid var(--gray-300);
        }

        [data-bs-theme="dark"] .command-output {
            border-color: var(--gray-600);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 3.5rem;
            height: 3.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.25rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            z-index: 1000;
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

        /* Responsive */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container-fluid px-4 py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('artisan-playground.dashboard') }}" class="logo text-decoration-none">
                        <i class="fas fa-terminal me-2"></i>
                        Artisan Playground
                    </a>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('artisan-playground.dashboard') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Dashboard
                    </a>
                    @if(config('artisan-playground.auth.enabled'))
                    <form action="{{ route('artisan-playground.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Logout
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-icon">
                <i class="fas fa-play"></i>
            </div>
            <div class="page-header-content">
                <h1>Execute Command</h1>
                <p>{{ $command['name'] }}</p>
            </div>
        </div>

        @if($isDangerous)
        <div class="warning-banner fade-in-up">
            <div class="warning-content">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                    <h5 class="mb-0 fw-bold">Dangerous Command Warning</h5>
                </div>
                <p class="mb-0 opacity-90">
                    This command is marked as dangerous and can affect system stability. 
                    Please ensure you understand what this command does before executing it.
                </p>
            </div>
        </div>
        @endif

        <!-- Command Information -->
        <div class="content-card fade-in-up">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                <h5>Command Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <strong class="text-muted">Name:</strong>
                            <code class="bg-light px-2 py-1 rounded">{{ $command['name'] }}</code>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-muted">Status:</strong>
                            @if($isDangerous)
                            <span class="badge badge-danger">
                                <i class="fas fa-exclamation-triangle me-1"></i> Dangerous
                            </span>
                            @else
                            <span class="badge badge-success">
                                <i class="fas fa-check me-1"></i> Safe
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="mb-2">
                            <strong class="text-muted d-block mb-1">Description:</strong>
                            <p class="mb-0">{{ $command['description'] }}</p>
                        </div>
                        @if($command['help'])
                        <div>
                            <strong class="text-muted d-block mb-1">Help:</strong>
                            <p class="mb-0 small">{{ $command['help'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Command Execution Form -->
        <div class="content-card fade-in-up">
            <div class="card-header">
                <i class="fas fa-cog"></i>
                <h5>Command Parameters</h5>
            </div>
            <div class="card-body">
                <form id="commandForm">
                    @csrf
                    <input type="hidden" name="command" value="{{ $command['name'] }}">
                    
                    <!-- Arguments -->
                    @if(count($command['arguments']) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="fas fa-list text-primary"></i>
                            Arguments
                        </h6>
                        @foreach($command['arguments'] as $argument)
                        <div class="mb-3">
                            <label for="arg_{{ $argument['name'] }}" class="form-label">
                                {{ $argument['name'] }}
                                @if($argument['required'])
                                <span class="text-danger">*</span>
                                @endif
                            </label>
                            <input type="text" 
                                   class="form-control {{ $argument['required'] ? 'argument-required' : '' }}" 
                                   id="arg_{{ $argument['name'] }}" 
                                   name="arguments[{{ $argument['name'] }}]"
                                   placeholder="{{ $argument['description'] }}"
                                   @if($argument['required']) required @endif
                                   @if($argument['default'] !== null) value="{{ $argument['default'] }}" @endif>
                            <div class="form-text">
                                {{ $argument['description'] }}
                                @if($argument['is_array'])
                                <span class="badge badge-info ms-1">Array</span>
                                @endif
                                @if($argument['default'] !== null)
                                <span class="badge badge-secondary ms-1">Default: {{ $argument['default'] }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Options -->
                    @if(count($command['options']) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="fas fa-sliders-h text-primary"></i>
                            Options
                        </h6>
                        @foreach($command['options'] as $option)
                        <div class="mb-3">
                            <div class="form-check">
                                @if($option['accept_value'])
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="opt_{{ $option['name'] }}" 
                                                   name="options[{{ $option['name'] }}]"
                                                   value="1">
                                            <label class="form-check-label fw-medium" for="opt_{{ $option['name'] }}">
                                                {{ $option['name'] }}
                                                @if($option['shortcut'])
                                                <span class="option-flag">-{{ $option['shortcut'] }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" 
                                               class="form-control" 
                                               id="opt_{{ $option['name'] }}_value" 
                                               name="options[{{ $option['name'] }}_value]"
                                               placeholder="Value for {{ $option['name'] }}"
                                               @if($option['default'] !== null) value="{{ $option['default'] }}" @endif>
                                    </div>
                                </div>
                                @else
                                <div class="d-flex align-items-center gap-2">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="opt_{{ $option['name'] }}" 
                                           name="options[{{ $option['name'] }}]"
                                           value="1">
                                    <label class="form-check-label fw-medium" for="opt_{{ $option['name'] }}">
                                        {{ $option['name'] }}
                                        @if($option['shortcut'])
                                        <span class="option-flag">-{{ $option['shortcut'] }}</span>
                                        @endif
                                    </label>
                                </div>
                                @endif
                            </div>
                            <div class="form-text">
                                {{ $option['description'] }}
                                @if($option['is_array'])
                                <span class="badge badge-info ms-1">Array</span>
                                @endif
                                @if($option['default'] !== null)
                                <span class="badge badge-secondary ms-1">Default: {{ $option['default'] }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary" id="executeBtn">
                            <i class="fas fa-play me-1"></i> Execute Command
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Command Output -->
        <div class="content-card fade-in-up" id="outputCard" style="display: none;">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-terminal"></i>
                    <h5>Command Output</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-secondary" id="executionTime"></span>
                    <button class="btn btn-sm btn-outline-light" onclick="copyOutput()">
                        <i class="fas fa-copy me-1"></i> Copy
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="command-output" id="commandOutput"></div>
            </div>
        </div>
    </main>

    <!-- Theme Toggle -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Artisan Playground JS -->
    <script src="{{ asset('vendor/artisan-playground/js/app.js') }}"></script>
</body>
</html> 