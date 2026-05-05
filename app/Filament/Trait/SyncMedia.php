<?php

namespace App\Filament\Trait;

trait SyncMedia
{
    public function syncMedia(): void
    {
        $data = $this->form->getState();
        $mediaCollection = $this->getMediaCollections();

        foreach ($mediaCollection as $collection => $multiple) {
            $this->record->mediaFiles()
                ->wherePivot('collection', $collection)
                ->sync([]);

            if (empty($data[$collection])) {
                continue;
            }

            $ids = $multiple ? $data[$collection] : [$data[$collection]];

            foreach ($ids as $order => $id) {
                $this->record->mediaFiles()->attach($id, [
                    'collection' => $collection,
                    'order' => $order,
                ]);
            }
        }
    }

    protected function getMediaCollections(): array
    {
        return [];
    }
}
