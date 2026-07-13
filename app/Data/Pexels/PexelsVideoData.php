<?php

namespace App\Data\Pexels;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class PexelsVideoData extends Data
{
    public function __construct(
        public int $id,
        public Collection $files,
    ) {}

    public static function fromApi(array $video): self
    {
        return new self(
            $video['id'],
            collect($video['video_files'])->map(function ($file) {
                return PexelsVideoFileData::fromApi($file);
            })
        );
    }
}
