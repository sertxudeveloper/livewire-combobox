<?php

namespace SertxuDeveloper\LivewireCombobox\Tests;

use Illuminate\Foundation\Application;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\LivewireCombobox\ComboboxServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Define database migrations.
     */
    protected function defineDatabaseMigrations(): void {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array {
        return [
            LivewireServiceProvider::class,
            ComboboxServiceProvider::class,
        ];
    }
}
