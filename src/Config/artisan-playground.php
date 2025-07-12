<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Artisan Playground Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all the configuration options for the Artisan Playground
    | package. You can customize these settings according to your needs.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Authentication Settings
    |--------------------------------------------------------------------------
    |
    | Configure authentication settings for the Artisan Playground.
    |
    */
    'auth' => [
        'enabled' => true,
        'guard' => 'web',
        'custom_credentials' => [
            'enabled' => false,
            'username' => env('ARTISAN_PLAYGROUND_USERNAME', 'admin'),
            'password' => env('ARTISAN_PLAYGROUND_PASSWORD', 'password'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Access Control
    |--------------------------------------------------------------------------
    |
    | Configure who can access the Artisan Playground.
    |
    */
    'access_control' => [
        'allowed_roles' => [
            'artisan-playground-super-admin',
            'artisan-playground-admin',
            'artisan-playground-user',
        ],
        'required_permissions' => [
            'artisan-playground.view',
        ],
        'allowed_users' => [
            // Add specific user IDs here
        ],
        'allowed_ips' => [
            // Add allowed IP addresses here
            // Examples: '127.0.0.1', '192.168.1.*', '10.0.0.0/24'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Command Groups
    |--------------------------------------------------------------------------
    |
    | Define how commands are grouped in the interface.
    |
    */
    'command_groups' => [
        'default' => [
            'name' => 'Default Commands',
            'description' => 'Standard Laravel Artisan commands',
            'icon' => 'fas fa-cog',
            'color' => 'primary',
        ],
        'custom' => [
            'name' => 'Custom Commands',
            'description' => 'Your application\'s custom commands',
            'icon' => 'fas fa-code',
            'color' => 'success',
        ],
        'dangerous' => [
            'name' => 'Dangerous Commands',
            'description' => 'Commands that can affect system stability',
            'icon' => 'fas fa-exclamation-triangle',
            'color' => 'danger',
        ],
        'database' => [
            'name' => 'Database Commands',
            'description' => 'Database-related commands',
            'icon' => 'fas fa-database',
            'color' => 'info',
        ],
        'cache' => [
            'name' => 'Cache Commands',
            'description' => 'Cache management commands',
            'icon' => 'fas fa-bolt',
            'color' => 'warning',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dangerous Commands
    |--------------------------------------------------------------------------
    |
    | List of commands that are considered dangerous and require special permission.
    |
    */
    'dangerous_commands' => [
        'migrate:fresh',
        'migrate:reset',
        'db:wipe',
        'config:clear',
        'cache:clear',
        'view:clear',
        'route:clear',
        'optimize:clear',
        'queue:restart',
        'queue:flush',
        'schedule:clear-cache',
        'telescope:clear',
        'horizon:clear',
        'backup:clean',
        'backup:delete',
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    |
    | Configure the user interface appearance and behavior.
    |
    */
    'ui' => [
        'theme' => [
            'default' => 'light', // light, dark, auto
            'allow_switch' => true,
        ],
        'layout' => [
            'sidebar_position' => 'left', // left, right
            'sidebar_collapsible' => true,
            'show_command_history' => true,
            'max_history_items' => 50,
        ],
        'features' => [
            'command_search' => true,
            'command_favorites' => true,
            'command_groups' => true,
            'output_formatting' => true,
            'execution_time_display' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Execution Settings
    |--------------------------------------------------------------------------
    |
    | Configure command execution behavior.
    |
    */
    'execution' => [
        'timeout' => 300, // seconds
        'max_output_length' => 10000, // characters
        'save_history' => true,
        'log_executions' => true,
        'confirm_dangerous_commands' => true,
        'allow_background_execution' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Links
    |--------------------------------------------------------------------------
    |
    | External links displayed in the interface.
    |
    */
    'links' => [
        'github' => [
            'enabled' => true,
            'url' => 'https://github.com/kozhinhikkodan-dev/artisan-playground',
            'text' => 'GitHub',
            'icon' => 'fab fa-github',
        ],
        'buy_me_coffee' => [
            'enabled' => true,
            'url' => 'https://www.buymeacoffee.com/salihkozhinhikkodan',
            'text' => 'Buy me a coffee',
            'icon' => 'fas fa-coffee',
        ],
        'documentation' => [
            'enabled' => true,
            'url' => 'https://github.com/kozhinhikkodan-dev/artisan-playground#readme',
            'text' => 'Documentation',
            'icon' => 'fas fa-book',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Settings
    |--------------------------------------------------------------------------
    |
    | Configure the routes for the Artisan Playground.
    |
    */
    'routes' => [
        'prefix' => 'artisan-playground',
        'middleware' => ['web', 'artisan-playground'],
        'namespace' => 'KozhinhikkodanDev\\ArtisanPlayground\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Settings
    |--------------------------------------------------------------------------
    |
    | Configure database-related settings.
    |
    */
    'database' => [
        'table_name' => 'artisan_commands',
        'connection' => null, // Use default connection if null
    ],
];