<?php

namespace SertxuDeveloper\LivewireCombobox\Tests;

use Livewire\Livewire;
use SertxuDeveloper\LivewireCombobox\Tests\Components\BasicCombobox;
use SertxuDeveloper\LivewireCombobox\Tests\Database\Seeders\UserSeeder;
use SertxuDeveloper\LivewireCombobox\Tests\Models\User;

class BasicComboboxTest extends TestCase
{
    /**
     * Check if the component is rendered correctly.
     */
    public function test_the_component_can_render(): void
    {
        $this->seed(UserSeeder::class);

        $component = Livewire::test(BasicCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ]);

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');

        $component->assertNotEmitted('selected-users');
        $component->assertNotEmitted('cleared-users');
    }

    /**
     * Check if the component is rendered the available options correctly.
     */
    public function test_the_component_can_render_available_results(): void
    {
        $this->seed(UserSeeder::class);

        $component = Livewire::test(BasicCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ])->set('search', 'User');

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertSee('User A');
        $component->assertSee('User B');
        $component->assertSee('User C');
        $component->assertDontSee('Other');

        $component->assertNotEmitted('selected-users');
        $component->assertNotEmitted('cleared-users');
    }

    /**
     * Check if the component can select automatically the only option.
     */
    public function test_the_component_can_select_automatically_the_only_option(): void
    {
        $this->seed(UserSeeder::class);

        $component = Livewire::test(BasicCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ])->set('search', 'Other');

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertDontSee('User A');
        $component->assertDontSee('User B');
        $component->assertDontSee('User C');
        $component->assertSee('Other');

        $component->assertEmittedUp('selected-users');
        $component->assertNotEmitted('cleared-users');
    }

    /**
     * Check an option can be selected.
     */
    public function test_an_option_can_be_selected(): void
    {
        $this->seed(UserSeeder::class);
        $user = User::query()->where('email', 'user_a@example.com')->first();

        $component = Livewire::test(BasicCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ])
            ->set('search', 'User')
            ->call('select', $user->getKey());

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertSee('User A');
        $component->assertDontSee('User B');
        $component->assertDontSee('User C');
        $component->assertDontSee('Other');

        $component->assertEmittedUp('selected-users');
        $component->assertNotEmitted('cleared-users');
    }

    /**
     * Check the selected option is cleared when the search has changed.
     */
    public function test_the_selected_option_is_cleared_when_the_search_has_changed(): void
    {
        $this->seed(UserSeeder::class);
        $user = User::query()->where('email', 'user_a@example.com')->first();

        $component = Livewire::test(BasicCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ])
            ->call('select', $user->getKey());

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertSee('User A');
        $component->assertDontSee('User B');
        $component->assertDontSee('User C');
        $component->assertDontSee('Other');

        $component->assertEmittedUp('selected-users');
        $component->assertNotEmitted('cleared-users');

        $component = $component->set('search', 'User');

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertSee('User A');
        $component->assertSee('User B');
        $component->assertSee('User C');
        $component->assertDontSee('Other');

        $component->assertNotEmitted('selected-users');
        $component->assertEmittedUp('cleared-users');
    }

    /**
     * Check the selected option is cleared when the search has been cleared.
     */
    public function test_the_selected_option_is_cleared_when_the_search_has_been_cleared(): void
    {
        $this->seed(UserSeeder::class);
        $user = User::query()->where('email', 'user_a@example.com')->first();

        $component = Livewire::test(BasicCombobox::class, [
            'name' => 'users',
            'label' => 'Users',
            'placeholder' => 'Select a user',
        ])
            ->call('select', $user->getKey());

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertSee('User A');
        $component->assertDontSee('User B');
        $component->assertDontSee('User C');
        $component->assertDontSee('Other');

        $component->assertEmittedUp('selected-users');
        $component->assertNotEmitted('cleared-users');

        $component = $component->set('search', '');

        $component->assertSuccessful();
        $component->assertSee('Users');
        $component->assertSee('Select a user');
        $component->assertDontSee('User A');
        $component->assertDontSee('User B');
        $component->assertDontSee('User C');
        $component->assertDontSee('Other');

        $component->assertNotEmitted('selected-users');
        $component->assertEmittedUp('cleared-users');
    }
}
