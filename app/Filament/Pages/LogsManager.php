<?php

namespace App\Filament\Pages;

use Throwable;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use FilipFonal\FilamentLogManager\LogViewer;
use FilipFonal\FilamentLogManager\Pages\Logs;

class LogsManager extends Logs
{
    public static string $roleName = 'logs_manager';

    public static function canAccess(): bool
    {
        return auth()->user()->can("view::admin::" . static::$roleName);
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.navigations.Logs');
    }

    /**
     * Same as the parent, except a broken or unreadable log file surfaces as a
     * notification instead of a 500.
     */
    public function getLogs(): Collection
    {
        if (!$this->logFile) {
            return collect([]);
        }

        $logs = null;

        try {
            $logs = LogViewer::getAllForFile($this->logFile);
        } catch (Throwable $e) {
            Notification::make()
                ->title($e->getMessage())
                ->icon('heroicon-o-exclamation-triangle')
                ->iconColor('danger')
                ->color('danger')
                ->send();
        }

        return $logs
            ? collect($logs)
            : collect([]);
    }
}
