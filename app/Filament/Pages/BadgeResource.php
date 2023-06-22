<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use App\Services\Parsers\ExternalTextsParser;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Actions\Action as PageAction;

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

    public function create()
    {
        // image and code fields are required when creating a new badge
        if(!$this->badgeWasPreviouslyCreated && (empty($this->data['image']) || empty($this->data['code']))) {
            $this->notify('danger', __('filament::resources.notifications.badge_image_required'));
            return;
        }

        $externalTextsParser = app(ExternalTextsParser::class);

        try {
            $this->uploadBadgeImage($externalTextsParser);

            $externalTextsParser->updateNitroBadgeTexts($this->data['code'], ...$this->data['nitro']);
            $externalTextsParser->updateFlashBadgeTexts($this->data['code'], ...$this->data['flash']);
        } catch (\Throwable $exception) {
            Log::error('[ORION BADGE RESOURCE] - ERROR: ', $exception->getMessage());

            $this->notify('danger', __('filament::resources.notifications.badge_update_failed'));
            return;
        }

        $this->notify('success', __('filament::resources.notifications.badge_updated'));
    }

    protected function uploadBadgeImage(ExternalTextsParser $parser): void
    {
        if (empty($this->data['image']) || !filter_var($this->data['image'], FILTER_VALIDATE_URL)) return;

        if($this->data['image'] == $parser->getBadgeImageUrl($this->data['code'])) return;

        $gdImage = imagecreatefromstring(
            Http::get($this->data['image'])->body()
        );

        if ($gdImage === false) {
            $this->notify('danger', __('filament::resources.notifications.badge_image_upload_failed'));
            return;
        }

        $uploadPath = public_path(sprintf('%s%s%s.gif',
            rtrim(config('hotel.client.flash.relative_files_path'), '\//'),
            '/c_images/album1584/',
            $this->data['code']
        ));

        imagegif($gdImage, $uploadPath);
    }

    public function getFormActions(): array
    {
        return [
            PageAction::make('create')
                ->label(__('filament::resources.common.Update'))
                ->submit('create')
                ->icon('heroicon-o-upload')
                ->color('success'),
        ];
    }
}
