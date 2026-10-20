<?php

namespace Tests\Feature\Catalog;

use App\Filament\Resources\Products\Pages\EditProduct;
use App\Models\Label;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductLabelAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
    }

    public function test_assigned_labels_persist_in_chosen_order(): void
    {
        $product = $this->makeProduct();
        $core = $this->makeLabel(['en' => 'Core Collection']);
        $limited = $this->makeLabel(['en' => 'Limited Edition']);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->fillForm(['labels' => [$limited->id, $core->id]])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame([$limited->id, $core->id], $product->refresh()->labels->pluck('id')->all());

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->assertFormSet(['labels' => [$limited->id, $core->id]]);
    }

    public function test_removing_label_keeps_relative_order_of_the_rest(): void
    {
        $product = $this->makeProduct();
        $first = $this->makeLabel(['en' => 'First']);
        $second = $this->makeLabel(['en' => 'Second']);
        $third = $this->makeLabel(['en' => 'Third']);
        $product->labels()->sync([
            $first->id => ['position' => 0],
            $second->id => ['position' => 1],
            $third->id => ['position' => 2],
        ]);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->fillForm(['labels' => [$first->id, $third->id]])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame([$first->id, $third->id], $product->refresh()->labels->pluck('id')->all());
    }

    public function test_label_search_matches_name_in_any_locale(): void
    {
        $product = $this->makeProduct();
        $label = $this->makeLabel(['uk' => 'Лімітований випуск', 'en' => 'Limited Edition']);
        $this->makeLabel(['uk' => 'Основна колекція', 'en' => 'Core Collection']);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->call('callSchemaComponentMethod', 'form.labels', 'getSearchResultsForJs', ['search' => 'Лімітов'])
            ->assertReturned(fn (array $results) => collect($results)->pluck('value')->all() === [$label->id]);
    }

    public function test_deleting_assigned_label_keeps_the_product(): void
    {
        $product = $this->makeProduct();
        $label = $this->makeLabel(['en' => 'Core Collection']);
        $product->labels()->sync([$label->id => ['position' => 0]]);

        $label->delete();

        $this->assertModelExists($product);
        $this->assertSame([], $product->refresh()->labels->all());
    }

    private function makeProduct(): Product
    {
        $product = Product::factory()->create();
        $product->translate('en')->fill(['description' => ['type' => 'doc', 'content' => []]])->save();

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
}
