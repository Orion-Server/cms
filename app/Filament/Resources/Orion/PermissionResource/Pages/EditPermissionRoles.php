<?php

namespace App\Filament\Resources\Orion\PermissionResource\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use Filament\Support\Enums\Size;
use Illuminate\Support\Str;
use App\Services\RoleService;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Orion\PermissionResource;

class EditPermissionRoles extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static string $translateIdentifier = 'permission-roles';

    public array $roles = [];

    public array $originalRoles = [];

    public static function getNavigationLabel(): string
    {
        return __(
            sprintf('filament::resources.resources.%s.navigation_label', static::$translateIdentifier)
        );
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->load('roles');

        $data = $this->record->roles->pluck('role_name')
            ->mapWithKeys(fn ($roleName): array => [$roleName => true]
        )->toArray();

        $this->originalRoles = $data;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($this->record->id > auth()->user()->rank) {
            $this->halt();
        }

        $diff = array_diff_assoc($data, $this->originalRoles);

        $rolesToDelete = array_filter($diff, fn ($value) => $value === false);
        $rolesToAdd = array_filter($diff, fn ($value) => $value === true);

        if(!empty($rolesToDelete)) $rolesToDelete = array_keys($rolesToDelete);
        if(!empty($rolesToAdd)) $rolesToAdd = array_keys($rolesToAdd);

        $this->record->roles()->whereIn('role_name', $rolesToDelete)->delete();

        $insertData = [];

        foreach ($rolesToAdd as $roleName) {
            $insertData[] = [
                'role_name' => $roleName,
                'permission_id' => $this->record->id,
            ];
        }

        $this->record->roles()->insert($insertData);

        Notification::make()
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->title(__('filament-actions::edit.single.notifications.saved.title'))
            ->send();

        $this->halt();

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('roles')
            ->components([
                Grid::make()
                    ->columns([
                        'default' => 2
                    ])
                    ->schema(function () {
                        $policyNames = RoleService::getPoliciesRoleNames();
                        $specialPolicyNames = RoleService::getSpecialPoliciesRoleNames();

                        return collect($policyNames)->merge($specialPolicyNames)->map(function ($policyName, $policyClass) {
                            return Section::make(function () use ($policyName, $policyClass) {
                                    $sectionLabel = Str::plural(Str::slug($policyName));

                                    if($sectionLabel == 'logs-managers') {
                                        return __("filament-log-manager::translations.navigation_label");
                                    }

                                    return __("filament::resources.resources.{$sectionLabel}.plural");
                                })
                                ->columnSpan(1)
                                ->headerActions([
                                    Action::make('select_all')
                                        ->size(Size::ExtraSmall)
                                        ->icon('heroicon-o-bookmark')
                                        ->label(__('filament::resources.actions.select_all'))
                                        ->action(function() use ($policyName) {
                                            $roleNames = RoleService::getDefaultRoleNames();

                                            foreach ($roleNames as $roleName) {
                                                $this->roles["{$roleName}::{$policyName}"] = true;
                                            }
                                        }),

                                    Action::make('deselect_all')
                                        ->size(Size::ExtraSmall)
                                        ->icon('heroicon-o-bookmark-slash')
                                        ->color('danger')
                                        ->label(__('filament::resources.actions.deselect_all'))
                                        ->action(function() use ($policyName) {
                                            $roleNames = RoleService::getDefaultRoleNames();

                                            foreach ($roleNames as $roleName) {
                                                $this->roles["{$roleName}::{$policyName}"] = false;
                                            }
                                        })
                                ])
                                ->schema([
                                    Grid::make()
                                        ->columns(['default' => 1, 'xl' => 2])
                                        ->schema(function () use ($policyName, $policyClass) {
                                            $roleNames = RoleService::getDefaultRoleNames();

                                            if(RoleService::isSpecialPolicy($policyName)) {
                                                $roleNames = RoleService::getSpecialRolesFor($policyClass, 'admin');
                                            }

                                            return collect($roleNames)->map(function ($roleName) use ($policyName) {
                                                return Toggle::make("{$roleName}::{$policyName}")
                                                    ->label(__("filament::resources.roles.{$roleName}"));
                                            })->toArray();
                                        })
                                ]);
                        })->toArray();
                    })
            ]);
    }
}
