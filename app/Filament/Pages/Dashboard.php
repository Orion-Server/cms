<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;

class Dashboard extends FilamentDashboard
{
    protected static ?string $navigationGroup = 'Dashboard';

    protected static ?string $navigationLabel = 'Homepage';

    protected static ?string $navigationIcon = 'heroicon-o-home';
}
