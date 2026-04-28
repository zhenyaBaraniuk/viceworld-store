<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ state: $wire.$entangle(@js($getStatePath())), previewUrl:null }"
        @file-selected.window="
        if ($event.detail.statePath !== @js($getStatePath())) return;
        state = $event.detail.value;
        previewUrl = $event.detail.url;
        $dispatch('close-modal', { id: 'media-picker-{{ $getStatePath() }}' })"
        {{ $getExtraAttributeBag() }}
    >
        <div x-show="previewUrl" x-cloak class="mb-3 p-3 bg-gray-50 dark:bg-white/5 rounded-lg flex items-center gap-3 border
        border-gray-200 dark:border-white/10">
            <img :src="previewUrl" class="h-16 w-16 rounded object-cover shrink-0" />
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-700 dark:text-gray-200 truncate">Selected image</p>
                </div>
            <x-filament::icon-button
                icon="heroicon-m-x-mark"
                color="danger"
                size="sm"
                @click="state = null; previewUrl = null"
            />
        </div>

        <x-filament::modal id="media-picker-{{ $getStatePath() }}" width="7xl">
            <x-slot name="trigger">
                <x-filament::button>Browse</x-filament::button>
            </x-slot>

            @livewire('media-browser-modal', ['multiple' => $field->isMultiple, 'statePath' => $getStatePath()])
        </x-filament::modal>
    </div>
</x-dynamic-component>
