<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    
    protected static ?string $navigationGroup = 'Sales';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->relationship('order', 'order_number')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Order'),
                        
                        Forms\Components\Select::make('gateway')
                            ->options([
                                'paystack' => 'Paystack',
                                'stripe' => 'Stripe',
                                'manual' => 'Manual/Bank Transfer',
                            ])
                            ->required()
                            ->native(false),
                        
                        Forms\Components\TextInput::make('gateway_reference')
                            ->label('Gateway Reference')
                            ->maxLength(255)
                            ->placeholder('Transaction reference from payment gateway'),
                        
                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->prefix('₦')
                            ->minValue(0)
                            ->step(0.01),
                        
                        Forms\Components\TextInput::make('currency')
                            ->required()
                            ->maxLength(255)
                            ->default('NGN')
                            ->disabled()
                            ->dehydrated(),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->required()
                            ->native(false),
                        
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Payment Date')
                            ->native(false)
                            ->displayFormat('M d, Y H:i'),
                        
                        Forms\Components\Textarea::make('gateway_response')
                            ->label('Gateway Response (JSON)')
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText('Full response from payment gateway'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Order')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('gateway')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paystack' => 'success',
                        'stripe' => 'info',
                        'manual' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('gateway_reference')
                    ->label('Reference')
                    ->searchable()
                    ->copyable()
                    ->placeholder('—'),
                
                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn ($state) => '₦' . number_format($state, 2))
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Payment Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->placeholder('—'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gateway')
                    ->options([
                        'paystack' => 'Paystack',
                        'stripe' => 'Stripe',
                        'manual' => 'Manual/Bank Transfer',
                    ]),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->multiple(),
                
                Tables\Filters\Filter::make('paid_at')
                    ->form([
                        Forms\Components\DatePicker::make('paid_from')
                            ->label('Paid From'),
                        Forms\Components\DatePicker::make('paid_until')
                            ->label('Paid Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['paid_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('paid_at', '>=', $date),
                            )
                            ->when(
                                $data['paid_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('paid_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('viewResponse')
                    ->label('View Response')
                    ->icon('heroicon-o-document-text')
                    ->modalContent(fn (Payment $record) => view('filament.modals.payment-response', ['response' => $record->gateway_response]))
                    ->modalSubmitAction(false)
                    ->color('info'),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view' => Pages\ViewPayment::route('/{record}'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
