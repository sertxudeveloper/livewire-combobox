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
        //
    }
}
