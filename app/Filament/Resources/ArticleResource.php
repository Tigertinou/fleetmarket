<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select, MarkdownEditor, Textarea, FileUpload, Hidden};

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('article_category_id')
                ->relationship('category', 'title')
                ->required(),

            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Str::slug($state))),

            TextInput::make('slug')
                ->disabled()
                ->required(),

            TextInput::make('meta')->maxLength(255),

            Textarea::make('excerpt')->rows(3),

            MarkdownEditor::make('content')->columnSpanFull(),

            FileUpload::make('images')
                ->multiple()
                ->reorderable()
                ->preserveFilenames()
                ->directory('articles/images')
                ->disk('s3'),

            Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'online' => 'Online',
                    'offline' => 'Offline',
                ])
                ->default('draft'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
