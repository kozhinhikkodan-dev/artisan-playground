<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use KozhinhikkodanDev\ArtisanPlayground\Models\ArtisanCommand;

class ArtisanPlaygroundController extends Controller
{
    /**
     * Show the main dashboard.
     */
    public function index()
    {
        $commands = $this->getAvailableCommands();
        $recentCommands = $this->getRecentCommands();
        $stats = $this->getStats();

        return view('artisan-playground::dashboard', compact('commands', 'recentCommands', 'stats'));
    }

    /**
     * Show command details and execution form.
     */
    public function showCommand(Request $request, $commandName)
    {
        $command = $this->getCommandDetails($commandName);

        if (!$command) {
            abort(404, 'Command not found');
        }

        $isDangerous = $this->isDangerousCommand($commandName);

        if ($isDangerous && !Gate::allows('executeDangerous', ArtisanCommand::class)) {
            abort(403, 'You do not have permission to execute dangerous commands');
        }

        return view('artisan-playground::command', compact('command', 'isDangerous'));
    }

    /**
     * Execute a command.
     */
    public function executeCommand(Request $request)
    {
        $request->validate([
            'command' => 'required|string',
            'arguments' => 'array',
            'options' => 'array',
        ]);

        $commandName = $request->input('command');
        $arguments = $request->input('arguments', []);
        $options = $request->input('options', []);

        // Check if command is dangerous
        if ($this->isDangerousCommand($commandName) && !Gate::allows('executeDangerous', ArtisanCommand::class)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to execute dangerous commands',
            ], 403);
        }

        try {
            $startTime = microtime(true);

            // Execute the command
            $output = $this->executeArtisanCommand($commandName, $arguments, $options);

            $executionTime = microtime(true) - $startTime;

            // Save command execution
            if (config('artisan-playground.execution.save_history')) {
                $this->saveCommandExecution($commandName, $arguments, $options, $output, $executionTime);
            }

            return response()->json([
                'success' => true,
                'output' => $output,
                'execution_time' => round($executionTime, 2),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get command history.
     */
    public function history(Request $request)
    {
        $perPage = 20;
        $commands = ArtisanCommand::with('user')
            ->when($request->input('command'), function ($query, $command) {
                return $query->where('command_name', 'LIKE', "%$command%");
            })
            ->when($request->input('user'), function ($query, $user) {
                return $query->whereHas('user', function ($query) use ($user) {
                    $query->where('name', 'LIKE', "%$user%");
                });
            })
            ->when($request->input('status'), function ($query, $status) {
                return $query->where('exit_code', $status === 'failed' ? '!= 0' : 0);
            })
            ->when($request->input('dangerous'), function ($query, $dangerous) {
                return $query->where('is_dangerous', $dangerous ? 1 : 0);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $commands->appends($request->query());

        return view('artisan-playground::history', compact('commands'));
    }

    /**
     * Get available commands.
     */
    protected function getAvailableCommands(): array
    {
        $commands = [];
        $config = config('artisan-playground');

        // Get all available Artisan commands
        $artisanCommands = Artisan::all();

        foreach ($artisanCommands as $name => $command) {
            $group = $this->getCommandGroup($name, $config);
            $commands[$group][] = [
                'name' => $name,
                'description' => $command->getDescription(),
                'is_dangerous' => $this->isDangerousCommand($name),
            ];
        }

        return $commands;
    }

    /**
     * Get command details.
     */
    protected function getCommandDetails(string $commandName): ?array
    {
        $artisanCommands = Artisan::all();

        if (!isset($artisanCommands[$commandName])) {
            return null;
        }

        $command = $artisanCommands[$commandName];
        $definition = $command->getDefinition();

        return [
            'name' => $commandName,
            'description' => $command->getDescription(),
            'help' => $command->getHelp(),
            'arguments' => $this->getArguments($definition),
            'options' => $this->getOptions($definition),
        ];
    }

    /**
     * Get command arguments.
     */
    protected function getArguments($definition): array
    {
        $arguments = [];

        foreach ($definition->getArguments() as $argument) {
            $arguments[] = [
                'name' => $argument->getName(),
                'description' => $argument->getDescription(),
                'required' => $argument->isRequired(),
                'default' => $argument->getDefault(),
                'is_array' => $argument->isArray(),
            ];
        }

        return $arguments;
    }

    /**
     * Get command options.
     */
    protected function getOptions($definition): array
    {
        $options = [];

        foreach ($definition->getOptions() as $option) {
            $options[] = [
                'name' => $option->getName(),
                'shortcut' => $option->getShortcut(),
                'description' => $option->getDescription(),
                'required' => $option->isValueRequired(),
                'optional' => $option->isValueOptional(),
                'default' => $option->getDefault(),
                'is_array' => $option->isArray(),
                'accept_value' => $option->acceptValue(),
            ];
        }

        return $options;
    }

    /**
     * Execute an Artisan command.
     */
    protected function executeArtisanCommand(string $commandName, array $arguments = [], array $options = []): string
    {
        // Build the command string
        $commandString = $commandName;

        // Add arguments
        foreach ($arguments as $key => $value) {
            if (is_numeric($key)) {
                $commandString .= ' ' . escapeshellarg($value);
            } else {
                $commandString .= ' ' . escapeshellarg($value);
            }
        }

        // Add options
        foreach ($options as $key => $value) {
            if ($value === true) {
                $commandString .= ' --' . $key;
            } else {
                $commandString .= ' --' . $key . '=' . escapeshellarg($value);
            }
        }

        // Execute using Artisan::call
        $exitCode = Artisan::call($commandName, array_merge($arguments, $options));

        if ($exitCode !== 0) {
            throw new \Exception('Command failed with exit code: ' . $exitCode);
        }

        return Artisan::output();
    }

    /**
     * Save command execution to database.
     */
    protected function saveCommandExecution(string $commandName, array $arguments, array $options, string $output, float $executionTime): void
    {
        ArtisanCommand::create([
            'command_name' => $commandName,
            'arguments' => $arguments,
            'options' => $options,
            'output' => substr($output, 0, config('artisan-playground.execution.max_output_length')),
            'exit_code' => 0,
            'execution_time' => $executionTime,
            'executed_by' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'is_dangerous' => $this->isDangerousCommand($commandName),
            'command_group' => $this->getCommandGroup($commandName, config('artisan-playground')),
        ]);
    }

    /**
     * Get recent commands.
     */
    protected function getRecentCommands()
    {
        return ArtisanCommand::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get statistics.
     */
    protected function getStats(): array
    {
        return [
            'total_commands' => ArtisanCommand::count(),
            'dangerous_commands' => ArtisanCommand::dangerous()->count(),
            'today_commands' => ArtisanCommand::whereDate('created_at', today())->count(),
            'avg_execution_time' => ArtisanCommand::avg('execution_time'),
        ];
    }

    /**
     * Check if command is dangerous.
     */
    protected function isDangerousCommand(string $commandName): bool
    {
        $dangerousCommands = config('artisan-playground.dangerous_commands', []);
        return in_array($commandName, $dangerousCommands);
    }

    /**
     * Get command group.
     */
    protected function getCommandGroup(string $commandName, array $config): string
    {
        if ($this->isDangerousCommand($commandName)) {
            return 'dangerous';
        }

        // Check for database commands
        if (str_starts_with($commandName, 'migrate') || str_starts_with($commandName, 'db:')) {
            return 'database';
        }

        // Check for cache commands
        if (str_starts_with($commandName, 'cache:') || str_starts_with($commandName, 'config:') || str_starts_with($commandName, 'view:') || str_starts_with($commandName, 'route:')) {
            return 'cache';
        }

        // Check for custom commands (commands that don't start with common prefixes)
        $customPrefixes = ['make:', 'list', 'help', 'tinker', 'serve'];
        $isCustom = true;

        foreach ($customPrefixes as $prefix) {
            if (str_starts_with($commandName, $prefix)) {
                $isCustom = false;
                break;
            }
        }

        return $isCustom ? 'custom' : 'default';
    }
}