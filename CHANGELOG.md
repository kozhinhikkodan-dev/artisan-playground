# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-01

### Added

- Initial release of Artisan Playground
- Beautiful Bootstrap-based UI with light and dark themes
- Role-based access control with Spatie Laravel Permission
- IP-based restrictions for enhanced security
- Custom login credentials or standard Laravel authentication
- Command grouping (Default, Custom, Dangerous, Database, Cache)
- Real-time command execution with live output
- Command history with detailed logging
- Dangerous command warnings and confirmation
- Command search and filtering functionality
- Responsive design for all devices
- Parameter validation for all command arguments and options
- Execution statistics and performance metrics
- Theme switching (light/dark mode)
- Command output preview and full output modal
- Pagination for command history
- Auto-submitting filters
- Common CSS architecture for consistent styling
- Asset publishing system
- Comprehensive documentation and examples

### Features

- **Dashboard**: Overview with statistics and recent commands
- **Command Execution**: Full parameter support with validation
- **History Management**: View, filter, and manage executed commands
- **Security**: Role-based permissions and IP restrictions
- **UI/UX**: Modern, responsive design with theme support
- **Customization**: Configurable command groups and dangerous commands

### Technical

- Laravel 10, 11, and 12 support
- PHP 8.1+ compatibility
- PSR-12 coding standards
- Comprehensive test coverage
- MIT license
- Packagist ready

---

## [1.1.0] - 2024-12-19

### Added

- **Full Laravel 12 compatibility** with seamless version support
- **Enhanced validation** using Laravel's improved validation system
- **PHP 8.2+ requirement** for better performance and features
- **Improved type safety** with better type hints and casting
- **Enhanced CIDR IP validation** with proper type casting

### Changed

- Updated PHP requirement from 8.1+ to 8.2+
- Enhanced validation handling in controllers
- Updated array destructuring syntax for better readability
- Simplified installation process

### Technical

- Laravel 10, 11, 12, and higher support
- PHP 8.2+ compatibility
- Improved type safety throughout the codebase
- Better error handling and validation

---

## [Unreleased]

### Planned

- API endpoints for external integrations
- Webhook support for command execution
- Advanced command scheduling
- Export functionality for command history
- Custom command templates
- Multi-language support
- Advanced analytics and reporting
