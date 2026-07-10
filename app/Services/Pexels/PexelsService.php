<?php

namespace App\Services\Pexels;

use App\Data\Pexels\PexelsPhotoData;
use App\Data\Pexels\PexelsVideoData;
use App\Data\Pexels\PexelsVideoFileData;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PexelsService
{
    public function __construct(private readonly PexelsClient $client) {}

    public function import(Product $product): int
    {
        $name = $product->translate('en')->name;

        $countVideo = $this->importVideo($product, $name);
        $countPhotos = $this->importPhotos($product, $name);

        return $countPhotos + $countVideo;
    }

    public function importVideo(Product $product, string $name): int
    {
        $videos = collect($this->client->searchVideos($name))
            ->map(function (array $video) {
                return PexelsVideoData::fromApi($video);
            });

        $video = $this->pickVideoFiles($videos);

        if (! $video) {
            return 0;
        }

        $filename = 'video.mp4';
        $path = $this->download($product, $video->link, $filename);

        DB::transaction(function () use ($product, $path, $filename): void {
            $media = Media::createFromFile($filename, $path);

            $product->mediaFiles()->attach($media->id, [
                'collection' => 'video',
                'order' => 0,
            ]);
        });

        return 1;
    }

    public function importPhotos(Product $product, string $name): int
    {
        $photos = collect($this->client->searchPhotos($name))
            ->map(function (array $photo) {
                return PexelsPhotoData::fromApi($photo);
            });

        $order = 0;

        foreach ($photos as $index => $photo) {
            $filename = "photos-{$index}.jpg";
            $path = $this->download($product, $photo->url, $filename);

            DB::transaction(function () use ($product, $path, $filename, $index, &$order): void {
                $media = Media::createFromFile($filename, $path);

                if ($index === 0) {
                    $product->mediaFiles()->attach($media->id, [
                        'collection' => 'main_image',
                        'order' => 0,
                    ]);
                } else {
                    $product->mediaFiles()->attach($media->id, [
                        'collection' => 'images',
                        'order' => $order++,
                    ]);
                }
            });
        }

        return $photos->count();
    }

    private function download(Product $product, string $url, string $filename): string
    {
        $slug = $product->translate('en')->slug;

        $content = $this->client->tryFetchFile($url);

        $path = "media/products/{$slug}/{$filename}";

        $stored = Storage::put($path, $content);

        throw_unless($stored, RuntimeException::class, "Failed to store file: {$path}");

        return $path;
    }

    private function pickVideoFiles(Collection $videos): ?PexelsVideoFileData
    {
        $mp4 = $videos
            ->flatMap(fn (PexelsVideoData $video) => $video->files)
            ->where('fileType', '=', 'video/mp4')
            ->sortBy('height');

        return $mp4->firstWhere('height', '>=', 720) ?? $mp4->last();
    }
}
