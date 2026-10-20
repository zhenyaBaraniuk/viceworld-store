<?php

namespace App\Data\Label;

use App\Models\Label;
use Spatie\LaravelData\Data;

class LabelData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}

    public static function fromModel(Label $label): self
    {
        return new self(
            $label->id,
            $label->translated('name') ?? '',
        );
    }
}
