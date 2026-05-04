<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'products.list', 'products.edit', 'products.delete', 'products.create',
            'categories.list', 'categories.edit', 'categories.delete', 'categories.create',
            'attributes.list', 'attributes.edit', 'attributes.delete', 'attributes.create',
            'orders.list', 'orders.view', 'orders.edit',
            'customers.list', 'customers.view',
            'payments.list', 'payments.view',
            'transactions.list', 'transactions.view',
            'payment-webhooks.list', 'payment-webhooks.view',
            'media.list', 'media.view', 'media.delete', 'media.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $contentManagerRole = Role::updateOrCreate(['name' => 'content-manager']);
        $contentManagerRole->givePermissionTo(
            [
                'products.list', 'products.edit', 'products.delete', 'products.create',
                'categories.list', 'categories.edit', 'categories.delete', 'categories.create',
                'attributes.list', 'attributes.edit', 'attributes.delete', 'attributes.create',
                'media.list', 'media.view', 'media.delete', 'media.edit',
            ]
        );

        $orderManagerRole = Role::updateOrCreate(['name' => 'order-manager']);
        $orderManagerRole->givePermissionTo(
            [
                'orders.list', 'orders.view', 'orders.edit',
                'payments.list', 'payments.view',
                'transactions.list', 'transactions.view',
                'payment-webhooks.list', 'payment-webhooks.view',
            ]
        );
    }
}
