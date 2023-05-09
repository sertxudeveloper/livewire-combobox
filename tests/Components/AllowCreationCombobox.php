<?php

namespace SertxuDeveloper\LivewireCombobox\Tests\Components;

use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\LivewireCombobox\Components\Combobox;
use SertxuDeveloper\LivewireCombobox\Tests\Models\Post;

class AllowCreationCombobox extends Combobox
{
    /** @var class-string<Model> The model to be used. */
    public string $model = Post::class;

    /** If the combobox should be able to create new models. */
    public bool $canCreate = true;

    /** The column to be shown as the label. */
    public string $labelColumn = 'title';
}
