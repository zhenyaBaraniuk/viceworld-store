<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface MediaFileInterface
{
    public function mediaFiles(): MorphToMany;
}
