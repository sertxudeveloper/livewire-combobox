<?php

namespace SertxuDeveloper\LivewireCombobox\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\LivewireCombobox\ComboboxServiceProvider;

class TestCase extends Orchestra {

    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array {
        return [
            ComboboxServiceProvider::class,
        ];
    }
}
