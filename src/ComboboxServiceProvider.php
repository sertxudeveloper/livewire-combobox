<?php

namespace SertxuDeveloper\LivewireCombobox;

use Illuminate\Support\ServiceProvider;
use SertxuDeveloper\LivewireCombobox\Console\ComboboxMakeCommand;

class ComboboxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void {
        $this->registerPublishables();

        $this->loadViewsFrom(dirname(__DIR__).'/resources/views', 'livewire-combobox');
    }

    /**
     * Register any application services.
     */
    public function register(): void {
        $this->registerCommands();
    }

    /**
     * Register the package commands.
     */
    protected function registerCommands(): void {
        $this->app->bind('command.combobox:make', ComboboxMakeCommand::class);

        $this->commands([
            ComboboxMakeCommand::class,
        ]);
    }

    /**
     * Register the publishable resources.
     */
    protected function registerPublishables(): void {
        $this->publishes([
            dirname(__DIR__).'/resources/views' => resource_path('views/vendor/livewire-combobox'),
        ]);
    }
}
