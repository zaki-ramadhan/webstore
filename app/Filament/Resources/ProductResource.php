<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                TextInput::make('name')
                    ->label('Product Name')
                    ->trim(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->unique()
                    ->trim(),
                TextInput::make('slug')
                    ->unique()
                    ->trim(),
                TextInput::make('stock')
                    ->numeric()
                    ->trim()
                    ->default(0),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->trim(),
                TextInput::make('weight')
                    ->numeric()
                    ->suffix('gram')
                    ->trim(),
                Textarea::make('description')
                    ->minLength(5)
                    ->maxLength(255)
                    ->autosize()
                    ->columnSpanFull()
                    ->trim()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
