<?php

namespace App\Enums\Product;

enum ProductStatus: string
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case ARCHIVED = 'archived';
}
