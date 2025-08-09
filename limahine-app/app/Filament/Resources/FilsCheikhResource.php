<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilsCheikhResource\Pages;
use App\Filament\Resources\FilsCheikhResource\RelationManagers;
use App\Models\FilsCheikh;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FilsCheikhResource extends Resource
{
    protected static ?string $model = FilsCheikh::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Fils de Cheikh Ahmadou Bamba';

    protected static ?string $modelLabel = 'Fils de Cheikh';

    protected static ?string $pluralModelLabel = 'Fils de Cheikh Ahmadou Bamba';

    protected static ?string $navigationGroup = 'Découverte';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations principales')
                    ->schema([
                        Forms\Components\TextInput::make('name.fr')
                            ->label('Nom (Français)')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

                        Forms\Components\TextInput::make('name.en')
                            ->label('Nom (Anglais)'),

                        Forms\Components\TextInput::make('name.ar')
                            ->label('Nom (Arabe)'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash']),

                        Forms\Components\Toggle::make('is_khalif')
                            ->label('Khalif')
                            ->live(),

                        Forms\Components\TextInput::make('order_of_succession')
                            ->label('Ordre de succession')
                            ->numeric()
                            ->visible(fn (callable $get) => $get('is_khalif')),
                    ])->columns(2),

                Forms\Components\Section::make('Dates importantes')
                    ->schema([
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Date de naissance'),

                        Forms\Components\DatePicker::make('death_date')
                            ->label('Date de décès'),
                    ])->columns(2),

                Forms\Components\Section::make('Photo de couverture')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')
                            ->label('Image de couverture')
                            ->collection('cover_image')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Portrait')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('portrait')
                            ->label('Photo portrait')
                            ->collection('portrait')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '3:4',
                                '1:1',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Description et biographie')
                    ->schema([
                        Forms\Components\Textarea::make('description.fr')
                            ->label('Description courte (Français)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.en')
                            ->label('Description courte (Anglais)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.ar')
                            ->label('Description courte (Arabe)')
                            ->rows(3),

                        Forms\Components\RichEditor::make('biography.fr')
                            ->label('Biographie (Français)')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('biography.en')
                            ->label('Biographie (Anglais)')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('biography.ar')
                            ->label('Biographie (Arabe)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('SEO et publication')
                    ->schema([
                        Forms\Components\Textarea::make('meta_description.fr')
                            ->label('Description SEO (Français)')
                            ->rows(2),

                        Forms\Components\Textarea::make('meta_description.en')
                            ->label('Description SEO (Anglais)')
                            ->rows(2),

                        Forms\Components\Textarea::make('meta_description.ar')
                            ->label('Description SEO (Arabe)')
                            ->rows(2),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_image')
                    ->label('Couverture')
                    ->collection('cover_image')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('name.fr')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_khalif')
                    ->label('Khalif')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('order_of_succession')
                    ->label('Ordre')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Naissance')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('death_date')
                    ->label('Décès')
                    ->date()
                    ->sortable()
                    ->placeholder('Vivant'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),

                Tables\Columns\TextColumn::make('publications_count')
                    ->label('Publications')
                    ->counts('publications')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_khalif')
                    ->label('Khalifs seulement')
                    ->query(fn (Builder $query): Builder => $query->where('is_khalif', true)),

                Tables\Filters\Filter::make('is_published')
                    ->label('Publié')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true)),

                Tables\Filters\Filter::make('alive')
                    ->label('Vivants')
                    ->query(fn (Builder $query): Builder => $query->whereNull('death_date')),
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
            ->defaultSort('order_of_succession', 'asc');
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
            'index' => Pages\ListFilsCheikhs::route('/'),
            'create' => Pages\CreateFilsCheikh::route('/create'),
            'view' => Pages\ViewFilsCheikh::route('/{record}'),
            'edit' => Pages\EditFilsCheikh::route('/{record}/edit'),
        ];
    }
}
