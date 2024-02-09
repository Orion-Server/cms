<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PermissionRoleSeeder extends Seeder
{
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
                    'role_name' => 'view::admin::housekeeping'
                ]);
            }

            // Administrator
            if($index === 0) {
                $roles->push([
                    'permission_id' => $permission->id,
                    'role_name' => 'view_any::admin::badge_page'
                ]);
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
            array_push($policiesException, ['cms_setting', 'emulator_setting', 'permission_role', 'writeable_box', 'navigation', 'user', 'shop_category', 'shop_product', 'user_order']);
        }

        // 'Moderator' or minor
        if($index >= 2) {
            array_push($policiesException, ['achievement', 'article', 'help_question_category', 'help_question', 'home_item', 'home_category', 'tag', 'team']);
        }

        // 'Support' or minor
        if($index === 3) {
            array_push($policiesException, ['command_log', 'ban']);
        }

        $policiesException = collect($policiesException)->flatten()->toArray();

        // Permissions below 'Support' do not have permissions on the dashboard
        if($index > 3) return;

        $allPolicies = $this->getPolicyNamesExcept($policiesException);

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
            $this->getDefaultRoleNamesForAdminPanel()
        );
    }

    private function getDefaultRoleNamesForAdminPanel(): array
    {
        return [
            'view_any::admin',
            'view::admin',
            'create::admin',
            'update::admin',
            'delete::admin',
            'delete_any::admin',
            'force_delete::admin',
            'force_delete_any::admin',
            'restore::admin',
            'restore_any::admin',
            'replicate::admin',
            'reorder::admin'
        ];
    }

    private function getPolicyNamesExcept(array $except = []): array
    {
        $policyNames = [
            'achievement',
            'article',
            'ban',
            'cms_setting',
            'command_log',
            'emulator_setting',
            'help_question_category',
            'help_question',
            'home_category',
            'home_item',
            'navigation',
            'permission_role',
            'shop_category',
            'shop_product',
            'tag',
            'team',
            'user_order',
            'user',
            'wordfilter',
            'writeable_box'
        ];

        return array_diff($policyNames, $except);
    }
}
