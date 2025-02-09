# Laravel Changelog Generator

A Laravel package to create and manage changelogs via a beautiful and dynamic interface.

## Features

- Modern UI with Tailwind CSS
- Livewire-powered dynamic interface
- Multi-language support (English and French)
- Version validation
- Markdown and JSON file storage
- Automatic Git integration (commit and push)
- Easy integration with Laravel 11
- Jetstream compatible

## Requirements

- PHP 8.2 or higher
- Laravel 11.x
- Livewire 3.x
- Git (for automatic commits and pushes)

## Installation

1. Add the repository to your `composer.json`:

```json
"repositories": [
    {
        "type": "path",
        "url": "packages/doganddev/changelog-generator"
    }
]
```

2. Install the package:

```bash
composer require doganddev/changelog-generator
```

3. Publish the configuration and assets:

```bash
php artisan vendor:publish --provider="DogAndDev\ChangelogGenerator\ChangelogGeneratorServiceProvider"
```

## Usage

1. Access the changelog generator at `/admin/actions/create-changelog`
2. Fill in the version (format: X.X.X)
3. Select the release date
4. Add your changes in the appropriate sections:
   - Added Features
   - Changed Features
   - Fixed Issues
5. Submit the form to generate the changelog

The changelog will be stored as both:

- A JSON file in `storage/app/changelogs/`
- A Markdown file (CHANGELOG.md) in your project root

## Configuration

You can customize the package behavior in `config/changelog-generator.php`:

- Storage path for changelog files
- File format (supports both JSON and Markdown)
- Markdown file path
- Git configuration:
  - Enable/disable Git integration
  - Auto-commit changes
  - Auto-push changes
  - Customize commit message
  - Configure remote and branch
- Route configuration (prefix and middleware)

### Git Integration

The package can automatically commit and push your changelog changes. Configure Git settings in `config/changelog-generator.php`:

```php
'git' => [
    'enabled' => true,
    'auto_commit' => true,
    'auto_push' => true,
    'commit_message' => 'docs: update changelog for version {version}',
    'remote' => 'origin',
    'branch' => 'main',
],
```

## Translations

The package comes with English and French translations. You can add more languages by creating new files in the `resources/lang/vendor/changelog-generator` directory.

## Security

The changelog generator routes are protected by the `auth` middleware by default. Make sure to configure your authentication as needed.

## License

This package is open-sourced software licensed under the MIT license.
