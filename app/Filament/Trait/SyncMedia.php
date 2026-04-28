<?php

namespace App\Filament\Trait;

use Illuminate\Support\Facades\DB;

trait SyncMedia
{
    public function syncMedia(): void
    {
        $data = $this->form->getState();
        $mediaCollection = $this->getMediaCollections();

        foreach ($mediaCollection as $collection => $multiple) {
            if (empty($data[$collection])) continue;

            DB::table('mediables')
                ->where('mediable_id', $this->record->id)
                ->where('mediable_type', get_class($this->record))
                ->where('collection', $collection)
                ->delete();

            $this->record->mediaFiles()
                ->wherePivot('collection', $collection)
                ->sync([]);

            $ids = $multiple ? $data[$collection] : [$data[$collection]];

            foreach ($ids as $order => $id) {
                $this->record->mediaFiles()->attach($id, [
                    [
                        'collection' => $collection,
                        'order' => $order,
                    ]
                ]);
            }
        }
    }

    protected  function getMediaCollections(): array
    {
        return [];
    }
}
