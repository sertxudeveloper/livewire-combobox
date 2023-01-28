
<p align="center"><img src="/art/socialcard.png" alt="Laravel Combobox by Sertxu Developer"></p>

# Add combobox to your Livewire forms

![](https://img.shields.io/github/v/release/sertxudeveloper/livewire-combobox) ![](https://github.com/sertxudeveloper/livewire-combobox/actions/workflows/run-tests.yml/badge.svg) ![](https://img.shields.io/github/license/sertxudeveloper/livewire-combobox) ![](https://img.shields.io/librariesio/github/sertxudeveloper/livewire-combobox) ![](https://img.shields.io/github/repo-size/sertxudeveloper/livewire-combobox) ![](https://img.shields.io/packagist/dt/sertxudeveloper/livewire-combobox) ![](https://img.shields.io/github/issues/sertxudeveloper/livewire-combobox) ![](https://img.shields.io/packagist/php-v/sertxudeveloper/livewire-combobox) [![Codecov Test coverage](https://img.shields.io/codecov/c/github/sertxudeveloper/livewire-combobox)](https://app.codecov.io/gh/sertxudeveloper/livewire-combobox)


Do you have a large dataset, and you need to be able to display it in a dropdown?

When a basic select input is not enough, you can use a combobox!

A combobox works like a select input, but instead of a dropdown, it displays a list of options that can be filtered by
typing.

You will no longer need to download all the data at the startup, just get the data you're looking for.

## Requirements

**This package requires AlpineJS to work properly.**

If you're not going to use AlpineJS, you might want to publish the component view in order to replace the AlpineJS functionality.

```bash
php artisan vendor:publish --provider="SertxuDeveloper\Livewire\LivewireComboboxServiceProvider"
```

## Installation

You can install the package via composer:

```bash
composer require sertxudeveloper/livewire-combobox
```

## Usage

Once you have installed the package, you can use it in your Livewire forms.

First, you need to execute the following command in your terminal:

```bash
php artisan combobox:make UsersCombobox -m User
```

This will create a new component in the `App/Http/Livewire` directory.

The new `UsersCombobox` component will look like this:

```php
<?php

namespace App\Http\Livewire;

use App\Models\User;
use SertxuDeveloper\LivewireCombobox\Components\Combobox;

class UsersCombobox extends Combobox
{

    /** @var class-string<Model> $model */
    public string $model = User::class;

}
```

As you can see, the `$model` property is set to the `User` model.
This means that the component will be able to query the database using this model.

By default, the component will display the `name` column of the model.
You can change this by setting the `labelColumn` property:

```php
/**
 * The column to be shown as the label.
 *
 * @var string
 */
public string $labelColumn = 'title'; // Default: 'name'
```

To start using the component, you need to add it to your Livewire form.

```blade
<livewire:users-combobox>
```

```blade
@livewire('users-combobox')
```

You can also pass some parameters to the component:

```blade
<livewire:users-combobox name="author" label="Author" placeholder="Select a user">
```

> **Warning**<br>
> If you don't pass any parameters, the component will use the default values.<br>
> It's recommended to pass the parameters to the component.<br>
> You can also add the values overriding the default values in the class.

## Events

While interacting with the component, some events might be fired.

The name of the events depends on the component name, this allows you to have more than one combobox in your form.

- `selected-<component-name>`: When the user selects an option from the dropdown.
- `cleared-<component-name>`: When the user clears the selected option.

These events will be fired up, so the parent component can react to the user interaction.

> **Note**<br>
> The `selected` event contains the selected model as a parameter.

## Testing

This package contains tests, you can run them using the following command:

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/sertxudeveloper/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sergio Peris](https://github.com/sertxudev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<br><br>
<p align="center">Copyright © 2022 Sertxu Developer</p>
