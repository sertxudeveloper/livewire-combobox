<?php

namespace SertxuDeveloper\LivewireCombobox\Tests;

use Livewire\Livewire;
use SertxuDeveloper\LivewireCombobox\Tests\Components\DontKeepSelectionCombobox;
use SertxuDeveloper\LivewireCombobox\Tests\Database\Seeders\UserSeeder;

class DontKeepSelectionComboboxTest extends TestCase
{
    public function test_resets_properties_when_keep_selection_is_false(): void {
        $this->seed(UserSeeder::class);

        $component = Livewire::test(DontKeepSelectionCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ])->set('search', 'User');

        $component->assertSuccessful()
            ->assertSee('Users')
            ->assertSee('Select a user')
            ->assertSee('User A')
            ->assertSee('User B')
            ->assertSee('User C')
            ->assertDontSee('Other')
            ->assertNotEmitted('selected-users')
            ->assertNotEmitted('cleared-users');

        $component->call('select', 1)
            ->assertEmittedUp('selected-users')
            ->assertNotEmitted('cleared-users')
            ->assertSet('selected', null);
    }
}
