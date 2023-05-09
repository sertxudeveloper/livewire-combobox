<?php

namespace SertxuDeveloper\LivewireCombobox\Tests;

use Livewire\Livewire;
use SertxuDeveloper\LivewireCombobox\Tests\Components\AllowCreationCombobox;
use SertxuDeveloper\LivewireCombobox\Tests\Models\Post;

class AllowCreationComboboxTest extends TestCase
{
    public function test_can_create_new_models(): void {
        Post::factory()->count(3)->create();

        $component = Livewire::test(AllowCreationCombobox::class, [
            'name' => 'posts',
            'label' => 'Posts',
        ])->set('search', 'Another Post');

        $component->assertSuccessful()
            ->assertSee('Posts')
            ->assertSee('Create <b>Another Post</b>', false)
            ->assertNotEmitted('selected-posts')
            ->assertNotEmitted('cleared-posts');

        $this->assertDatabaseCount('posts', 3);

        $component->call('create');

        $post = Post::query()->where('title', 'Another Post')->first();

        $component->assertEmitted('selected-posts')
            ->assertNotEmitted('cleared-posts')
            ->assertSet('selected', $post);

        $this->assertDatabaseCount('posts', 4);

        $this->assertDatabaseHas('posts', [
            'title' => 'Another Post',
        ]);
    }
}
