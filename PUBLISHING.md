# Publishing Guide

This guide will help you publish the Artisan Playground package to Packagist.

## Pre-Publishing Checklist

### ✅ Package Structure

-   [x] All source files are in the `src/` directory
-   [x] Configuration file is in `src/Config/`
-   [x] Views are in `src/Resources/views/`
-   [x] CSS/JS assets are in `src/Resources/css/` and `src/Resources/js/`
-   [x] Migrations are in `src/database/migrations/`
-   [x] Tests are in `tests/`
-   [x] Routes are in `src/routes/`

### ✅ Documentation

-   [x] README.md is complete and professional
-   [x] CHANGELOG.md tracks version changes
-   [x] LICENSE file (MIT) is present
-   [x] CONTRIBUTING.md has contribution guidelines
-   [x] SECURITY.md has security policy
-   [x] CODE_OF_CONDUCT.md has community guidelines
-   [x] INSTALLATION.md has detailed installation guide

### ✅ GitHub Files

-   [x] .gitignore excludes unnecessary files
-   [x] .github/ISSUE_TEMPLATE/ has bug and feature request templates
-   [x] .github/workflows/ has CI/CD pipeline
-   [x] .github/FUNDING.yml has funding configuration
-   [x] package.json for potential frontend tooling

### ✅ Composer Configuration

-   [x] composer.json is valid (`composer validate`)
-   [x] All dependencies are correctly specified
-   [x] Autoload paths are correct
-   [x] Laravel service provider is registered
-   [x] Package metadata is complete (keywords, homepage, support, etc.)

### ✅ Code Quality

-   [x] PSR-12 coding standards followed
-   [x] All tests pass
-   [x] No syntax errors
-   [x] Proper namespacing
-   [x] Security considerations implemented

## Publishing Steps

### 1. Create GitHub Repository

1. Go to [GitHub](https://github.com) and create a new repository
2. Repository name: `artisan-playground`
3. Description: "A beautiful UI for executing Laravel Artisan commands"
4. Make it public
5. Don't initialize with README (we already have one)

### 2. Push Code to GitHub

```bash
# Initialize git repository (if not already done)
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial release v1.0.0"

# Add remote origin
git remote add origin https://github.com/kozhinhikkodan-dev/artisan-playground.git

# Push to GitHub
git push -u origin main
```

### 3. Create GitHub Release

1. Go to your repository on GitHub
2. Click on "Releases" in the right sidebar
3. Click "Create a new release"
4. Tag version: `v1.0.0`
5. Release title: `v1.0.0 - Initial Release`
6. Description: Copy content from CHANGELOG.md
7. Check "This is a pre-release" if needed
8. Click "Publish release"

### 4. Register on Packagist

1. Go to [Packagist](https://packagist.org)
2. Click "Submit Package"
3. Enter your GitHub repository URL: `https://github.com/kozhinhikkodan-dev/artisan-playground`
4. Click "Check"
5. Review the package information
6. Click "Submit"

### 5. Configure Packagist Webhook (Optional)

1. In your GitHub repository, go to Settings > Webhooks
2. Add webhook for Packagist
3. URL: `https://packagist.org/api/github`
4. Content type: `application/json`
5. Select events: "Just the push event"

### 6. Verify Package

1. Check your package on Packagist: `https://packagist.org/packages/kozhinhikkodan-dev/artisan-playground`
2. Verify all information is correct
3. Test installation in a new Laravel project:

```bash
composer require kozhinhikkodan-dev/artisan-playground
```

## Post-Publishing Tasks

### 1. Update Documentation

-   [ ] Update README.md with correct Packagist installation instructions
-   [ ] Add badges for Packagist, GitHub, etc.
-   [ ] Update any hardcoded URLs

### 2. Social Media & Promotion

-   [ ] Share on Twitter/LinkedIn
-   [ ] Post on Laravel News
-   [ ] Share in Laravel communities
-   [ ] Create demo video/screenshots

### 3. Monitor & Maintain

-   [ ] Monitor GitHub issues
-   [ ] Respond to user questions
-   [ ] Plan future releases
-   [ ] Keep dependencies updated

## Version Management

### Semantic Versioning

-   **MAJOR** version for incompatible API changes
-   **MINOR** version for backwards-compatible functionality
-   **PATCH** version for backwards-compatible bug fixes

### Release Process

1. Update CHANGELOG.md
2. Create git tag: `git tag v1.0.1`
3. Push tag: `git push origin v1.0.1`
4. Create GitHub release
5. Packagist will auto-update via webhook

## Troubleshooting

### Common Issues

1. **Package not found on Packagist**: Check repository URL and visibility
2. **Composer validation errors**: Run `composer validate` and fix issues
3. **Missing files**: Ensure all files are committed and pushed
4. **Webhook not working**: Check GitHub webhook settings and Packagist configuration

### Support

If you encounter issues:

1. Check [Packagist documentation](https://packagist.org/about)
2. Review [Composer documentation](https://getcomposer.org/doc/)
3. Contact Packagist support if needed

## Success Metrics

After publishing, track these metrics:

-   [ ] Package downloads on Packagist
-   [ ] GitHub stars and forks
-   [ ] User feedback and issues
-   [ ] Community adoption
-   [ ] Documentation views

---

**Good luck with your package release! 🚀**
