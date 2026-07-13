<div>
    <div x-data="mediaBrowser({statePath: @js($statePath), multiple: @js($multiple)})"
         @close-modal.window="if ($event.detail.id === @js('media-picker-' . $statePath)) resetSelection()">

        <nav class="fm-breadcrumb-nav">
            <button type="button" wire:click="navigateToFolder(null)" class="fm-breadcrumb-link">Root</button>

            @foreach($this->getFolderBreadcrumbs() as $folder)
                <span class="opacity-30">/</span>

                @if($loop->last)
                    <span class="fm-breadcrumb-current">{{ $folder->name }}</span>
                @else
                    <button type="button" wire:click="navigateToFolder('{{ $folder->id }}')" class="fm-breadcrumb-link">
                        {{ $folder->name }}
                    </button>
                @endif
            @endforeach
        </nav>

        <section class="flex items-center justify-end gap-4">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-fm-on-surface-variant text-sm">search</span>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search files"
                    class="fm-search-input rounded-md pl-9 pr-4 py-2 text-sm w-64"
                />
            </div>

            <div class="flex bg-fm-surface-container rounded-full p-1 gap-1">
                <button type="button" wire:click="$set('filter', 'all')" @class(['fm-filter-btn', 'fm-filter-btn--active' => $filter === 'all'])>All</button>
                <button type="button" wire:click="$set('filter', 'images')" @class(['fm-filter-btn', 'fm-filter-btn--active' => $filter === 'images'])>Images</button>
                <button type="button" wire:click="$set('filter', 'videos')" @class(['fm-filter-btn', 'fm-filter-btn--active' => $filter === 'videos'])>Videos</button>
                <button type="button" wire:click="$set('filter', 'docs')" @class(['fm-filter-btn', 'fm-filter-btn--active' => $filter === 'docs'])>Docs</button>
            </div>
        </section>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-6 gap-y-10 mt-6">
            @foreach($this->getFolders() as $folder)
                <div class="group cursor-pointer"
                     wire:click="selectFolder('{{ $folder->id }}')"
                     wire:dblclick="navigateToFolder('{{ $folder->id }}')">
                    <div @class([
                        'aspect-4/3 rounded-xl flex items-center justify-center group-hover:bg-fm-surface-high transition-colors mb-3',
                        'ring-2 bg-fm-surface-high' => $this->selectedFolderId == $folder->id,
                        'bg-fm-surface-low' => $this->selectedFolderId !== $folder->id,
                    ])>
                        <span class="material-symbols-outlined text-fm-primary text-5xl fm-icon-folder">folder</span>
                    </div>
                    <p class="fm-item-name px-2">{{ $folder->name }}</p>
                    <p class="fm-item-meta px-2">{{ $folder->items_count }} {{ Str::plural('item', $folder->items_count) }}</p>
                </div>
            @endforeach

            @foreach($this->getFiles() as $file)
                <div class="group cursor-pointer"
                     @click="toggleFile('{{ $file->id }}', '{{ $file->url }}', '{{ $file->mime_type }}')"
                     @dblclick="resetSelection()"
                >
                    <div
                        :class="isSelected('{{ $file->id }}') ? 'ring-2 ring-fm-primary bg-fm-surface-high' : 'bg-fm-surface-low'"
                        class="aspect-4/3 rounded-xl flex items-center justify-center group-hover:bg-fm-surface-high transition-colors mb-3 relative overflow-hidden"
                    >
                        @if(str_starts_with($file->mime_type, 'image/'))
                            <img
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-100"
                                src="{{ $file->url }}" alt="{{ $file->name }}"/>
                        @elseif(str_starts_with($file->mime_type, 'video/'))
                            <video
                                class="w-full h-full object-cover" preload="metadata">
                                <source src="{{ $file->url }}#t=0.1" >
                            </video>
                        @else
                            <span class="material-symbols-outlined text-fm-on-surface-variant text-4xl">description</span>
                        @endif

                        <div class="absolute top-2 right-2">
                            <span class="bg-fm-secondary-container text-fm-on-secondary text-[10px] font-bold px-2 py-0.5 rounded-full">
                                .{{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}
                            </span>
                        </div>

                        <div x-show="isSelected('{{ $file->id }}')"
                             class="absolute top-2 left-2 w-5 h-5 bg-gray-900/75 rounded-full flex items-center justify-center">

                            <span class="material-symbols-outlined text-white text-[12px]">check_circle</span>
                        </div>
                    </div>
                    <p class="fm-item-name">{{ $file->name }}</p>
                    <p class="fm-item-meta">{{ $file->formatted_size }} • {{ $file->created_at->format('M d, Y') }}</p>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between mt-6 pt-4 border-t border-fm-surface-container">
            <p x-show="multiple && selectedFiles.length > 0" x-cloak class="text-sm text-fm-on-surface-variant">
                <span x-text="selectedFiles.length"></span> file(s) selected
            </p>

            <div class="ml-auto">
                <x-filament::button
                    type="button"
                    x-show="hasSelection()"
                    x-cloak
                    @click="confirm()"
                    icon="heroicon-m-check-circle"
                >
                    Select
                </x-filament::button>
            </div>
        </div>
    </div>
</div>
