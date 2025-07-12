# Contributing to Artisan Playground

Thank you for your interest in contributing to Artisan Playground! This document provides guidelines and information for contributors.

## 🤝 How to Contribute

### Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates. When creating a bug report, include:

-   **Clear and descriptive title**
-   **Detailed description** of the problem
-   **Steps to reproduce** the issue
-   **Expected behavior** vs **actual behavior**
-   **Environment details** (Laravel version, PHP version, OS)
-   **Screenshots** if applicable
-   **Error logs** if available

### Suggesting Enhancements

We welcome feature requests! When suggesting enhancements:

-   **Describe the feature** in detail
-   **Explain the use case** and benefits
-   **Provide examples** of how it would work
-   **Consider implementation** complexity

### Pull Requests

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/amazing-feature`
3. **Make your changes** following the coding standards
4. **Add tests** for new functionality
5. **Update documentation** as needed
6. **Commit your changes**: `git commit -m 'Add amazing feature'`
7. **Push to the branch**: `git push origin feature/amazing-feature`
8. **Create a Pull Request** with a clear description

## 🛠️ Development Setup

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   Laravel 10 or higher
-   Git

### Local Development

1. **Clone the repository**

    ```bash
    git clone https://github.com/kozhinhikkodan-dev/artisan-playground.git
    cd artisan-playground
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Set up testing environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Run migrations**

    ```bash
    php artisan migrate
    ```

5. **Install the package**

    ```bash
    php artisan artisan-playground:install
    ```

6. **Start development server**
    ```bash
    php artisan serve
    ```

### Testing

```bash
# Run all tests
composer test

# Run tests with coverage
composer test -- --coverage

# Run specific test file
./vendor/bin/phpunit tests/Feature/ArtisanPlaygroundTest.php

# Run tests in parallel
./vendor/bin/phpunit --parallel
```

## 📝 Coding Standards

### PHP Standards

-   Follow **PSR-12** coding standards
-   Use **PHP 8.1+** features when appropriate
-   Write **meaningful variable and function names**
-   Add **proper PHPDoc comments** for all public methods
-   Keep **functions small and focused** (max 20-30 lines)
-   Use **type hints** for all parameters and return types

### Laravel Conventions

-   Follow **Laravel naming conventions**
-   Use **Laravel facades** when appropriate
-   Implement **proper error handling**
-   Use **Laravel's validation** for form inputs
-   Follow **Laravel's directory structure**

### JavaScript Standards

-   Use **ES6+** features
-   Follow **consistent naming conventions**
-   Write **modular and reusable code**
-   Add **JSDoc comments** for functions
-   Use **async/await** for asynchronous operations

### CSS/SCSS Standards

-   Use **BEM methodology** for class naming
-   Write **responsive and accessible** styles
-   Use **CSS custom properties** for theming
-   Follow **mobile-first** approach
-   Ensure **cross-browser compatibility**

## 🧪 Testing Guidelines

### Test Structure

-   **Unit tests** for individual classes and methods
-   **Feature tests** for complete user workflows
-   **Integration tests** for external dependencies
-   **Browser tests** for UI interactions

### Test Naming

```php
// Good
public function test_user_can_execute_safe_command()
public function test_dangerous_command_requires_permission()
public function test_command_output_is_displayed_correctly()

// Bad
public function test_execute()
public function test_command()
```

### Test Coverage

-   Aim for **90%+ code coverage**
-   Test **both success and failure scenarios**
-   Test **edge cases and error conditions**
-   Mock **external dependencies**

### Example Test

```php
<?php

namespace SalihKozhinhikkodan\ArtisanPlayground\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandExecutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_execute_safe_command()
    {
        // Arrange
        $user = User::factory()->create();
        $user->givePermissionTo('artisan-playground.execute');

        // Act
        $response = $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'command' => 'list',
                'arguments' => [],
                'options' => []
            ]);

        // Assert
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
```

## 📚 Documentation

### Code Documentation

-   **PHPDoc** for all public methods
-   **Inline comments** for complex logic
-   **README updates** for new features
-   **API documentation** for endpoints

### User Documentation

-   **Installation instructions**
-   **Configuration examples**
-   **Usage tutorials**
-   **Troubleshooting guides**

## 🔄 Pull Request Process

### Before Submitting

1. **Ensure all tests pass**
2. **Update documentation** if needed
3. **Add tests** for new features
4. **Check code style** with PHP CS Fixer
5. **Test manually** in a Laravel application

### Pull Request Template

```markdown
## Description

Brief description of the changes

## Type of Change

-   [ ] Bug fix
-   [ ] New feature
-   [ ] Breaking change
-   [ ] Documentation update

## Testing

-   [ ] Unit tests added/updated
-   [ ] Feature tests added/updated
-   [ ] Manual testing completed

## Checklist

-   [ ] Code follows PSR-12 standards
-   [ ] Self-review completed
-   [ ] Documentation updated
-   [ ] Tests added and passing
```

### Review Process

1. **Automated checks** must pass
2. **Code review** by maintainers
3. **Manual testing** by maintainers
4. **Documentation review**
5. **Final approval** and merge

## 🐛 Bug Fixes

### Bug Fix Guidelines

-   **Reproduce the bug** consistently
-   **Write a failing test** that demonstrates the bug
-   **Fix the bug** with minimal code changes
-   **Ensure the test passes**
-   **Add regression tests** if needed

### Bug Report Template

```markdown
## Bug Description

Clear description of the bug

## Steps to Reproduce

1. Step 1
2. Step 2
3. Step 3

## Expected Behavior

What should happen

## Actual Behavior

What actually happens

## Environment

-   Laravel Version: X.X.X
-   PHP Version: X.X.X
-   OS: X.X.X
-   Package Version: X.X.X

## Additional Information

Screenshots, logs, etc.
```

## 🚀 Release Process

### Versioning

We follow **Semantic Versioning** (SemVer):

-   **MAJOR**: Breaking changes
-   **MINOR**: New features (backward compatible)
-   **PATCH**: Bug fixes (backward compatible)

### Release Checklist

-   [ ] **Update version** in composer.json
-   [ ] **Update changelog** with new features/fixes
-   [ ] **Run all tests** and ensure they pass
-   [ ] **Update documentation** if needed
-   [ ] **Create release tag** on GitHub
-   [ ] **Publish to Packagist** (if applicable)

## 📞 Getting Help

### Communication Channels

-   **GitHub Issues**: For bugs and feature requests
-   **GitHub Discussions**: For questions and discussions
-   **Email**: For private or sensitive matters

### Code of Conduct

-   **Be respectful** and inclusive
-   **Help others** learn and grow
-   **Provide constructive feedback**
-   **Follow community guidelines**

## 🙏 Recognition

Contributors will be recognized in:

-   **README.md** contributors section
-   **Release notes** for significant contributions
-   **GitHub contributors** page

Thank you for contributing to Artisan Playground! 🎉
