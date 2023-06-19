<?php

namespace App\Filament\Pages;

use App\Filament\Traits\TranslatableResource;
use Filament\Pages\Dashboard as FilamentDashboard;

class Dashboard extends FilamentDashboard
{
    use TranslatableResource;

    protected static ?string $navigationGroup = 'Dashboard';

    protected static ?string $navigationLabel = 'Homepage';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static string $translateIdentifier = 'dashboard';
}
