<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use SertxuDeveloper\LivewireCombobox\Tests\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::factory()->create(['name' => 'User A', 'email' => 'user_a@example.com']);
        User::factory()->create(['name' => 'User B', 'email' => 'user_b@example.com']);
        User::factory()->create(['name' => 'User C', 'email' => 'user_c@example.com']);
        User::factory()->create(['name' => 'Other', 'email' => 'other@example.com']);
    }
}
