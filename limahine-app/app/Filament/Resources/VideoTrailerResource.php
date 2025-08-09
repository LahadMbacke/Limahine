<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoTrailerResource\Pages;
use App\Filament\Resources\VideoTrailerResource\RelationManagers;
use App\Models\VideoTrailer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Str;

class VideoTrailerResource extends Resource
{
    protected static ?string $model = VideoTrailer::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Vidéo';

    protected static ?string $modelLabel = 'Trailer Vidéo';

    protected static ?string $pluralModelLabel = 'Vidéo';

    protected static ?string $navigationGroup = 'Contenu Multimédia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations de base')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title.fr')
                                    ->label('Titre (Français)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation !== 'create') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    }),

                                TextInput::make('title.en')
                                    ->label('Titre (Anglais)')
                                    ->maxLength(255),

                                TextInput::make('title.ar')
                                    ->label('Titre (Arabe)')
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),

                        Textarea::make('description.fr')
                            ->label('Description (Français)')
                            ->rows(4),

                        Textarea::make('description.en')
                            ->label('Description (Anglais)')
                            ->rows(4),

                        Textarea::make('description.ar')
                            ->label('Description (Arabe)')
                            ->rows(4),
                    ]),

                Section::make('Configuration YouTube')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('youtube_original_url')
                                    ->label('URL YouTube originale')
                                    ->required()
                                    ->url()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        // Extraire l'ID vidéo de l'URL YouTube
                                        if ($state) {
                                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $state, $matches);
                                            if (isset($matches[1])) {
                                                $set('youtube_video_id', $matches[1]);
                                            }
                                        }
                                    }),

                                TextInput::make('youtube_video_id')
                                    ->label('ID Vidéo YouTube')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('start_time')
                                    ->label('Temps de début (secondes)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Temps de début du trailer en secondes'),

                                TextInput::make('end_time')
                                    ->label('Temps de fin (secondes)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Temps de fin du trailer en secondes'),

                                TextInput::make('trailer_duration')
                                    ->label('Durée du trailer (secondes)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->helperText('Durée totale du trailer'),
                            ]),

                        TextInput::make('thumbnail_url')
                            ->label('URL miniature personnalisée')
                            ->url()
                            ->helperText('Laisser vide pour utiliser la miniature YouTube par défaut'),
                    ]),

                Section::make('Catégorisation et publication')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('category')
                                    ->label('Catégorie')
                                    ->options([
                                        'fiqh' => 'Fiqh (Jurisprudence islamique)',
                                        'tasawwuf' => 'Taṣawwuf (Éducation spirituelle)',
                                        'sira' => 'Sîra (Biographie du Prophète)',
                                        'khassaids' => 'Khassaids',
                                        'enseignements' => 'Enseignements généraux',
                                        'temoignages' => 'Témoignages',
                                    ])
                                    ->searchable(),

                                TagsInput::make('tags')
                                    ->label('Tags')
                                    ->helperText('Mots-clés pour faciliter la recherche'),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Publié')
                                    ->default(false),

                                Toggle::make('featured')
                                    ->label('En vedette')
                                    ->default(false),

                                DateTimePicker::make('published_at')
                                    ->label('Date de publication')
                                    ->helperText('Laisser vide pour une publication immédiate'),
                            ]),
                    ]),

                Section::make('SEO et métadonnées')
                    ->schema([
                        Textarea::make('meta_description.fr')
                            ->label('Meta description (Français)')
                            ->maxLength(160)
                            ->rows(2),

                        Textarea::make('meta_description.en')
                            ->label('Meta description (Anglais)')
                            ->maxLength(160)
                            ->rows(2),

                        Textarea::make('meta_description.ar')
                            ->label('Meta description (Arabe)')
                            ->maxLength(160)
                            ->rows(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('youtube_thumbnail')
                    ->label('Miniature')
                    ->getStateUsing(fn (VideoTrailer $record): string => $record->youtube_thumbnail)
                    ->size(60),

                TextColumn::make('title')
                    ->label('Titre')
                    ->getStateUsing(fn (VideoTrailer $record): string => $record->getTranslation('title', app()->getLocale()) ?? $record->getTranslation('title', 'fr'))
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fiqh' => 'success',
                        'tasawwuf' => 'info',
                        'sira' => 'warning',
                        'khassaids' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('formatted_duration')
                    ->label('Durée')
                    ->getStateUsing(fn (VideoTrailer $record): string => $record->formatted_duration),

                BooleanColumn::make('is_published')
                    ->label('Publié'),

                BooleanColumn::make('featured')
                    ->label('En vedette'),

                TextColumn::make('published_at')
                    ->label('Date de publication')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options([
                        'fiqh' => 'Fiqh',
                        'tasawwuf' => 'Taṣawwuf',
                        'sira' => 'Sîra',
                        'khassaids' => 'Khassaids',
                        'enseignements' => 'Enseignements',
                        'temoignages' => 'Témoignages',
                    ]),

                Filter::make('is_published')
                    ->label('Publié')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true)),

                Filter::make('featured')
                    ->label('En vedette')
                    ->query(fn (Builder $query): Builder => $query->where('featured', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (VideoTrailer $record): string => $record->youtube_url)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-play'),
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
            'index' => Pages\ListVideoTrailers::route('/'),
            'create' => Pages\CreateVideoTrailer::route('/create'),
            'edit' => Pages\EditVideoTrailer::route('/{record}/edit'),
        ];
    }
}
