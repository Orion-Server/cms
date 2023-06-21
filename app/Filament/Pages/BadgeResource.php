<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Traits\TranslatableResource;
use Filament\Forms\Concerns\InteractsWithForms;

class BadgeResource extends Page
{
    use TranslatableResource, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Hotel';

    protected static string $translateIdentifier = 'badge-resource';

    protected static string $view = 'filament.pages.badge-resource';

    public $code;

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('code')
                        ->label(__('filament::resources.inputs.badge_code'))
                        ->prefixAction(fn (?string $state): Action =>
                                Action::make('visit')
                                    ->icon('heroicon-s-search')
                                    ->action(function () use ($state) {
                                        dd($state);
                                    }),
                            )
                        ->placeholder('...')
                ])
        ];
    }

    public function submit()
    {
        dd('oi');
    }
}
