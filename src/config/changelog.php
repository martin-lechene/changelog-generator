<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Changelog Storage Path
    |--------------------------------------------------------------------------
    |
    | This value determines the path where changelog files will be stored.
    | By default, they will be stored in the storage/app/changelogs directory.
    |
    */
    'storage_path' => storage_path('app/changelogs'),

    /*
    |--------------------------------------------------------------------------
    | File Format
    |--------------------------------------------------------------------------
    |
    | This value determines the format of the changelog files.
    | Supported: "json", "markdown"
    |
    */
    'format' => 'markdown',

    /*
    |--------------------------------------------------------------------------
    | Markdown File Path
    |--------------------------------------------------------------------------
    |
    | The path where the CHANGELOG.md file will be stored.
    | This should be relative to your project root.
    |
    */
    'markdown_path' => 'CHANGELOG.md',

    /*
    |--------------------------------------------------------------------------
    | Git Configuration
    |--------------------------------------------------------------------------
    |
    | Configure Git settings for automatic commits and pushes.
    |
    */
    'git' => [
        'enabled' => true,
        'auto_commit' => true,
        'auto_push' => true,
        'commit_message' => 'docs: update changelog for version {version}',
        'remote' => 'origin',
        'branch' => 'main',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the route prefix and middleware for the changelog generator.
    |
    */
    'route' => [
        'prefix' => 'admin/actions',
        'middleware' => ['web', 'auth'],
    ],
]; 