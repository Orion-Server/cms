<?php

namespace App\Services;

use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use App\Filament\Pages\BadgePage;
use App\Filament\Pages\Dashboard;
use Illuminate\Support\Collection;
use App\Filament\Pages\LogsManager;

class RoleService
{
    public static function getPoliciesRoleNames(): Collection
    {
        $resources = collect(Filament::getResources());

        foreach (Filament::getPanels() as $panel) {
            $resources = $resources->merge($panel->getResources());
        }

        return collect($resources)
            ->map(fn ($value, $resource) => match (true) {
                $resource instanceof Page => $resource::$roleName,
                default => Str::replace(['_resource', '.php'], '', Str::snake(class_basename($resource)))
            });
    }

    public static function getSpecialPoliciesRoleNames(): Collection
    {
        return collect([
            Dashboard::class => Dashboard::$roleName,
            BadgePage::class => BadgePage::$roleName,
            LogsManager::class => LogsManager::$roleName
        ]);
    }

    public static function isSpecialPolicy(string $policyName): bool
    {
        return self::getSpecialPoliciesRoleNames()->contains($policyName);
    }

    public static function getSpecialRolesFor(string $policyClass, string $panel): array
    {
        return match ($policyClass) {
            Dashboard::class,
            BadgePage::class,
            LogsManager::class => [
                "view::{$panel}"
            ],
            default => []
        };
    }

    public static function getPoliciesRoleNamesForSeeder(): array
    {
        return array_values(self::getPoliciesRoleNames()->toArray());
    }

    public static function getDefaultRoleNames(string $panel = 'admin'): array
    {
        return [
            "view_any::{$panel}",
            "view::{$panel}",
            "create::{$panel}",
            "update::{$panel}",
            "delete::{$panel}",
            "delete_any::{$panel}",
            "force_delete::{$panel}",
            "force_delete_any::{$panel}",
            "restore::{$panel}",
            "restore_any::{$panel}",
            "replicate::{$panel}",
            "reorder::{$panel}"
        ];
    }
}
