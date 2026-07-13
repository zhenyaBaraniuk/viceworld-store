<?php

namespace App\Data\Pexels;

use Spatie\LaravelData\Data;

class PexelsVideoFileData extends Data
{
    public function __construct(
        public int $id,
        public string $fileType,
        public int $height,
        public string $link,
    ) {}

    public static function fromApi(array $file): self
    {
        return new self(
            $file['id'],
            $file['file_type'],
            $file['height'],
            $file['link'],
        );
    }
}
