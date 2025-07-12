<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ session('artisan_playground_theme', config('artisan-playground.ui.theme.default', 'light')) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisan Playground - Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="@artisanPlaygroundAsset('css/app.css')" rel="stylesheet">
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
                    <a href="{{ route('artisan-playground.history') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-history me-1"></i>
                        History
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
        <!-- Search Bar -->
        <div class="search-container mb-4">
            <i class="fas fa-search search-icon"></i>
            <input type="text" 
                   id="commandSearch" 
                   class="search-input" 
                   placeholder="Search commands by name or description... (⌘K)"
                   autocomplete="off">
            <button type="button" class="search-clear" id="searchClear" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
            <div class="search-shortcut" id="searchShortcut">
                <kbd id="cmdKey">⌘</kbd><kbd>K</kbd>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card fade-in-up">
                <div class="stat-icon">
                    <i class="fas fa-terminal"></i>
                </div>
                <div class="stat-value">{{ $stats['total_commands'] }}</div>
                <div class="stat-label">Total Commands</div>
            </div>
            
            <div class="stat-card fade-in-up">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-value">{{ $stats['dangerous_commands'] }}</div>
                <div class="stat-label">Dangerous Commands</div>
            </div>
            
            <div class="stat-card fade-in-up">
                <div class="stat-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stat-value">{{ $stats['today_commands'] }}</div>
                <div class="stat-label">Today's Executions</div>
            </div>
            
            <div class="stat-card fade-in-up">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ round($stats['avg_execution_time'], 2) }}s</div>
                <div class="stat-label">Avg Execution Time</div>
            </div>
        </div>

        <!-- Command Groups -->
        @if(count($commands) > 0)
            @php
                // Define the order we want to display groups
                $groupOrder = ['custom', 'dangerous', 'database', 'cache', 'default'];
                $orderedCommands = [];
                
                // Reorder commands based on our preferred order
                foreach ($groupOrder as $groupKey) {
                    if (isset($commands[$groupKey])) {
                        $orderedCommands[$groupKey] = $commands[$groupKey];
                    }
                }
                
                // Add any remaining groups that weren't in our order
                foreach ($commands as $groupKey => $groupCommands) {
                    if (!isset($orderedCommands[$groupKey])) {
                        $orderedCommands[$groupKey] = $groupCommands;
                    }
                }
            @endphp
            
            @foreach($orderedCommands as $groupKey => $groupCommands)
            <div class="command-section" id="{{ $groupKey }}">
                <div class="section-header">
                    <h2 class="section-title">
                        <div class="section-icon">
                            <i class="{{ config('artisan-playground.command_groups.' . $groupKey . '.icon', 'fas fa-cog') }}"></i>
                        </div>
                        {{ config('artisan-playground.command_groups.' . $groupKey . '.name', 'Commands') }}
                    </h2>
                    <div class="command-count">{{ count($groupCommands) }} commands</div>
                </div>
                
                <div class="command-grid" id="commands-{{ $groupKey }}">
                    @foreach($groupCommands as $command)
                    <div class="command-card {{ $command['is_dangerous'] ? 'dangerous' : '' }} command-item" 
                         data-command="{{ strtolower($command['name']) }}" 
                         data-description="{{ strtolower($command['description']) }}"
                         onclick="window.location.href='{{ route('artisan-playground.command', $command['name']) }}'">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="command-name">{{ $command['name'] }}</h3>
                            @if($command['is_dangerous'])
                            <span class="command-badge">
                                <i class="fas fa-exclamation-triangle"></i>
                                Dangerous
                            </span>
                            @endif
                        </div>
                        <p class="command-description">{{ $command['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-terminal"></i>
                </div>
                <h3 class="empty-state-title">No Commands Found</h3>
                <p class="empty-state-text">
                    It seems there are no Artisan commands available. Please check your Laravel installation.
                </p>
            </div>
        @endif

        <!-- Recent Commands -->
        @if($recentCommands->count() > 0)
        <div class="command-section">
            <div class="section-header">
                <h2 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    Recent Commands
                </h2>
            </div>
            
            <div class="recent-table">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Command</th>
                                <th>User</th>
                                <th>Execution Time</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentCommands as $command)
                            <tr>
                                <td>
                                    <code class="fw-semibold">{{ $command->command_name }}</code>
                                    @if($command->is_dangerous)
                                    <span class="command-badge ms-2">Dangerous</span>
                                    @endif
                                </td>
                                <td>{{ $command->user->name ?? 'Custom User' }}</td>
                                <td>{{ round($command->execution_time, 2) }}s</td>
                                <td>
                                    @if($command->exit_code === 0)
                                    <span class="status-badge status-success">Success</span>
                                    @else
                                    <span class="status-badge status-danger">Failed</span>
                                    @endif
                                </td>
                                <td>{{ $command->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </main>

    <!-- Theme Toggle -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Artisan Playground JS -->
    <script src="@artisanPlaygroundAsset('js/app.js')"></script>
</body>
</html> 