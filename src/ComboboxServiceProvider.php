<?php

namespace SertxuDeveloper\LivewireCombobox;

use Illuminate\Support\ServiceProvider;

class ComboboxServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void {
        $this->registerPublishables();

        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'livewire-combobox');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        //
    }

    /**
     * Register the publishable resources.
     *
     * @return void
     */
    protected function registerPublishables(): void {
        $this->publishes([
            dirname(__DIR__) . '/resources/views' => resource_path('views/vendor/livewire-combobox'),
        ]);
    }
}
