<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Components;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\LivewireCombobox\Components\Combobox;
use SertxuDeveloper\LivewireCombobox\Tests\Models\User;

class FilteredCombobox extends Combobox
{
    /** @var class-string<Model> The model to be used. */
    public string $model = User::class;

    /** If the result has only one result, it will be automatically selected. */
    public bool $selectOnlyResult = false;

    /**
     * Apply filters to the query.
     */
    protected function filter(Builder $query): void {
        $query->where('email', 'like', '%@example.com');
    }
}
