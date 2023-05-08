<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\LivewireCombobox\Tests\Models\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
}
