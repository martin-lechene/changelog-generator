<?php

namespace DogAndDev\ChangelogGenerator;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use DogAndDev\ChangelogGenerator\Services\ChangelogService;

class ChangelogGeneratorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'changelog-generator');
        $this->loadTranslationsFrom(__DIR__.'/Resources/lang', 'changelog-generator');
        
        $this->publishes([
            __DIR__.'/Resources/views' => resource_path('views/vendor/changelog-generator'),
            __DIR__.'/Resources/lang' => resource_path('lang/vendor/changelog-generator'),
            __DIR__.'/config/changelog.php' => config_path('changelog-generator.php'),
        ], 'changelog-generator');

        $this->loadLivewireComponents();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/changelog.php',
            'changelog-generator'
        );

        $this->app->singleton(ChangelogService::class, function ($app) {
            return new ChangelogService();
        });
    }

    private function loadLivewireComponents(): void
    {
        Livewire::component('changelog-generator.create-changelog', Http\Livewire\CreateChangelog::class);
    }
} 