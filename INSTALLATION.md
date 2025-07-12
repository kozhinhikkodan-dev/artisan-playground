# Installation Guide

This guide will help you install and configure Artisan Playground in your Laravel application.

## Prerequisites

-   PHP 8.1 or higher
-   Laravel 10 or 11
-   Composer
-   Spatie Laravel Permission package (will be installed automatically)

## Quick Installation

### 1. Install the Package

```bash
composer require kozhinhikkodan-dev/artisan-playground
```

### 2. Publish Configuration and Assets

```bash
# Publish configuration and views
php artisan vendor:publish --tag=artisan-playground

# Publish assets (CSS/JS)
php artisan vendor:publish --tag=artisan-playground-assets
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Install Permissions and Roles

```bash
php artisan artisan-playground:install
```

### 5. Configure Access Control

Edit the published configuration file at `config/artisan-playground.php`:

```php
'access_control' => [
    'allowed_roles' => [
        'artisan-playground-super-admin',
        'artisan-playground-admin',
        'artisan-playground-user',
    ],
    'required_permissions' => [
        'artisan-playground.view',
    ],
    'allowed_ips' => [
        '127.0.0.1',
        '192.168.1.*',
        '10.0.0.0/24',
    ],
],
```

### 6. Access the Interface

Visit `/artisan-playground` in your browser.

## Detailed Configuration

### Authentication Settings

```php
'auth' => [
    'enabled' => true,
    'guard' => 'web',
    'custom_credentials' => [
        'enabled' => false,
        'username' => env('ARTISAN_PLAYGROUND_USERNAME', 'admin'),
        'password' => env('ARTISAN_PLAYGROUND_PASSWORD', 'password'),
    ],
],
```

### Custom Login Credentials

If you want to use custom login credentials instead of your Laravel users:

1. Set `custom_credentials.enabled` to `true`
2. Add environment variables to your `.env` file:

```env
ARTISAN_PLAYGROUND_USERNAME=admin
ARTISAN_PLAYGROUND_PASSWORD=your-secure-password
```

### IP Restrictions

Configure allowed IP addresses:

```php
'allowed_ips' => [
    '127.0.0.1',           // Single IP
    '192.168.1.*',         // Wildcard pattern
    '10.0.0.0/24',         // CIDR notation
    '*',                    // Allow all IPs
],
```

### Command Groups

Commands are automatically grouped into categories:

-   **Default**: Standard Laravel commands
-   **Custom**: Your application's custom commands
-   **Dangerous**: Commands that can affect system stability
-   **Database**: Database-related commands
-   **Cache**: Cache management commands

### Dangerous Commands

Configure which commands are considered dangerous:

```php
'dangerous_commands' => [
    'migrate:fresh',
    'migrate:reset',
    'db:wipe',
    'config:clear',
    'cache:clear',
    // Add more as needed
],
```

## User Roles and Permissions

The package creates three default roles:

1. **artisan-playground-super-admin**: Full access to all features
2. **artisan-playground-admin**: Can execute dangerous commands and manage history
3. **artisan-playground-user**: Can execute safe commands only

### Assigning Roles to Users

```php
// In your User model or a seeder
$user = User::find(1);
$user->assignRole('artisan-playground-admin');
```

### Available Permissions

-   `artisan-playground.view`: View the dashboard
-   `artisan-playground.execute`: Execute commands
-   `artisan-playground.execute-dangerous`: Execute dangerous commands
-   `artisan-playground.delete`: Delete command history
-   `artisan-playground.restore`: Restore deleted commands
-   `artisan-playground.force-delete`: Permanently delete commands

## Customization

### Custom Command Groups

```php
'command_groups' => [
    'my-custom-group' => [
        'name' => 'My Custom Commands',
        'description' => 'Custom application commands',
        'icon' => 'fas fa-star',
        'color' => 'warning',
    ],
],
```

### Custom Styling

Override the default styles by modifying:

-   `public/vendor/artisan-playground/css/app.css`
-   `public/vendor/artisan-playground/js/app.js`

### Custom Routes

You can customize the route prefix in the configuration:

```php
'route_prefix' => 'artisan-playground',
```

## Troubleshooting

### Common Issues

1. **Permission Denied**: Make sure your user has the required roles and permissions
2. **IP Not Allowed**: Check your IP restrictions in the configuration
3. **Commands Not Showing**: Ensure the user has the `artisan-playground.view` permission
4. **Assets Not Loading**: Run `php artisan vendor:publish --tag=artisan-playground-assets`

### Debug Mode

Enable debug mode in your `.env` file:

```env
APP_DEBUG=true
```

### Logs

Check Laravel logs for any errors:

```bash
tail -f storage/logs/laravel.log
```

## Security Considerations

1. **IP Restrictions**: Always configure IP restrictions for production
2. **Strong Passwords**: Use strong passwords for custom credentials
3. **Role Assignment**: Only assign roles to trusted users
4. **HTTPS**: Use HTTPS in production
5. **Regular Updates**: Keep the package updated

## Support

If you encounter any issues:

1. Check the [GitHub Issues](https://github.com/kozhinhikkodan-dev/artisan-playground/issues)
2. Review the [Documentation](https://github.com/kozhinhikkodan-dev/artisan-playground#readme)
3. Contact support at salih@kozhinhikkodan.dev
