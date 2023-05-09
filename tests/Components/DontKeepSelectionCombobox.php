<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Components;

use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\LivewireCombobox\Components\Combobox;
use SertxuDeveloper\LivewireCombobox\Tests\Models\User;

class DontKeepSelectionCombobox extends Combobox
{
    /** @var class-string<Model> The model to be used. */
    public string $model = User::class;

    /** If set to false, will not keep the selection, useful if you want to make a list. */
    public bool $keepSelection = false;
}
