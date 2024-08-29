<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    // public static function canViewAny(): bool
    // {
    //     $user = Auth::user();

    //     // Solo los usuarios con el rol 'admin' pueden ver este recurso
    //     return $user->hasRole('admin');
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('price')->required()->numeric(),
                Forms\Components\TextInput::make('currency')->required(),
                Forms\Components\TextInput::make('tax')->required()->numeric(),
                Forms\Components\TextInput::make('manufacturing_cost')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('price')->sortable(),
                Tables\Columns\TextColumn::make('currency'),
                Tables\Columns\TextColumn::make('tax'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Solo admins pueden editar
                Tables\Actions\Action::make('buy')
                ->label('Comprar')
                ->form([
                    Select::make('currency')
                        ->options([
                            'USD' => 'USD',
                            'EUR' => 'EUR',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('quantity')
                        ->numeric()
                        ->required(),
                ])
                ->action(function (array $data, Product $record) {
                    $totalPrice = $record->price * $data['quantity'];
                    Sale::create([
                        'user_id' => auth()->id(),
                        'product_id' => $record->id,
                        'quantity' => $data['quantity'],
                        'currency' => $data['currency'],
                        'total_price' => $totalPrice,
                    ]);

                    // Mostrar notificación de éxito
                    Notification::make()
                        ->title('Compra exitosa')
                        ->body("Has comprado {$data['quantity']} unidad(es) de {$record->name}.")
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->visible(fn () => auth()->user()->role === 'buyer'), // Solo compradores pueden comprar
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->isAdmin()), // Solo admins pueden crear
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
