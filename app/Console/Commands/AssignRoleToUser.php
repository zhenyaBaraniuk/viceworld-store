<?php

namespace App\Console\Commands;

use function Laravel\Prompts\select;
use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\User;

class AssignRoleToUser extends Command
{
    protected $signature = 'user:assign-role {email : user email}';

    protected $description = 'Command assign role to user';

    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found");

            return Command::FAILURE;
        }

        $roles = Role::query()->pluck('name')->toArray();

        $role = select(
            label: 'Оберіть роль',
            options: $roles,
        );

        $user->assignRole($role);

        $this->info("Role {$role} assigned to {$email} successfully!");

        return Command::SUCCESS;
    }
}
