<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\Label;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageLabelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_returns_translated_labels_in_assignment_order(): void
    {
        $product = $this->makeProduct();
        $core = $this->makeLabel(['uk' => 'Основна колекція', 'en' => 'Core Collection']);
        $limited = $this->makeLabel(['uk' => 'Лімітований випуск', 'en' => 'Limited Edition']);
        $product->labels()->sync([
            $limited->id => ['position' => 0],
            $core->id => ['position' => 1],
        ]);

        $slug = $product->translate('en')->slug;

        $en = $this->inertiaProps($this->get("/en/product/{$slug}")->assertOk())['product']['labels'];
        $this->assertSame([
            ['id' => $limited->id, 'name' => 'Limited Edition'],
            ['id' => $core->id, 'name' => 'Core Collection'],
        ], $en);

        $uk = $this->inertiaProps($this->get("/uk/product/{$slug}")->assertOk())['product']['labels'];
        $this->assertSame(['Лімітований випуск', 'Основна колекція'], array_column($uk, 'name'));
    }

    public function test_product_page_falls_back_when_label_translation_is_missing(): void
    {
        $product = $this->makeProduct();
        $label = $this->makeLabel(['en' => 'Core Collection']);
        $product->labels()->sync([$label->id => ['position' => 0]]);

        $slug = $product->translate('en')->slug;

        $uk = $this->inertiaProps($this->get("/uk/product/{$slug}")->assertOk())['product']['labels'];
        $this->assertSame(['Core Collection'], array_column($uk, 'name'));
    }

    public function test_product_without_labels_returns_empty_list(): void
    {
        $product = $this->makeProduct();

        $slug = $product->translate('en')->slug;

        $props = $this->inertiaProps($this->get("/en/product/{$slug}")->assertOk());
        $this->assertSame([], $props['product']['labels']);
    }

    private function makeProduct(): Product
    {
        $category = Category::factory()->create();
        $this->attachMainImage($category);

        $product = Product::factory()->create(['category_id' => $category->id]);
        $product->translate('en')->fill(['description' => ['type' => 'doc', 'content' => []]])->save();
        $product->translateOrNew('uk')->fill([
            'name' => 'Худі',
            'slug' => 'khudi-'.$product->id,
            'description' => ['type' => 'doc', 'content' => []],
        ]);
        $product->save();

        return $product;
    }

    /**
     * @param  array<string, string>  $names
     */
    private function makeLabel(array $names): Label
    {
        $label = new Label;
        foreach ($names as $locale => $name) {
            $label->translateOrNew($locale)->name = $name;
        }
        $label->save();

        return $label;
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
