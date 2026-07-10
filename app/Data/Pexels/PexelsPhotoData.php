<?php

namespace App\Data\Pexels;

use Spatie\LaravelData\Data;

class PexelsPhotoData extends Data
{
    public function __construct(
        public int $id,
        public string $url,
        public ?string $alt,
    ) {}

    public static function fromApi(array $photo): self
    {
        return new self(
            $photo['id'],
            $photo['src']['portrait'],
            $photo['alt'] ?? null,
        );
    }
}
