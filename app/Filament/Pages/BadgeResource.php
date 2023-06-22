<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use App\Services\Parsers\ExternalTextsParser;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;

class BadgeResource extends Page
{
    use TranslatableResource, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Hotel';

    protected static string $translateIdentifier = 'badge-resource';

    protected static string $view = 'filament.pages.badge-resource';

    public $data;

    public $badgeWasPreviouslyCreated;

    protected function getTitle(): string
    {
        return __(
            sprintf('filament::resources.resources.%s.navigation_label', static::$translateIdentifier)
        );
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('code')
                        ->label(__('filament::resources.inputs.badge_code'))
                        ->placeholder('...')
                        ->autocomplete()
                        ->helperText(__('filament::resources.helpers.badge_code_helper'))
                        ->suffixAction(
                            fn (?string $state): Action =>
                            Action::make('search')
                                ->icon('heroicon-s-search')
                                ->action(fn () => $this->searchBadgesByCode($state)),
                        ),

                    TextInput::make('image')
                        ->label(__('filament::resources.inputs.badge_image'))
                        ->placeholder('...')
                        ->autocomplete()
                        ->visible(fn () => isset($this->data['image']))
                        ->prefixAction(
                            fn (?string $state): Action =>
                            Action::make('visit')
                                ->icon('heroicon-s-external-link')
                                ->tooltip(__('filament::resources.common.Open link'))
                                ->url($state)
                                ->visible(fn () => !empty($state))
                                ->openUrlInNewTab(),
                        )
                ]),

            Section::make('Nitro Texts')
                ->description('Test')
                ->collapsible()
                ->visible(fn () => isset($this->data['nitro']))
                ->schema([
                    TextInput::make('nitro.title')
                        ->label(__('filament::resources.inputs.badge_title'))
                        ->placeholder('...')
                        ->visible(fn () => isset($this->data['nitro']['title']) ?? false),

                    TextInput::make('nitro.description')
                        ->label(__('filament::resources.inputs.badge_description'))
                        ->placeholder('...')
                        ->visible(fn () => isset($this->data['nitro']['description']) ?? false),
                ]),

            Section::make('Flash Texts')
                ->description('Test')
                ->collapsible()
                ->visible(fn () => isset($this->data['flash']))
                ->schema([
                    TextInput::make('flash.title')
                        ->label(__('filament::resources.inputs.badge_title'))
                        ->placeholder('...')
                        ->visible(fn () => isset($this->data['flash']['title']) ?? false),

                    TextInput::make('flash.description')
                        ->label(__('filament::resources.inputs.badge_description'))
                        ->placeholder('...')
                        ->visible(fn () => isset($this->data['flash']['description']) ?? false),
                ])

        ];
    }

    private function searchBadgesByCode(?string $badgeCode): void
    {
        if (empty($badgeCode)) {
            $this->notify('danger', __('filament::resources.notifications.badge_code_required'));
            return;
        }

        $badgeData = app(ExternalTextsParser::class)->getBadgeData($badgeCode);
        $this->badgeWasPreviouslyCreated = is_array($badgeData['nitro']) || is_array($badgeData['flash']);

        if ($this->badgeWasPreviouslyCreated) {
            $this->notify('success', __('filament::resources.notifications.badge_found'));

            $this->data = [
                'code' => $badgeCode,
                ...$this->getDefaultDataBehavior(
                    $badgeData['image'] ?? null,
                    $badgeData['nitro']['title'] ?? null,
                    $badgeData['nitro']['description'] ?? null,
                    $badgeData['flash']['title'] ?? null,
                    $badgeData['flash']['description'] ?? null
                )
            ];

            return;
        }

        $this->data = [
            'code' => $badgeCode,
            ...$this->getDefaultDataBehavior()
        ];
    }

    private function getDefaultDataBehavior(
        ?string $badgeImageUrl = null,
        ?string $nitroTitle = null,
        ?string $nitroDesc = null,
        ?string $flashTitle = null,
        ?string $flashDesc = null
    ): array {
        return [
            'image' => $badgeImageUrl ?? '',
            'nitro' => [
                'title' => $nitroTitle ?? '',
                'description' => $nitroDesc ?? ''
            ],
            'flash' => [
                'title' => $flashTitle ?? '',
                'description' => $flashDesc ?? ''
            ]
        ];
    }

    public function submit()
    {

    }

    public function getButtonLabel(): string
    {
        return $this->badgeWasPreviouslyCreated ? __('filament::resources.common.Update') : __('filament::resources.common.Create');
    }

    public function getButtonColor(): string
    {
        return $this->badgeWasPreviouslyCreated ? 'primary' : 'success';
    }

    public function getButtonIcon(): string
    {
        return $this->badgeWasPreviouslyCreated ? 'heroicon-o-check' : 'heroicon-o-upload';
    }
}
