# Artisan Playground

A beautiful, secure, and feature-rich UI for executing Laravel Artisan commands with role-based access control, theme support, and comprehensive command management.

![Artisan Playground](https://img.shields.io/badge/Laravel-10%2B-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue?style=for-the-badge&logo=php)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
[![GitHub Stars](https://img.shields.io/github/stars/kozhinhikkodan-dev/artisan-playground?style=for-the-badge&logo=github)](https://github.com/kozhinhikkodan-dev/artisan-playground/stargazers)
[![Packagist Downloads](https://img.shields.io/packagist/dt/kozhinhikkodan-dev/artisan-playground?style=for-the-badge&logo=packagist)](https://packagist.org/packages/kozhinhikkodan-dev/artisan-playground)
[![Packagist Stars](https://img.shields.io/packagist/stars/kozhinhikkodan-dev/artisan-playground?style=for-the-badge&logo=packagist)](https://packagist.org/packages/kozhinhikkodan-dev/artisan-playground)
[![Latest Version](https://img.shields.io/packagist/v/kozhinhikkodan-dev/artisan-playground?style=for-the-badge)](https://packagist.org/packages/kozhinhikkodan-dev/artisan-playground)


## ✨ Features

- 🎨 **Beautiful Bootstrap-based UI** with light and dark themes
- 🔐 **Role-based access control** with Spatie Laravel Permission
- 🌐 **IP-based restrictions** for enhanced security
- 👤 **Custom login credentials** or standard Laravel authentication
- 📊 **Command grouping** (Default, Custom, Dangerous, Database, Cache)
- ⚡ **Real-time command execution** with live output
- 📝 **Command history** with detailed logging
- 🚨 **Dangerous command warnings** and confirmation
- 🔍 **Command search** and filtering
- 📱 **Responsive design** for all devices
- 🎯 **Parameter validation** for all command arguments and options
- 📈 **Execution statistics** and performance metrics

## 🚀 Installation

### Requirements

- **PHP**: 8.2 or higher
- **Laravel**: 10.x, 11.x, 12.x, or higher
- **Spatie Laravel Permission**: 5.x or 6.x

### 1. Install the Package

```bash
composer require kozhinhikkodan-dev/artisan-playground
```

### 2. Publish Assets and Configuration

```bash
php artisan vendor:publish --tag=artisan-playground
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

## ⚙️ Configuration

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

### Command Groups

Commands are automatically grouped into categories:

- **Default**: Standard Laravel commands
- **Custom**: Your application's custom commands
- **Dangerous**: Commands that can affect system stability
- **Database**: Database-related commands
- **Cache**: Cache management commands

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

### UI Settings

```php
'ui' => [
    'theme' => [
        'default' => 'light', // light, dark, auto
        'allow_switch' => true,
    ],
    'layout' => [
        'sidebar_position' => 'left',
        'sidebar_collapsible' => true,
        'show_command_history' => true,
        'max_history_items' => 50,
    ],
],
```

## 🔐 Security

### Role-Based Access Control

The package creates three default roles:

1. **artisan-playground-super-admin**: Full access to all features
2. **artisan-playground-admin**: Can execute dangerous commands and manage history
3. **artisan-playground-user**: Can execute safe commands only

### Permissions

- `artisan-playground.view`: View the dashboard
- `artisan-playground.execute`: Execute commands
- `artisan-playground.execute-dangerous`: Execute dangerous commands
- `artisan-playground.delete`: Delete command history
- `artisan-playground.restore`: Restore deleted commands
- `artisan-playground.force-delete`: Permanently delete commands

### IP Restrictions

Configure allowed IP addresses in the configuration:

```php
'allowed_ips' => [
    '127.0.0.1',           // Single IP
    '192.168.1.*',         // Wildcard pattern
    '10.0.0.0/24',         // CIDR notation
    '*',                    // Allow all IPs
],
```

## 🎨 Usage

### Accessing the Interface

Visit `/artisan-playground` in your browser after installation.

### Executing Commands

1. **Browse Commands**: Navigate through command groups in the sidebar
2. **Select Command**: Click on any command to view its details
3. **Configure Parameters**: Fill in required arguments and optional parameters
4. **Execute**: Click "Execute Command" to run the command
5. **View Output**: See real-time output and execution time

### Command History

- View all executed commands with details
- Filter by command name, user, status, or type
- Re-execute commands with the same parameters
- View full command output in modals

### Theme Switching

Click the theme toggle button in the top-right corner to switch between light and dark themes.

## 🔧 Customization

### Adding Custom Command Groups

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

### Customizing Dangerous Commands

```php
'dangerous_commands' => [
    // Add your custom dangerous commands
    'my-app:reset-data',
    'my-app:clear-cache',
],
```

### Custom Styling

Override the default styles by publishing the assets and modifying:

- `public/vendor/artisan-playground/css/app.css`
- `public/vendor/artisan-playground/js/app.js`

## 📊 API Endpoints

The package provides several API endpoints:

- `GET /artisan-playground` - Dashboard
- `GET /artisan-playground/command/{name}` - Command details
- `POST /artisan-playground/execute` - Execute command
- `GET /artisan-playground/history` - Command history
- `GET /artisan-playground/login` - Login page
- `POST /artisan-playground/login` - Authenticate
- `POST /artisan-playground/logout` - Logout

## 🧪 Testing

```bash
# Run the package tests
composer test

# Run with coverage
composer test -- --coverage
```

## 🤝 Contributing

We welcome contributions! Please follow these steps:

### 1. Fork the Repository

Fork the repository on GitHub.

### 2. Create a Feature Branch

```bash
git checkout -b feature/amazing-feature
```

### 3. Make Your Changes

- Follow PSR-12 coding standards
- Add tests for new features
- Update documentation as needed
- Ensure all tests pass

### 4. Commit Your Changes

```bash
git commit -m 'Add amazing feature'
```

### 5. Push to the Branch

```bash
git push origin feature/amazing-feature
```

### 6. Create a Pull Request

Submit a pull request with a clear description of your changes.

### Development Setup

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure
4. Run migrations: `php artisan migrate`
5. Install the package: `php artisan artisan-playground:install`

### Code Style

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add proper PHPDoc comments
- Keep functions small and focused

### Testing Guidelines

- Write unit tests for all new features
- Ensure test coverage is maintained
- Test both success and failure scenarios
- Mock external dependencies

## 📝 Changelog

### v1.0.0

- Initial release
- Bootstrap-based UI with theme support
- Role-based access control
- Command execution and history
- IP-based restrictions
- Custom authentication support

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - The PHP framework
- [Bootstrap](https://getbootstrap.com/) - CSS framework
- [Font Awesome](https://fontawesome.com/) - Icons
- [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) - Permission management

## 📞 Support

- **GitHub Issues**: [Report bugs or request features](https://github.com/kozhinhikkodan-dev/artisan-playground/issues)
- **Documentation**: [Full documentation](https://github.com/kozhinhikkodan-dev/artisan-playground#readme)
- **Buy me a coffee**: [Support the project](https://www.buymeacoffee.com/salihkozhinhikkodan)

## ⭐ Star the Repository

If you find this package useful, please consider starring the repository on GitHub!

---

**Made with ❤️ by Salih Kozhinhikkodan**
