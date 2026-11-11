<?php

namespace App\Console\Commands\NovaPost;

use App\Models\NpCity;
use App\Services\NovaPost\NovaPostService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportCities extends Command
{
    protected $signature = 'np:sync-cities';

    protected $description = 'Command to import cities from api data';

    private const int INACTIVE_AFTER_DAYS = 3;

    private const int PAGE_LIMIT = 500;

    public function __construct(private readonly NovaPostService $service)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $page = 1;

        do {
            $data = $this->service->fetchCityPage($page, self::PAGE_LIMIT);

            $this->syncCities($data);

            $page++;
        } while (count($data) === self::PAGE_LIMIT);

        NpCity::query()->where('updated_at', '<', now()->subDays(self::INACTIVE_AFTER_DAYS))->update(['is_active' => false]);

        return self::SUCCESS;
    }

    protected function syncCities(array $data): void
    {
        $rows = collect($data)
            ->filter(fn (array $city) => ! empty($city['Ref']) && ! empty($city['Description']))
            ->map(fn (array $city) => [
                'ref' => Arr::get($city, 'Ref'),
                'name' => Arr::get($city, 'Description'),
                'type_name' => Arr::get($city, 'SettlementTypeDescription'),
                'area_ref' => Arr::get($city, 'Area'),
                'is_active' => true,
            ])
            ->values()
            ->all();

        NpCity::query()->upsert($rows, ['ref'], ['name', 'type_name', 'area_ref', 'is_active']);
    }
}
