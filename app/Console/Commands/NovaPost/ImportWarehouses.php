<?php

namespace App\Console\Commands\NovaPost;

use App\Models\NpWarehouse;
use App\Services\NovaPost\NovaPostService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportWarehouses extends Command
{
    protected $signature = 'np:sync-warehouses';

    protected $description = 'Command to import warehouses from api data';

    private const int PAGE_LIMIT = 400;

    public function handle(NovaPostService $service): int
    {
        $page = 1;

        do {
            $data = $service->fetchWarehousePage($page, self::PAGE_LIMIT);

            $this->syncWarehouses($data);

            $page++;
        } while (count($data) === self::PAGE_LIMIT);

        return self::SUCCESS;
    }

    public function syncWarehouses(array $data): void
    {
        $rows = collect($data)
            ->filter(fn (array $warehouse) => ! empty($warehouse['Ref']) && ! empty($warehouse['Description']))
            ->map(fn (array $warehouse) => [
                'ref' => Arr::get($warehouse, 'Ref'),
                'city_ref' => Arr::get($warehouse, 'CityRef'),
                'name' => Arr::get($warehouse, 'Description'),
                'number' => Arr::get($warehouse, 'Number'),
                'category' => Arr::get($warehouse, 'CategoryOfWarehouse'),
                'postomat_type' => Arr::get($warehouse, 'PostMachineType'),
                'status' => Arr::get($warehouse, 'WarehouseStatus'),
            ])
            ->values()
            ->all();

        NpWarehouse::query()->upsert($rows, ['ref'], ['city_ref', 'name', 'number', 'category', 'postomat_type', 'status']);
    }
}
