<?php

namespace Tests\Feature\Pexels;

use App\Models\Product;
use App\Services\Pexels\PexelsClient;
use App\Services\Pexels\PexelsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\MockInterface;
use RuntimeException;
use Tests\TestCase;

class PexelsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_import_video(): void
    {
        $mock = $this->mockClient();
        $service = $this->app->make(PexelsService::class);
        $product = Product::factory()->create();

        $mock->shouldReceive('searchVideos')->once()->andReturn($this->pexelsVideoResponse());
        $mock->shouldReceive('tryFetchFile')->once()->andReturn('fake binary');
        $count = $service->importVideo($product, 'text name');

        $this->assertSame(1, $count);

        $this->assertDatabaseHas('media', [
            'file_name' => 'media/products/'.$product->translate('en')->slug.'/video.mp4',
        ]);

        $this->assertDatabaseHas('mediables', [
            'mediable_id' => $product->id,
            'mediable_type' => Product::class,
            'collection' => 'video',
            'order' => 0,
        ]);
    }

    public function test_can_import_photos(): void
    {
        $mock = $this->mockClient();
        $service = $this->app->make(PexelsService::class);
        $product = Product::factory()->create();

        $mock->shouldReceive('searchPhotos')->once()->andReturn($this->pexelsPhotosResponse());
        $mock->shouldReceive('tryFetchFile')->times(2)->andReturn('fake binary');
        $count = $service->importPhotos($product, 'text name');

        $this->assertSame(2, $count);

        $this->assertDatabaseHas('mediables', [
            'mediable_id' => $product->id,
            'mediable_type' => Product::class,
            'collection' => 'main_image',
            'order' => 0,
        ]);

        $this->assertDatabaseHas('mediables', [
            'mediable_id' => $product->id,
            'mediable_type' => Product::class,
            'collection' => 'images',
            'order' => 0,
        ]);
    }

    public function test_can_import_both_video_and_photos(): void
    {
        $mock = $this->mockClient();
        $service = $this->app->make(PexelsService::class);
        $product = Product::factory()->create();

        $mock->shouldReceive('searchVideos')->once()->andReturn($this->pexelsVideoResponse());
        $mock->shouldReceive('searchPhotos')->once()->andReturn($this->pexelsPhotosResponse());
        $mock->shouldReceive('tryFetchFile')->times(3)->andReturn('fake binary');

        $count = $service->import($product);

        $this->assertSame(3, $count);
    }

    public function test_can_import_video_returns_empty_array(): void
    {
        $mock = $this->mockClient();
        $service = $this->app->make(PexelsService::class);
        $product = Product::factory()->create();

        $mock->shouldReceive('searchVideos')->once()->andReturn([]);

        $count = $service->importVideo($product, 'text name');

        $this->assertSame(0, $count);
        $this->assertDatabaseCount('mediables', 0);
    }

    public function test_can_import_photos_returns_empty_array(): void
    {
        $mock = $this->mockClient();
        $service = $this->app->make(PexelsService::class);
        $product = Product::factory()->create();

        $mock->shouldReceive('searchPhotos')->once()->andReturn([]);

        $count = $service->importPhotos($product, 'text name');

        $this->assertSame(0, $count);
        $this->assertDatabaseCount('mediables', 0);
    }

    public function test_storage_fails(): void
    {
        $mock = $this->mockClient();
        $service = $this->app->make(PexelsService::class);
        $product = Product::factory()->create();

        Storage::shouldReceive('put')->once()->andReturn(false);
        $mock->shouldReceive('searchVideos')->once()->andReturn($this->pexelsVideoResponse());
        $mock->shouldReceive('tryFetchFile')->once()->andReturn('fake binary');

        $this->expectException(RuntimeException::class);

        $service->importVideo($product, 'text name');
    }

    private function mockClient(): MockInterface
    {
        $mock = Mockery::mock(PexelsClient::class);

        $this->app->instance(PexelsClient::class, $mock);

        return $mock;
    }

    private function pexelsPhotosResponse(): array
    {
        return [
            [
                'id' => 1,
                'src' => [
                    'portrait' => 'https://www.pexels.com/photo/test-1',
                ],
                'alt' => 'test-1',
            ],
            [
                'id' => 2,
                'src' => [
                    'portrait' => 'https://www.pexels.com/photo/test-2',
                ],
                'alt' => 'test-2',
            ],
        ];
    }

    private function pexelsVideoResponse(): array
    {
        return [
            [
                'id' => 12345,
                'video_files' => [
                    [
                        'id' => 1,
                        'file_type' => 'video/mp4',
                        'height' => 720,
                        'link' => 'https://videos.pexels.com/video-files/12345/12345-720.mp4',
                    ],
                ],
            ],
        ];
    }
}
