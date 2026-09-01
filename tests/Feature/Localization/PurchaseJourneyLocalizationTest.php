<?php

namespace Tests\Feature\Localization;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseJourneyLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_journey_never_shows_a_raw_translation_key(): void
    {
        $category = Category::factory()->create();
        $this->attachMainImage($category);

        $product = Product::factory()->create(['category_id' => $category->id]);
        $product->translate('en')->fill(['description' => ['type' => 'doc', 'content' => []]])->save();
        $this->attachMainImage($product);

        $slug = $product->translate('en')->slug;

        $expected = json_decode(file_get_contents(lang_path('en.json')), true);

        $responses = [
            $this->get('/en/'),
            $this->get("/en/product/{$slug}"),
            $this->get('/en/search'),
            $this->get('/en/checkout'),
            $this->get('/en/success-order'),
        ];

        foreach ($responses as $response) {
            $response->assertOk();

            $translations = $this->inertiaProps($response)['translations'];

            $this->assertSame($expected, $translations);

            foreach ($translations as $key => $value) {
                $this->assertNotSame(
                    $key,
                    $value,
                    "Key [{$key}] resolved to itself, indicating a missing translation fallback."
                );
            }
        }
    }

    private function attachMainImage(Product|Category $model): void
    {
        $media = Media::query()->create([
            'folder_id' => null,
            'collection_name' => 'default',
            'name' => 'fixture',
            'file_name' => 'fixtures/fixture.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1,
            'disk' => 'public',
            'conversions_disk' => 'public',
            'model_type' => null,
            'model_id' => null,
            'manipulations' => [],
            'custom_properties' => [],
            'generated_conversions' => [],
            'responsive_images' => [],
        ]);

        $model->mediaFiles()->attach($media->id, ['collection' => 'main_image', 'order' => 0]);
    }
}
