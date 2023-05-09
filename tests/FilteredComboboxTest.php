<?php

namespace SertxuDeveloper\LivewireCombobox\Tests;

use Livewire\Livewire;
use SertxuDeveloper\LivewireCombobox\Tests\Components\FilteredCombobox;
use SertxuDeveloper\LivewireCombobox\Tests\Models\User;

class FilteredComboboxTest extends TestCase
{
    public function test_can_apply_filters(): void {
        User::factory()->create(['name' => 'John Doe', 'email' => 'john.doe@example.com']);
        User::factory()->create(['name' => 'Jane Doe', 'email' => 'jane.doe@example.com']);
        User::factory()->create(['name' => 'John Smith', 'email' => 'john.smith@example.net']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane.smith@example.com']);

        Livewire::test(FilteredCombobox::class)
            ->assertSuccessful()
            ->assertSet('search', '')
            ->assertSet('selected', null)

            ->set('search', 'John')
            ->assertSet('selected', null)
            ->assertSee('John Doe')
            ->assertDontSee('John Smith')
            ->assertDontSee('Jane Doe')
            ->assertDontSee('Jane Smith')

            ->set('search', 'Jane')
            ->assertSet('selected', null)
            ->assertSee('Jane Doe')
            ->assertSee('Jane Smith')
            ->assertDontSee('John Doe')
            ->assertDontSee('John Smith');
    }
}
