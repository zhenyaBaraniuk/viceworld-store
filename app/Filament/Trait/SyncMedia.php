<?php

namespace App\Filament\Trait;

use App\Contracts\MediaFileInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @method (Model&MediaFileInterface) getRecord()
 */
trait SyncMedia
{
    public function syncMedia(): void
    {
        $data = $this->form->getState();
        $mediaCollection = $this->getMediaCollections();

        foreach ($mediaCollection as $collection => $config) {
            if (empty($data[$collection])) {
                continue;
            }

            if ($config['multiple']) {
                $this->syncMultiFiles($collection, array_column($data[$collection], 'id'));
            } else {
                $this->syncFile($collection, (int) $data[$collection]['id']);
            }
        }
    }

    protected function getMediaCollections(): array
    {
        return [];
    }

    private function syncFile(string $collection, int $id): void
    {
        $this->getRecord()->mediaFiles()
            ->wherePivot('collection', $collection)
            ->sync([]);

        $this->getRecord()->mediaFiles()->attach($id, [
            'collection' => $collection,
            'order' => 0,
        ]);
    }

    private function syncMultiFiles(string $collection, array $ids): void
    {
        $filteredIds = $this->filterDuplicates($collection, $ids);

        $order = $this->getRecord()->mediaFiles()
            ->wherePivot('collection', $collection)
            ->count();

        foreach ($filteredIds as $id) {
            $this->getRecord()->mediaFiles()->attach($id, [
                'collection' => $collection,
                'order' => $order++,
            ]);
        }
    }

    private function filterDuplicates(string $collection, array $ids): array
    {
        $existingIds = $this->getRecord()->mediaFiles()
            ->wherePivot('collection', $collection)
            ->pluck('media.id');

        $duplicateIds = collect($existingIds)->intersect($ids);

        return collect($ids)->diff($duplicateIds)->toArray();
    }
}
