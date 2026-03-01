<?php

namespace App\Filament\Resources\Payments\RelationManagers;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\RelationManagers\RelationManager;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $relatedResource = TransactionResource::class;
}
