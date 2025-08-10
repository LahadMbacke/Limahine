<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Models\Publication;
use App\Models\User;
use App\Models\FilsCheikh;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Publications';

    protected static ?string $modelLabel = 'Publication';

    protected static ?string $pluralModelLabel = 'Publications';

    protected static ?string $navigationGroup = 'Contenu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations principales')
                    ->schema([
                        Forms\Components\TextInput::make('title.fr')
                            ->label('Titre (Français)')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('title.en')
                            ->label('Titre (Anglais)'),

                        Forms\Components\TextInput::make('title.ar')
                            ->label('Titre (Arabe)'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash']),

                        Forms\Components\Select::make('category')
                            ->label('Catégorie')
                            ->options(Publication::getCategories())
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('fils_cheikh_id')
                            ->label('Fils de Cheikh Ahmadou Bamba')
                            ->relationship('filsCheikh', 'name.fr')
                            ->searchable()
                            ->preload()
                            ->visible(fn (callable $get) => $get('category') === 'decouverte'),

                        Forms\Components\Select::make('author_id')
                            ->label('Auteur')
                            ->options(User::pluck('name', 'id'))
                            ->required()
                            ->default(1),
                    ])->columns(2),

                Forms\Components\Section::make('Contenu')
                    ->schema([
                        Forms\Components\Textarea::make('excerpt.fr')
                            ->label('Extrait (Français)')
                            ->rows(3),

                        Forms\Components\Textarea::make('excerpt.en')
                            ->label('Extrait (Anglais)')
                            ->rows(3),

                        Forms\Components\Textarea::make('excerpt.ar')
                            ->label('Extrait (Arabe)')
                            ->rows(3),

                        Forms\Components\RichEditor::make('content.fr')
                            ->label('Contenu (Français)')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content.en')
                            ->label('Contenu (Anglais)')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content.ar')
                            ->label('Contenu (Arabe)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Médias et métadonnées')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Image mise en avant')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('publications/featured')
                            ->visibility('public')
                            ->maxSize(5120),

                        Forms\Components\FileUpload::make('documents')
                            ->label('Fichiers attachés')
                            ->multiple()
                            ->disk('public')
                            ->directory('publications/documents')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain',
                                'application/rtf',
                                'application/zip',
                                'application/x-rar-compressed'
                            ])
                            ->maxSize(10240)
                            ->maxFiles(10)
                            ->helperText('Les noms de fichiers seront automatiquement nettoyés pour l\'affichage. Formats acceptés : PDF, Word, Excel, PowerPoint, TXT, RTF, ZIP, RAR (Max: 10 fichiers, 10MB chacun)'),

                        Forms\Components\Textarea::make('document_names')
                            ->label('Noms personnalisés des documents (optionnel)')
                            ->helperText('Un nom par ligne, dans l\'ordre des fichiers uploadés. Laissez vide pour utiliser les noms automatiques.')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('tags')
                            ->label('Mots-clés'),

                        Forms\Components\TextInput::make('reading_time')
                            ->label('Temps de lecture (minutes)')
                            ->numeric(),

                        Forms\Components\Textarea::make('meta_description.fr')
                            ->label('Description SEO (Français)')
                            ->rows(2),

                        Forms\Components\Textarea::make('meta_description.en')
                            ->label('Description SEO (Anglais)')
                            ->rows(2),

                        Forms\Components\Textarea::make('meta_description.ar')
                            ->label('Description SEO (Arabe)')
                            ->rows(2),
                    ]),

                Forms\Components\Section::make('Publication')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié'),

                        Forms\Components\Toggle::make('featured')
                            ->label('Article vedette'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Date de publication'),
                    ])->columns(3),
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
                    ->limit(50),

                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Publication::getCategories()[$state] ?? $state),

                Tables\Columns\TextColumn::make('filsCheikh.name.fr')
                    ->label('Fils de Cheikh')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Auteur')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Vedette')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Date de publication')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(Publication::getCategories()),

                Tables\Filters\Filter::make('is_published')
                    ->label('Publié')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true)),

                Tables\Filters\Filter::make('featured')
                    ->label('Vedette')
                    ->query(fn (Builder $query): Builder => $query->where('featured', true)),
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
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'view' => Pages\ViewPublication::route('/{record}'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
