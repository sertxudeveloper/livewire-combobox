<?php

namespace SertxuDeveloper\LivewireCombobox\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class ComboboxMakeCommand extends GeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'combobox:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new combobox component';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Combobox';

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string {
        return $rootNamespace . '\Http\Livewire';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Specify the model to use.'],
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string {
        return __DIR__ . '/stubs/combobox.stub';
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param string $model
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function parseModel(string $model): string {
        if (preg_match('([^A-Za-z\d_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    /**
     * Replace the model for the given stub.
     *
     * @param string $stub
     * @param string $model
     * @return string
     */
    protected function replaceModel(string $stub, string $model): string {
        $modelClass = $this->parseModel($model);

        $replace = [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ];

        return str_replace(
            array_keys($replace), array_values($replace), $stub
        );
    }
}
