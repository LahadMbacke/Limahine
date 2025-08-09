<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiographieResource\Pages;
use App\Models\Biographie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BiographieResource extends Resource
{
    protected static ?string $model = Biographie::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Biographie';

    protected static ?string $modelLabel = 'Personnalité';

    protected static ?string $pluralModelLabel = 'Personnalités';

    protected static ?string $navigationGroup = 'Contenu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations bibliographiques')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->helperText('Laissez vide pour générer automatiquement')
                            ->maxLength(255)
                            ->unique(Biographie::class, 'slug', ignoreRecord: true)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title.fr')
                            ->label('Titre (Français)')
                            ->required(),

                        Forms\Components\TextInput::make('title.en')
                            ->label('Titre (Anglais)'),

                        Forms\Components\TextInput::make('title.ar')
                            ->label('Titre (Arabe)'),

                        Forms\Components\TextInput::make('author_name.fr')
                            ->label('Auteur (Français)')
                            ->required(),

                        Forms\Components\TextInput::make('author_name.en')
                            ->label('Auteur (Anglais)'),

                        Forms\Components\TextInput::make('author_name.ar')
                            ->label('Auteur (Arabe)'),
                    ])->columns(2),

                Forms\Components\Section::make('Description et catégorisation')
                    ->schema([
                        Forms\Components\RichEditor::make('description.fr')
                            ->label('Description (Français)')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description.en')
                            ->label('Description (Anglais)')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description.ar')
                            ->label('Description (Arabe)')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),
                            Forms\Components\DatePicker::make('date_publication')
                            ->label('Date de publication'),

                    ])->columns(2),


                Forms\Components\Section::make('Disponibilité numérique')
                    ->schema([
                       

                        Forms\Components\FileUpload::make('cover_path')
                            ->label('Couverture')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('biographies/covers')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB max
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),

     
                    ])->columns(2),

                Forms\Components\Section::make('Publication')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié'),

                        Forms\Components\Toggle::make('featured')
                            ->label('Ouvrage vedette'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_path')
                    ->label('Couverture')
                    ->disk('public')
                    ->size(60)
                    ->circular()
                    ->defaultImageUrl(url('/assets/unnamed.jpg')),

                Tables\Columns\TextColumn::make('title.fr')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('author_name.fr')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Biographie::getTypes()[$state] ?? $state),

                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Biographie::getCategories()[$state] ?? $state),

                Tables\Columns\TextColumn::make('langue')
                    ->label('Langue'),

                Tables\Columns\IconColumn::make('disponible_en_ligne')
                    ->label('En ligne')
                    ->boolean(),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Vedette')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),

                Tables\Columns\TextColumn::make('date_publication')
                    ->label('Date de publication')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(Biographie::getTypes()),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(Biographie::getCategories()),

                Tables\Filters\Filter::make('disponible_en_ligne')
                    ->label('Disponible en ligne')
                    ->query(fn (Builder $query): Builder => $query->where('disponible_en_ligne', true)),

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
            'index' => Pages\ListBiographies::route('/'),
            'create' => Pages\CreateBiographie::route('/create'),
            'edit' => Pages\EditBiographie::route('/{record}/edit'),
        ];
    }
}
