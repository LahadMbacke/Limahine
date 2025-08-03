<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BibliographieResource\Pages;
use App\Models\Bibliographie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BibliographieResource extends Resource
{
    protected static ?string $model = Bibliographie::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Bibliographie';

    protected static ?string $modelLabel = 'Ouvrage';

    protected static ?string $pluralModelLabel = 'Ouvrages';

    protected static ?string $navigationGroup = 'Contenu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations bibliographiques')
                    ->schema([
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
                        Forms\Components\Textarea::make('description.fr')
                            ->label('Description (Français)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (Anglais)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.ar')
                            ->label('Description (Arabe)')
                            ->rows(3),

                        Forms\Components\Select::make('type')
                            ->label('Type d\'ouvrage')
                            ->options(Bibliographie::getTypes())
                            ->required(),

                        Forms\Components\Select::make('category')
                            ->label('Catégorie')
                            ->options(Bibliographie::getCategories())
                            ->required(),

                        Forms\Components\TextInput::make('langue')
                            ->label('Langue de l\'ouvrage')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Détails de publication')
                    ->schema([
                        Forms\Components\DatePicker::make('date_publication')
                            ->label('Date de publication'),

                        Forms\Components\TextInput::make('editeur')
                            ->label('Éditeur'),

                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN'),

                        Forms\Components\TextInput::make('pages')
                            ->label('Nombre de pages')
                            ->numeric(),
                    ])->columns(2),

                Forms\Components\Section::make('Disponibilité numérique')
                    ->schema([
                        Forms\Components\Toggle::make('disponible_en_ligne')
                            ->label('Disponible en ligne'),

                        Forms\Components\TextInput::make('url_telechargement')
                            ->label('URL de téléchargement')
                            ->url()
                            ->visible(fn (callable $get) => $get('disponible_en_ligne')),

                        Forms\Components\FileUpload::make('cover')
                            ->label('Couverture')
                            ->image()
                            ->imageEditor(),

                        Forms\Components\FileUpload::make('document')
                            ->label('Document PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->visible(fn (callable $get) => $get('disponible_en_ligne')),
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
                    ->formatStateUsing(fn (string $state): string => Bibliographie::getTypes()[$state] ?? $state),

                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Bibliographie::getCategories()[$state] ?? $state),

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
                    ->options(Bibliographie::getTypes()),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(Bibliographie::getCategories()),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBibliographies::route('/'),
            'create' => Pages\CreateBibliographie::route('/create'),
            'edit' => Pages\EditBibliographie::route('/{record}/edit'),
        ];
    }
}
