<div x-data="{ open: false }"
     @click.outside="open = false">

    <label class="form-label" for="{{ $name }}">{{ $label }}</label>

    <div class="relative mt-1">
        <input type="search" class="form-input" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
               @focus="open = true" @click="open = true" wire:model.debounce.800ms="search" wire:clear
               role="combobox" aria-controls="options" aria-expanded="false" autocomplete="off">

        <ul class="absolute z-21 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            x-show="open" x-cloak role="listbox">
            @if($collection && $collection->isNotEmpty())
                @foreach($collection as $item)
                    <li class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-blue-50"
                        wire:click="select('{{ $item->getKey() }}')" @click="open = false"
                        role="option" tabindex="-1">
                        @if($selected && $selected->getKey() === $item->getKey())
                            <span class="block truncate font-medium">{{ $item->$labelColumn }}</span>
                            <span class="text-blue-700 absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M17.8668 2.65374L6.36091 14.1596L2.13323 9.93194C1.92826 9.72697 1.59591 9.72697 1.3909 9.93194L0.153717 11.1691C-0.0512543 11.3741 -0.0512543 11.7064 0.153717 11.9115L5.98972 17.7475C6.19469 17.9524 6.52704 17.9524 6.73206 17.7475L19.8463 4.63325C20.0512 4.42828 20.0512 4.09594 19.8463 3.89092L18.6091 2.65374C18.4041 2.44877 18.0718 2.44877 17.8668 2.65374Z"></path>
                                </svg>
                            </span>
                        @else
                            <span class="block truncate">{{ $item->$labelColumn }}</span>
                        @endif
                    </li>
                @endforeach
            @endif

            @if($canCreate && $search)
                <li class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-blue-50"
                    wire:click="create" @click="open = false"
                    role="option" tabindex="-1">
                    <span class="block truncate">Create <b>{{ $search }}</b></span>
                </li>
            @endif
        </ul>
    </div>
</div>
