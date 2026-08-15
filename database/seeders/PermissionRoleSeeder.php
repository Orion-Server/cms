<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Services\RoleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PermissionRoleSeeder extends Seeder
{
    private array $strictAdministratorPermissions = [
        'cms_setting',
        'emulator_setting',
        'writeable_box',
        'navigation',
        'user',
        'shop_category',
        'shop_product',
        'shop_order',
        'emulator_text',
        'beta_code',
    ];

    private array $strictSuperModeratorPermissions = [
        'achievement',
        'article',
        'permission',
        'help_question_category',
        'help_question',
        'home_item',
        'home_category',
        'tag',
        'team',
        'chatlog_private',
        'chatlog_room'
    ];

    private array $strictModeratorPermissions = [
        'command_log',
        'ban'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(PermissionRole::count() && !$this->command->confirm(
            'It was detected that your database already has roles, are you sure you want to generate them again?', false
        )) return;

        $this->createRoles();
    }

    private function createRoles(): void
    {
        $roles = collect();

        $allRanks = Permission::latest('id')->get();

        if($allRanks->isEmpty()) return;

        $allRanks->each(function (Permission $permission, int $index) use (&$roles) {
            $this->generateRolesForPermission($permission, $index, $roles);

            // Permission is greater than 'Moderator'
            if($index <= 3) {
                $roles->push([
                    'permission_id' => $permission->id,
                    'role_name' => 'view::admin::dashboard'
                ]);
            }

            // Administrator
            if($index === 0) {
                $roles->push(
                    ['permission_id' => $permission->id, 'role_name' => 'view::admin::badge_page'],
                    ['permission_id' => $permission->id, 'role_name' => 'view::admin::logs_manager'],
                    ['permission_id' => $permission->id, 'role_name' => 'view::admin::permission_roles']
                );
            }
        });

        try {
            PermissionRole::insert($roles->toArray());

            $this->command->info('Permission roles seeded successfully.');
        } catch (\Throwable $error) {
            Log::error('[PERMISSION ROLES] Failed to seed permission roles.'. [
                'error' => $error->getMessage()
            ]);

            $this->command->error('Permission roles seeding failed!');
        }
    }

    private function generateRolesForPermission(Permission $permission, int $index, Collection &$roles): void
    {
        $policiesException = [];

        // 'Super Mod' or minor
        if($index >= 1) {
            array_push($policiesException, $this->strictAdministratorPermissions);
        }

        // 'Moderator' or minor
        if($index >= 2) {
            array_push($policiesException, $this->strictSuperModeratorPermissions);
        }

        // 'Support' or minor
        if($index === 3) {
            array_push($policiesException, $this->strictModeratorPermissions);
        }

        $policiesException = collect($policiesException)->flatten()->toArray();

        // Permissions below 'Support' do not have permissions on the dashboard
        if($index > 3) return;

        $allPolicies = array_diff(
            RoleService::getPoliciesRoleNamesForSeeder(),
            $policiesException
        );

        if(empty($allPolicies)) return;

        collect($allPolicies)->each(function (string $policyName) use ($permission, &$roles) {
            $roleNames = $this->getRoleNames($policyName);

            if(empty($roleNames)) return;

            collect($roleNames)->each(function (string $roleName) use ($permission, &$roles) {
                $roles->push([
                    'permission_id' => $permission->id,
                    'role_name' => $roleName
                ]);
            });
        });
    }

    private function getRoleNames(string $key): array
    {
        return array_map(
            fn (string $role): string => "{$role}::{$key}",
            RoleService::getDefaultRoleNames(panel: 'admin')
        );
    }
}
