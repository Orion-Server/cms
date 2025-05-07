<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use App\Models\BetaCode;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\Orion\BetaCodeResource\Pages;

class BetaCodeResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = BetaCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/beta-codes';

    public static string $translateIdentifier = 'beta-codes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->default(\Str::random(60))
                    ->label(__('filament::resources.inputs.code'))
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->columnSpan('full')
                    ->maxLength(64),

                DateTimePicker::make('valid_at')
                    ->label(__('filament::resources.inputs.valid_at'))
                    ->columnSpan('full')
                    ->helperText(__('filament::resources.helpers.beta_code_data_helper'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id'),

                TextColumn::make('code')
                    ->label(__('filament::resources.columns.code'))
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('valid_at')
                    ->date('d/m/Y H:i')
                    ->label(__('filament::resources.columns.valid_at')),

                TextColumn::make('rescued_at')
                    ->date('d/m/Y H:i')
                    ->label(__('filament::resources.columns.rescued_at')),

                TextColumn::make('user.username')
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => $state ?? '-')
                    ->label(__('filament::resources.columns.username')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBetaCodes::route('/'),
        ];
    }
}
