<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'Page';

    protected static ?string $pluralModelLabel = 'Pages';

    protected static ?string $navigationGroup = 'Site Web';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la page')
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

                        Forms\Components\Select::make('page_type')
                            ->label('Type de page')
                            ->options(Page::getPageTypes())
                            ->required(),

                        Forms\Components\TextInput::make('order')
                            ->label('Ordre d\'affichage')
                            ->numeric()
                            ->default(0),
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

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title.fr')
                            ->label('Titre SEO (Français)')
                            ->maxLength(60),

                        Forms\Components\TextInput::make('meta_title.en')
                            ->label('Titre SEO (Anglais)')
                            ->maxLength(60),

                        Forms\Components\TextInput::make('meta_title.ar')
                            ->label('Titre SEO (Arabe)')
                            ->maxLength(60),

                        Forms\Components\Textarea::make('meta_description.fr')
                            ->label('Description SEO (Français)')
                            ->rows(2)
                            ->maxLength(160),

                        Forms\Components\Textarea::make('meta_description.en')
                            ->label('Description SEO (Anglais)')
                            ->rows(2)
                            ->maxLength(160),

                        Forms\Components\Textarea::make('meta_description.ar')
                            ->label('Description SEO (Arabe)')
                            ->rows(2)
                            ->maxLength(160),
                    ])->columns(2),

                Forms\Components\Section::make('Publication')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié'),
                    ]),
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

                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->copyable()
                    ->copyMessage('URL copiée!')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('page_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Page::getPageTypes()[$state] ?? $state),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dernière modification')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('page_type')
                    ->label('Type de page')
                    ->options(Page::getPageTypes()),

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
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
