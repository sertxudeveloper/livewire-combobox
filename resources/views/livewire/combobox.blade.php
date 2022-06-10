<div x-data="{ open: false }"
     @click.outside="open = false">

    <label class="form-label" for="{{ $name }}">{{ $label }}</label>

    <div class="relative mt-1">
        <input type="text" class="form-input" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
               @focus="open = true" @click="open = true" wire:model.debounce.800ms="search"
               role="combobox" aria-controls="options" aria-expanded="false">

        @if($collection && $collection->isNotEmpty())
            <ul class="absolute z-21 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                x-show="open" x-cloak role="listbox">

                @foreach($collection as $item)
                    <li class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-blue-50"
                        wire:click="select('{{ $item->getKey() }}')"
                        role="option" tabindex="-1">
                        @if($selected && $selected->getKey() === $item->getKey())
                            <span class="block truncate font-medium">{{ $item->$labelColumn }}</span>
                            <span class="text-blue-700 absolute inset-y-0 right-0 flex items-center pr-4">
                <x-icon icon="check" width="13" height="13"/>
              </span>
                        @else
                            <span class="block truncate">{{ $item->$labelColumn }}</span>
                        @endif
                    </li>
                @endforeach

            </ul>
        @endif
    </div>
</div>
