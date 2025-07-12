<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtisanCommand extends Model
{
    use HasFactory;

    protected $fillable = [
        'command_name',
        'arguments',
        'options',
        'output',
        'exit_code',
        'execution_time',
        'executed_by',
        'ip_address',
        'user_agent',
        'is_dangerous',
        'command_group',
    ];

    protected $casts = [
        'arguments' => 'array',
        'options' => 'array',
        'is_dangerous' => 'boolean',
        'execution_time' => 'float',
        'exit_code' => 'integer',
    ];

    /**
     * Get the user who executed the command.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'),'executed_by');
    }

    /**
     * Scope for dangerous commands.
     */
    public function scopeDangerous($query)
    {
        return $query->where('is_dangerous', true);
    }

    /**
     * Scope for safe commands.
     */
    public function scopeSafe($query)
    {
        return $query->where('is_dangerous', false);
    }

    /**
     * Scope for commands by group.
     */
    public function scopeByGroup($query, $group)
    {
        return $query->where('command_group', $group);
    }
}