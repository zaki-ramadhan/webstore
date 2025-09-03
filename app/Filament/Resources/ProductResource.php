<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // main cover
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->columnSpanFull(),

                // other / secondary images
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->multiple()
                    ->panelLayout('grid')
                    ->columnSpanFull(),

                // tags input for product
                SpatieTagsInput::make('tags')
                    ->type('category')
                    ->label('Category')
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->label('Product Name'),
                TextInput::make('sku')
                    ->label('SKU')
                    ->unique(ignoreRecord:true), // if the value is not changed, then don't make it unique, so other input values can updated without getting error of unique input value
                TextInput::make('slug')
                    ->unique(ignoreRecord:true),
                TextInput::make('stock')
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('weight')
                    ->numeric()
                    ->suffix('gram'),
                Textarea::make('description')
                    ->minLength(5)
                    ->maxLength(255)
                    ->autosize()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('sku'),
                TextColumn::make('slug'),
                TextColumn::make('stock'),
                TextColumn::make('price')
                    ->money('IDR', locale: 'id'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
