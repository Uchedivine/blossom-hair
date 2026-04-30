<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    
    protected static ?string $navigationGroup = 'Marketing';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Details')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->uppercase()
                            ->helperText('Unique coupon code (e.g., SUMMER2024)'),
                        
                        Forms\Components\TextInput::make('description')
                            ->maxLength(255)
                            ->placeholder('e.g., Summer Sale 20% Off'),
                        
                        Forms\Components\Select::make('type')
                            ->options([
                                'percentage' => 'Percentage',
                                'fixed' => 'Fixed Amount',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),
                        
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn (Forms\Get $get) => $get('type') === 'fixed' ? '₦' : '')
                            ->suffix(fn (Forms\Get $get) => $get('type') === 'percentage' ? '%' : '')
                            ->helperText(fn (Forms\Get $get) => 
                                $get('type') === 'percentage' 
                                    ? 'Enter percentage (e.g., 10 for 10%)' 
                                    : 'Enter fixed amount in Naira'
                            ),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Usage Limits')
                    ->schema([
                        Forms\Components\TextInput::make('min_order_amount')
                            ->label('Minimum Order Amount')
                            ->numeric()
                            ->prefix('₦')
                            ->default(0.00)
                            ->minValue(0)
                            ->helperText('Minimum order value to use this coupon'),
                        
                        Forms\Components\TextInput::make('max_uses')
                            ->label('Maximum Uses')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Unlimited')
                            ->helperText('Leave empty for unlimited uses'),
                        
                        Forms\Components\TextInput::make('used_count')
                            ->label('Times Used')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Validity Period')
                    ->schema([
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Start Date')
                            ->native(false)
                            ->displayFormat('M d, Y H:i'),
                        
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiry Date')
                            ->native(false)
                            ->displayFormat('M d, Y H:i')
                            ->after('starts_at'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive coupons cannot be used'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'success',
                        'fixed' => 'info',
                    }),
                
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($record) => 
                        $record->type === 'percentage' 
                            ? $record->value . '%' 
                            : '₦' . number_format($record->value, 2)
                    )
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('usage')
                    ->label('Usage')
                    ->formatStateUsing(fn ($record) => 
                        $record->max_uses 
                            ? $record->used_count . ' / ' . $record->max_uses 
                            : $record->used_count . ' / ∞'
                    )
                    ->badge()
                    ->color(fn ($record) => 
                        $record->max_uses && $record->used_count >= $record->max_uses 
                            ? 'danger' 
                            : 'success'
                    ),
                
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->color(fn ($state) => 
                        $state && $state->isPast() ? 'danger' : 'gray'
                    ),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->color('danger'),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
