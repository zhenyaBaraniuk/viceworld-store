<?php

namespace Tests\Feature\Catalog;

use App\Filament\Resources\Labels\LabelResource;
use App\Filament\Resources\Labels\Pages\CreateLabel;
use App\Filament\Resources\Labels\Pages\EditLabel;
use App\Filament\Resources\Labels\Pages\ListLabels;
use App\Models\Label;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LabelManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_creates_label_with_translations_and_sees_it_in_list(): void
    {
        $this->actingAsRole('admin');
        app()->setLocale('uk');

        Livewire::test(CreateLabel::class)
            ->fillForm(['name' => 'Основна колекція'])
            ->call('create')
            ->assertHasNoFormErrors();

        $label = Label::query()->sole();

        app()->setLocale('en');

        Livewire::test(EditLabel::class, ['record' => $label->getRouteKey()])
            ->fillForm(['name' => 'Core Collection'])
            ->call('save')
            ->assertHasNoFormErrors();

        $label->refresh();
        $this->assertSame('Основна колекція', $label->translate('uk')?->name);
        $this->assertSame('Core Collection', $label->translate('en')?->name);

        Livewire::test(ListLabels::class)->assertCanSeeTableRecords([$label]);
    }

    public function test_admin_edits_label_name(): void
    {
        $this->actingAsRole('admin');
        $label = $this->makeLabel(['uk' => 'Основна колекція']);

        Livewire::test(EditLabel::class, ['record' => $label->getRouteKey()])
            ->fillForm(['name' => 'Оновлена колекція'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Оновлена колекція', $label->refresh()->translated('name'));
    }

    public function test_admin_deletes_unassigned_label(): void
    {
        $this->actingAsRole('admin');
        $label = $this->makeLabel(['uk' => 'Основна колекція']);

        Livewire::test(EditLabel::class, ['record' => $label->getRouteKey()])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($label);
        Livewire::test(ListLabels::class)->assertCanNotSeeTableRecords([$label]);
    }

    public function test_user_without_label_permissions_is_denied(): void
    {
        $this->actingAsRole('order-manager');
        $label = $this->makeLabel(['uk' => 'Основна колекція']);

        $this->assertFalse(LabelResource::canViewAny());
        Livewire::test(CreateLabel::class)->assertForbidden();
        Livewire::test(EditLabel::class, ['record' => $label->getRouteKey()])->assertForbidden();
    }

    private function actingAsRole(string $role): void
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($user);
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
