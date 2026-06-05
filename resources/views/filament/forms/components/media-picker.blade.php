<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
        state: $wire.$entangle(@js($getStatePath())),
        openViewer(imgEl) {
            const el = imgEl ?? this.$refs.previewImg;

            const viewer = new Viewer(el, {
                navbar: false,
                title: false,
                toolbar: {
                    zoomIn: { show: true, size: 'large' },
                    zoomOut: { show: true, size: 'large' },
                    reset: { show: true, size: 'large' },
                },
            });
            viewer.show();
            el.addEventListener('hidden.viewer', () => viewer.destroy(), { once: true });
        }
        }"
        @file-selected.window="
         if ($event.detail.statePath === @js($getStatePath())) {
           state = $event.detail.value;
           $dispatch('close-modal', { id: 'media-picker-{{ $getStatePath() }}' });
         }"

        {{ $getExtraAttributeBag() }}
    >
        <div x-show="state && !Array.isArray(state)" x-cloak class="mb-3 p-3 bg-gray-50 dark:bg-white/5 rounded-lg flex items-center gap-3 border
        border-gray-200 dark:border-white/10">
            <template x-if="state.mime_type?.startsWith('image/')">
                <img
                    x-ref="previewImg"
                    :src="state?.url" class="h-24 w-24 rounded object-cover shrink-0 cursor-pointer"
                    @click="openViewer()"
                />
            </template>

            <template x-if="state.mime_type?.startsWith('video/')">
                <video
                    controls
                    class="h-24 w-24 rounded object-cover shrink-0"
                >
                    <source :src="state?.url">
                </video>
            </template>

            <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-700 dark:text-gray-200 truncate">Selected file</p>
            </div>

            <x-filament::icon-button
                icon="heroicon-m-x-mark"
                color="danger"
                size="sm"
                @click="state = null"
            />
        </div>

        <div x-show="Array.isArray(state) && state.length > 0" x-cloak class="mb-3 flex flex-wrap gap-2">
            <template x-for="item in state" :key="item.id">
                <div class="relative group">
                    <img
                        :src="item.url" class="h-24 w-24 rounded object-cover cursor-pointer"
                        @click="openViewer($event.target)"
                    />

                    <button
                        type="button"
                        @click.stop="state = state.filter(i => i.id !== item.id)"
                        class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full text-white text-xs hidden group-hover:flex items-center justify-center"
                    >×
                    </button>
                </div>
            </template>
        </div>

        <x-filament::modal id="media-picker-{{ $getStatePath() }}" width="7xl">
            <x-slot name="trigger">
                <x-filament::button>Browse</x-filament::button>
            </x-slot>

            @livewire('media-browser-modal', ['multiple' => $field->isMultiple, 'statePath' => $getStatePath()])
        </x-filament::modal>
    </div>
</x-dynamic-component>
