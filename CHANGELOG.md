# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-01

### Added

-   Initial release of Artisan Playground
-   Beautiful Bootstrap-based UI with light and dark themes
-   Role-based access control with Spatie Laravel Permission
-   IP-based restrictions for enhanced security
-   Custom login credentials or standard Laravel authentication
-   Command grouping (Default, Custom, Dangerous, Database, Cache)
-   Real-time command execution with live output
-   Command history with detailed logging
-   Dangerous command warnings and confirmation
-   Command search and filtering functionality
-   Responsive design for all devices
-   Parameter validation for all command arguments and options
-   Execution statistics and performance metrics
-   Theme switching (light/dark mode)
-   Command output preview and full output modal
-   Pagination for command history
-   Auto-submitting filters
-   Common CSS architecture for consistent styling
-   Asset publishing system
-   Comprehensive documentation and examples

### Features

-   **Dashboard**: Overview with statistics and recent commands
-   **Command Execution**: Full parameter support with validation
-   **History Management**: View, filter, and manage executed commands
-   **Security**: Role-based permissions and IP restrictions
-   **UI/UX**: Modern, responsive design with theme support
-   **Customization**: Configurable command groups and dangerous commands

### Technical

-   Laravel 10 and 11 support
-   PHP 8.1+ compatibility
-   PSR-12 coding standards
-   Comprehensive test coverage
-   MIT license
-   Packagist ready

---

## [1.0.1] - 2024-12-19

### Fixed

-   **Authentication Issues**: Fixed custom credentials authentication not working properly
-   **Login Form**: Dynamic form labels (Username/Email) based on authentication type
-   **Session Management**: Proper handling of custom user sessions
-   **Middleware**: Updated to support both standard Laravel auth and custom credentials
-   **Command History**: Fixed user tracking for custom authentication sessions
-   **Search Functionality**: Fixed search clear button alignment and functionality
-   **UI Improvements**: Enhanced search bar with Cmd+K/Ctrl+K shortcuts
-   **Login Header**: Fixed logo and text visibility issues in login page
-   **Password Toggle**: Added proper styling and background for password visibility toggle
-   **View Details**: Fixed 404 error when viewing command execution details
-   **Route Conflicts**: Resolved route conflicts between command details and command execution

### Enhanced

-   **Search Experience**: Improved search with smooth animations and better visual feedback
-   **Login UX**: Better form validation and error handling for custom credentials
-   **Responsive Design**: Enhanced mobile responsiveness for all components
-   **Theme Support**: Better dark/light theme compatibility across all views

### Technical

-   **Code Quality**: Improved error handling and validation
-   **Performance**: Optimized asset loading and caching
-   **Security**: Enhanced session management for custom authentication

---

## [1.0.2] - 2024-12-19

### Fixed

-   **Asset Loading**: Fixed CSS and JavaScript not loading correctly in fresh Laravel installations
-   **Development Server**: Resolved asset serving issues with `php artisan serve`
-   **Fresh Install**: Package now works out of the box without requiring asset publishing
-   **Asset Routes**: Added internal asset serving routes for seamless development experience

### Enhanced

-   **Zero Configuration**: Fresh installs work immediately without any additional setup
-   **Asset Management**: Assets are automatically served from package internals
-   **Customization**: Publishing assets is only required for customization, not for basic functionality
-   **Developer Experience**: Improved development workflow with automatic asset serving

### Technical

-   **Service Provider**: Added asset route registration for CSS and JS files
-   **Route Management**: Internal asset routes ensure compatibility across all environments
-   **Performance**: Optimized asset serving with proper MIME types and caching headers

---

## [Unreleased]

### Planned

-   API endpoints for external integrations
-   Webhook support for command execution
-   Advanced command scheduling
-   Export functionality for command history
-   Custom command templates
-   Multi-language support
-   Advanced analytics and reporting
