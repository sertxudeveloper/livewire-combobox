<?php

namespace SertxuDeveloper\LivewireCombobox\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Component;

abstract class Combobox extends Component {

    /** @var class-string<Model> $model */
    public string $model;

    public ?Model $selected = null;

    public string $name = 'combobox';
    public string $label = 'Combobox';
    public string $placeholder = 'Select an option';

    /** The search query */
    public string $search = '';

    /** If set to false, will not keep the selection, useful if you want to make a list. */
    public bool $keepSelection = true;

    /**
     * The initial selection of the combobox.
     *
     * @var Model|null
     */
    public ?Model $init = null;

    /**
     * The columns that should be obtained.
     *
     * @var string[]
     */
    public array $columns = ['*'];

    /**
     * The column to be shown as the label.
     *
     * @var string
     */
    public string $labelColumn = 'name';

    /**
     * The columns that should be searched on.
     *
     * @var string[]
     */
    public array $searchColumns = ['name'];

    /**
     * The columns and the order that should be obtained.
     *
     * @var string[]
     */
    public array $sortColumns = [
        'id' => 'asc',
    ];

    /**
     * The quantity of results to be shown.
     *
     * @var int
     */
    public int $limit = 10;

    /**
     * If the result has only one result, it will be automatically selected.
     *
     * @var bool
     */
    public bool $selectOnlyResult = true;

    /**
     * The properties that should be reset once a selection is made.
     *
     * @var array
     */
    protected array $resets = [
        //
    ];

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void {
        if (!$this->label) $this->label = Str::headline($this->name);

        if ($this->init && !$this->selected && !$this->search && $this->keepSelection) {
            if (!$this->init instanceof $this->model) return;
            $this->selectModel($this->init, true);
        }
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View {
        return view('livewire-combobox::livewire.combobox', [
            'collection' => $this->getCollection(),
        ]);
    }

    /**
     * Select the given model.
     *
     * @param mixed $id
     * @param bool $silent
     * @return void
     */
    public function select(mixed $id, bool $silent = false): void {
        $model = $this->model::query()->find($id, $this->columns);
        if ($model) $this->selectModel($model, $silent);
    }

    /**
     * Get the collection of results.
     *
     * @return Collection|null
     */
    protected function getCollection(): ?Collection {
        if ($this->selected && $this->selected->{$this->labelColumn} !== $this->search) {
            $this->clearSelection();
        }

        if (!$this->search) return null;

        $result = $this->queryModel();

        if ($this->selectOnlyResult && $result->count() === 1) {
            $this->selected = $result->first();
            $this->selectModel($this->selected);
        }

        return $result;
    }

    /**
     * Query the model for the search results.
     *
     * @return Collection
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
     *
     * @param mixed $model
     * @param bool $silent
     * @return void
     */
    protected function selectModel(mixed $model, bool $silent = false): void {
        if ($this->keepSelection) {
            $this->selected = $model;
            $this->search = $model->{$this->labelColumn};
        }

        if (!$silent) {
            $this->emitUp("selected-$this->name", $model);

            // Prevent the component from resetting all the properties if array is empty
            if (!empty($this->resets)) {
                $this->reset($this->resets);
            }
        }
    }

    /**
     * Clear the current selection.
     *
     * @return void
     */
    protected function clearSelection(): void {
        $this->selected = null;

        $this->emitUp("cleared-$this->name");
    }
}
