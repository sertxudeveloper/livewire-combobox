<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Components;

use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\LivewireCombobox\Components\Combobox;
use SertxuDeveloper\LivewireCombobox\Tests\Models\User;

class BasicCombobox extends Combobox {

    /** @var class-string<Model> $model */
    public string $model = User::class;
}
