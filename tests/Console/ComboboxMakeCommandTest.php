<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Console;

use InvalidArgumentException;
use SertxuDeveloper\LivewireCombobox\Tests\TestCase;

class ComboboxMakeCommandTest extends TestCase {

    /**
     * Check if the command can be executed.
     *
     * @return void
     */
    public function test_command_can_be_executed(): void {
        $this->artisan('combobox:make', [
            'name' => 'TestCombobox',
        ]);

        $this->assertFileExists(app_path('Http/Livewire/TestCombobox.php'));
        unlink(app_path('Http/Livewire/TestCombobox.php'));
    }

    /**
     * Check if the command can be executed with the --model option.
     *
     * @return void
     */
    public function test_command_can_be_executed_with_model_option(): void {
        $this->artisan('combobox:make', [
            'name' => 'TestModelCombobox',
            '--model' => 'User',
        ]);

        $this->assertFileExists(app_path('Http/Livewire/TestModelCombobox.php'));
        unlink(app_path('Http/Livewire/TestModelCombobox.php'));
    }

    /**
     * Check if the command generates the correct file.
     *
     * @return void
     */
    public function test_command_generates_correct_file(): void {
        $this->artisan('combobox:make', [
            'name' => 'TestModelCombobox',
            '--model' => 'User',
        ]);

        $contents = file_get_contents(app_path('Http/Livewire/TestModelCombobox.php'));

        $this->assertStringContainsString('class TestModelCombobox extends Combobox', $contents);
        $this->assertStringContainsString('use App\Models\User;', $contents);

        unlink(app_path('Http/Livewire/TestModelCombobox.php'));
    }

    /**
     * Check if the command cannot be executed with an invalid name.
     *
     * @return void
     */
    public function test_command_cannot_be_executed_with_invalid_model(): void {
        $this->expectException(InvalidArgumentException::class);

        $this->artisan('combobox:make', [
            'name' => 'TestModelCombobox',
            '--model' => 'User-*Invalid\\Model',
        ]);

        $this->assertFileDoesNotExist(app_path('Http/Livewire/TestModelCombobox.php'));
    }
}
