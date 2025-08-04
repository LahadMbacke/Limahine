<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemoignageResource\Pages;
use App\Models\Temoignage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TemoignageResource extends Resource
{
    protected static ?string $model = Temoignage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationLabel = 'Témoignages';

    protected static ?string $modelLabel = 'Témoignage';

    protected static ?string $pluralModelLabel = 'Témoignages';

    protected static ?string $navigationGroup = 'Contenu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du témoignage')
                    ->schema([
                        Forms\Components\TextInput::make('title.fr')
                            ->label('Titre (Français)')
                            ->required(),

                        Forms\Components\TextInput::make('title.en')
                            ->label('Titre (Anglais)'),

                        Forms\Components\TextInput::make('title.ar')
                            ->label('Titre (Arabe)'),

                        Forms\Components\TextInput::make('author_name')
                            ->label('Nom du témoin')
                            ->required(),

                        Forms\Components\TextInput::make('author_title.fr')
                            ->label('Titre/Fonction (Français)'),

                        Forms\Components\TextInput::make('author_title.en')
                            ->label('Titre/Fonction (Anglais)'),

                        Forms\Components\TextInput::make('author_title.ar')
                            ->label('Titre/Fonction (Arabe)'),
                    ])->columns(2),

                Forms\Components\Section::make('Contenu du témoignage')
                    ->schema([
                        Forms\Components\Textarea::make('author_description.fr')
                            ->label('Description du témoin (Français)')
                            ->rows(2),

                        Forms\Components\Textarea::make('author_description.en')
                            ->label('Description du témoin (Anglais)')
                            ->rows(2),

                        Forms\Components\Textarea::make('author_description.ar')
                            ->label('Description du témoin (Arabe)')
                            ->rows(2),

                        Forms\Components\RichEditor::make('content.fr')
                            ->label('Témoignage (Français)')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content.en')
                            ->label('Témoignage (Anglais)')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content.ar')
                            ->label('Témoignage (Arabe)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Informations complémentaires')
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->label('Lieu'),

                        Forms\Components\DatePicker::make('date_temoignage')
                            ->label('Date du témoignage'),

                        Forms\Components\FileUpload::make('author_photo')
                            ->label('Photo du témoin')
                            ->image()
                            ->imageEditor(),

                        Forms\Components\Textarea::make('meta_description.fr')
                            ->label('Description SEO (Français)')
                            ->rows(2),
                    ])->columns(2),

                Forms\Components\Section::make('Publication')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié'),

                        Forms\Components\Toggle::make('featured')
                            ->label('Témoignage vedette'),

                        Forms\Components\Toggle::make('verified')
                            ->label('Témoignage vérifié'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Date de publication'),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.fr')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Témoin')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lieu')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_temoignage')
                    ->label('Date du témoignage')
                    ->date()
                    ->sortable(),

                Tables\Columns\IconColumn::make('verified')
                    ->label('Vérifié')
                    ->boolean(),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Vedette')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label('Vérifiés')
                    ->query(fn (Builder $query): Builder => $query->where('verified', true)),

                Tables\Filters\Filter::make('featured')
                    ->label('Vedette')
                    ->query(fn (Builder $query): Builder => $query->where('featured', true)),

                Tables\Filters\Filter::make('is_published')
                    ->label('Publié')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemoignages::route('/'),
            'create' => Pages\CreateTemoignage::route('/create'),
            'edit' => Pages\EditTemoignage::route('/{record}/edit'),
        ];
    }
}
