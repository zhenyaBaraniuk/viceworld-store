<?php

namespace App\Console\Commands\Media;

use App\Models\Product;
use App\Services\Pexels\PexelsService;
use Illuminate\Console\Command;
use Illuminate\Support\Sleep;

class ImportMedia extends Command
{
    protected $signature = 'products:import-media';

    protected $description = 'Command for import photos and videos from Pexels';

    public function handle(PexelsService $pexelsService): int
    {
        $products = Product::query()->active()
            ->with('translations')
            ->whereDoesntHave('mediaFiles')
            ->get();

        if ($products->isEmpty()) {
            $this->info('All products have media.');

            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar(count($products));
        $bar->start();

        foreach ($products as $product) {
            $count = $pexelsService->import($product);

            $this->line("{$product->slug} imported {$count} files");

            $bar->advance();

            Sleep::sleep(1);
        }

        $bar->finish();

        return Command::SUCCESS;
    }
}
