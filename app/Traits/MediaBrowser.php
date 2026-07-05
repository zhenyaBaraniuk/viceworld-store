<?php

namespace App\Traits;

use App\Models\Media;
use App\Models\MediaFolder;
use Illuminate\Support\Collection;

trait MediaBrowser
{
    public ?string $currentFolderId = null;

    public ?string $selectedFileId = null;

    public ?string $selectedFolderId = null;

    public string $search = '';

    public string $filter = 'all';

    public function navigateToFolder(?string $folderId): void
    {
        $this->currentFolderId = $folderId;
    }

    public function selectFolder(string $folderId)
    {
        $this->selectedFolderId = $this->selectedFolderId === $folderId ? null : $folderId;
    }

    public function getFolders(): Collection
    {
        return MediaFolder::query()
            ->withCount(['children', 'media'])
            ->when(
                $this->currentFolderId,
                fn ($q) => $q->where('parent_id', $this->currentFolderId),
                fn ($q) => $q->whereNull('parent_id'),
            )
            ->when($this->search, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->get();
    }

    public function getFiles(): Collection
    {
        return Media::query()
            ->when(
                $this->currentFolderId,
                fn ($q) => $q->where('folder_id', $this->currentFolderId),
                fn ($q) => $q->whereNull('folder_id'),
            )
            ->when($this->filter === 'images', fn ($q) => $q->where('mime_type', 'like', 'image/%'))
            ->when($this->filter === 'videos', fn ($q) => $q->where('mime_type', 'like', 'video/%'))
            ->when($this->filter === 'docs', fn ($q) => $q
                ->where('mime_type', 'not like', 'image/%')
                ->where('mime_type', 'not like', 'video/%')
            )
            ->when($this->search, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"),
            )->get();
    }

    public function getFolderBreadcrumbs(): array
    {
        $breadcrumbs = [];

        $folder = MediaFolder::query()->find($this->currentFolderId);

        while ($folder) {
            array_unshift($breadcrumbs, $folder);
            $folder = $folder->parent;
        }

        return $breadcrumbs;
    }
}
