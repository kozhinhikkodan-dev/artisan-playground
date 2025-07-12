<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ session('artisan_playground_theme', config('artisan-playground.ui.theme.default', 'light')) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command History - Artisan Playground</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/artisan-playground/css/app.css') }}" rel="stylesheet">
       
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
                <i class="fas fa-history"></i>
            </div>
            <div class="page-header-content">
                <h1>Command History</h1>
                <p>View and manage executed commands</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-section fade-in-up">
            <h6 class="filter-title">
                <i class="fas fa-filter text-primary"></i>
                Filter Commands
            </h6>
                            <form method="GET" action="{{ route('artisan-playground.history') }}" class="row g-3" id="filterForm">
                <div class="col-md-3">
                    <label for="command" class="form-label">Command Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="command" 
                           name="command" 
                           value="{{ request('command') }}" 
                           placeholder="Filter by command name">
                </div>
                <div class="col-md-3">
                    <label for="user" class="form-label">User</label>
                    <input type="text" 
                           class="form-control" 
                           id="user" 
                           name="user" 
                           value="{{ request('user') }}" 
                           placeholder="Filter by user">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="dangerous" class="form-label">Type</label>
                    <select class="form-select" id="dangerous" name="dangerous">
                        <option value="">All Types</option>
                        <option value="1" {{ request('dangerous') === '1' ? 'selected' : '' }}>Dangerous</option>
                        <option value="0" {{ request('dangerous') === '0' ? 'selected' : '' }}>Safe</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Command History Table -->
        <div class="content-card fade-in-up">
            <div class="card-header">
                <h5>
                    <i class="fas fa-list"></i>
                    Executed Commands
                </h5>
                <span class="badge badge-secondary">{{ $commands->total() }} total</span>
            </div>
            <div class="card-body">
                @if($commands->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Command</th>
                                <th>User</th>
                                <th>Arguments</th>
                                <th>Options</th>
                                <th>Output</th>
                                <th>Execution Time</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commands as $command)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <code class="fw-semibold">{{ $command->command_name }}</code>
                                        @if($command->is_dangerous)
                                        <span class="badge badge-danger">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Dangerous
                                        </span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $command->command_group }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fas fa-user-circle text-primary"></i>
                                        <span class="fw-medium">{{ $command->user->name ?? 'Custom User' }}</span>
                                    </div>
                                    <small class="text-muted">{{ $command->ip_address }}</small>
                                </td>
                                <td>
                                    @if($command->arguments)
                                        @foreach($command->arguments as $key => $value)
                                        <div class="mb-1">
                                            <small>
                                                <strong class="text-primary">{{ $key }}:</strong> 
                                                <code>{{ $value }}</code>
                                            </small>
                                        </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                                <td>
                                    @if($command->options)
                                        @foreach($command->options as $key => $value)
                                        <div class="mb-1">
                                            <small>
                                                <strong class="text-primary">{{ $key }}:</strong> 
                                                <code>{{ $value }}</code>
                                            </small>
                                        </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                                <td>
                                    @if($command->output)
                                    <div class="command-output-preview" title="{{ $command->output }}">
                                        {{ Str::limit($command->output, 100) }}
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary mt-1" 
                                            onclick="showOutput('{{ addslashes($command->output) }}')">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                    @else
                                    <span class="text-muted small">No output</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ round($command->execution_time, 2) }}s</span>
                                </td>
                                <td>
                                    @if($command->exit_code === 0)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check me-1"></i> Success
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times me-1"></i> Failed ({{ $command->exit_code }})
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $command->created_at->format('M j, Y') }}</div>
                                    <small class="text-muted">{{ $command->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                onclick="reExecuteCommand('{{ $command->command_name }}', {{ json_encode($command->arguments) }}, {{ json_encode($command->options) }})"
                                                title="Re-execute command">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                onclick="showDetails({{ $command->id }})"
                                                title="View details">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $commands->appends(request()->query())->links() }}
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="empty-state-title">No Commands Executed Yet</h3>
                    <p class="empty-state-text">
                        Start by executing some commands from the dashboard to see them here.
                    </p>
                    <a href="{{ route('artisan-playground.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Go to Dashboard
                    </a>
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Output Modal -->
    <div class="modal fade" id="outputModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-terminal me-2"></i>
                        Command Output
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <pre id="outputContent" class="output-content"></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="copyOutput()">
                        <i class="fas fa-copy me-1"></i> Copy
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Command Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailsContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Filter form handling
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const filterInputs = filterForm.querySelectorAll('input, select');
            
            // Auto-submit form when filters change
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    filterForm.submit();
                });
            });
            
            // Clear filters button
            const clearFiltersBtn = document.getElementById('clearFilters');
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', function() {
                    // Clear all form inputs
                    filterInputs.forEach(input => {
                        if (input.type === 'text' || input.type === 'select-one') {
                            input.value = '';
                        } else if (input.type === 'checkbox') {
                            input.checked = false;
                        }
                    });
                    filterForm.submit();
                });
            }
        });
        
        // Theme toggle functionality
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

        function showOutput(output) {
            document.getElementById('outputContent').textContent = output;
            new bootstrap.Modal(document.getElementById('outputModal')).show();
        }

        function copyOutput() {
            const output = document.getElementById('outputContent').textContent;
            navigator.clipboard.writeText(output).then(() => {
                // Show success message
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 2000);
            });
        }

        function reExecuteCommand(commandName, arguments, options) {
            if (confirm('Do you want to re-execute this command?')) {
                // Redirect to command page with pre-filled parameters
                const params = new URLSearchParams();
                params.append('command', commandName);
                if (arguments) {
                    Object.keys(arguments).forEach(key => {
                        params.append(`arguments[${key}]`, arguments[key]);
                    });
                }
                if (options) {
                    Object.keys(options).forEach(key => {
                        params.append(`options[${key}]`, options[key]);
                    });
                }
                window.location.href = `{{ route('artisan-playground.dashboard') }}?${params.toString()}`;
            }
        }

        function showDetails(commandId) {
            // Load command details via AJAX
            fetch(`/artisan-playground/command-details/${commandId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailsContent').innerHTML = data.html;
                    new bootstrap.Modal(document.getElementById('detailsModal')).show();
                })
                .catch(error => {
                    console.error('Error loading command details:', error);
                    alert('Error loading command details');
                });
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            initializeTheme();
            document.getElementById('themeToggle').addEventListener('click', toggleTheme);
        });
    </script>
</body>
</html> 