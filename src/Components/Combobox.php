<?php

namespace SertxuDeveloper\LivewireCombobox\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Component;

abstract class Combobox extends Component
{
    /** @var class-string<Model> The model to be used. */
    public string $model;

    /** The selected model. */
    public ?Model $selected = null;

    /** The name of the combobox. */
    public string $name = 'combobox';

    /** The label of the combobox. */
    public string $label = 'Combobox';

    /** The placeholder of the combobox. */
    public string $placeholder = 'Select an option';

    /** The search query */
    public string $search = '';

    /** If set to false, will not keep the selection, useful if you want to make a list. */
    public bool $keepSelection = true;

    /** The initial selection of the combobox. */
    public ?Model $init = null;

    /** The columns that should be obtained. */
    public array $columns = ['*'];

    /** The column to be shown as the label. */
    public string $labelColumn = 'name';

    /** The columns that should be searched on.*/
    public array $searchColumns = ['name'];

    /** If the combobox should be able to create new models. */
    public bool $canCreate = false;

    /** The columns and the order that should be obtained. */
    public array $sortColumns = [
        'id' => 'asc',
    ];

    /** The quantity of results to be shown. */
    public int $limit = 10;

    /** If the result has only one result, it will be automatically selected. */
    public bool $selectOnlyResult = true;

    /**
     * Mount the component.
     */
    public function mount(): void {
        $this->label ??= Str::headline($this->name);

        if ($this->init && !$this->selected && !$this->search && $this->keepSelection) {
            if (!$this->init instanceof $this->model) {
                return;
            }

            $this->selectModel($this->init, true);
        }
    }

    /**
     * Render the component.
     */
    public function render(): View {
        return view('livewire-combobox::livewire.combobox', [
            'collection' => $this->getCollection(),
        ]);
    }

    /**
     * Select the given model.
     */
    public function select(mixed $id, bool $silent = false): void {
        if ($model = $this->model::query()->find($id, $this->columns)) {
            $this->selectModel($model, $silent);
        }
    }

    /**
     * Create a brand-new model with the given label.
     */
    public function create(): void {
        $model = $this->model::create([
            $this->labelColumn => $this->search,
        ]);

        $this->selectModel(model: $model->fresh());
    }

    /**
     * Get the collection of results.
     */
    protected function getCollection(): ?Collection {
        if ($this->selected && $this->selected->{$this->labelColumn} !== $this->search) {
            $this->clearSelection();
        }

        if (!$this->search) {
            return null;
        }

        $result = $this->queryModel();

        if ($this->selectOnlyResult && $result->count() === 1) {
            $this->selected = $result->first();
            $this->selectModel($this->selected);
        }

        return $result;
    }

    /**
     * Query the model for the search results.
     */
    protected function queryModel(): Collection {
        $query = $this->model::query();

        /** Apply filter to query */
        $query->where(function (Builder $query) {
            foreach ($this->searchColumns as $column) {
                $query->orWhere($column, 'like', "%$this->search%");
            }
        });

        /** Apply order to query */
        foreach ($this->sortColumns as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query->limit($this->limit)->get($this->columns);
    }

    /**
     * Set as selected the provided model and emit the selected event.
     */
    protected function selectModel(mixed $model, bool $silent = false): void {
        if ($this->keepSelection) {
            $this->selected = $model;
            $this->search = $model->{$this->labelColumn};
        } else {
            $this->reset(['selected', 'search']);
        }

        if (!$silent) {
            $this->emitUp("selected-$this->name", $model);
        }
    }

    /**
     * Clear the current selection.
     */
    protected function clearSelection(): void {
        $this->selected = null;

        $this->emitUp("cleared-$this->name");
    }
}
