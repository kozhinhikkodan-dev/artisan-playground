<div class="command-details">
    <div class="row">
        <div class="col-md-6">
            <h6 class="text-muted mb-2">Command Information</h6>
            <table class="table table-sm">
                <tr>
                    <td><strong>Command:</strong></td>
                    <td><code>{{ $command->command_name }}</code></td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td>
                        @if($command->exit_code === 0)
                            <span class="badge bg-success">Success</span>
                        @else
                            <span class="badge bg-danger">Failed</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Execution Time:</strong></td>
                    <td>{{ round($command->execution_time, 2) }}s</td>
                </tr>
                <tr>
                    <td><strong>Exit Code:</strong></td>
                    <td>{{ $command->exit_code }}</td>
                </tr>
                <tr>
                    <td><strong>Executed By:</strong></td>
                    <td>{{ $command->user->name ?? 'Custom User' }}</td>
                </tr>
                <tr>
                    <td><strong>Executed At:</strong></td>
                    <td>{{ $command->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                <tr>
                    <td><strong>IP Address:</strong></td>
                    <td>{{ $command->ip_address }}</td>
                </tr>
                @if($command->is_dangerous)
                <tr>
                    <td><strong>Type:</strong></td>
                    <td><span class="badge bg-warning">Dangerous</span></td>
                </tr>
                @endif
            </table>
        </div>
        
        <div class="col-md-6">
            <h6 class="text-muted mb-2">Parameters</h6>
            
            @if(!empty($command->arguments))
            <div class="mb-3">
                <strong>Arguments:</strong>
                <div class="bg-light p-2 rounded">
                    <pre class="mb-0"><code>{{ json_encode($command->arguments, JSON_PRETTY_PRINT) }}</code></pre>
                </div>
            </div>
            @endif
            
            @if(!empty($command->options))
            <div class="mb-3">
                <strong>Options:</strong>
                <div class="bg-light p-2 rounded">
                    <pre class="mb-0"><code>{{ json_encode($command->options, JSON_PRETTY_PRINT) }}</code></pre>
                </div>
            </div>
            @endif
            
            @if(empty($command->arguments) && empty($command->options))
            <p class="text-muted">No parameters were passed to this command.</p>
            @endif
        </div>
    </div>
    
    @if(!empty($command->output))
    <div class="mt-4">
        <h6 class="text-muted mb-2">Output</h6>
        <div class="bg-dark text-light p-3 rounded">
            <pre class="mb-0 text-light"><code>{{ $command->output }}</code></pre>
        </div>
    </div>
    @endif
    
    @if(!empty($command->user_agent))
    <div class="mt-3">
        <h6 class="text-muted mb-2">User Agent</h6>
        <div class="bg-light p-2 rounded">
            <small class="text-muted">{{ $command->user_agent }}</small>
        </div>
    </div>
    @endif
</div> 