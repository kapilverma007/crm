<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Customer;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Product;
use Filament\Forms\Components\Actions\Action;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;
      protected static ?string $label="Invoices";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('customer_id')
                ->searchable()
                ->relationship('customer',
                 modifyQueryUsing: fn ($query) => $query->whereHas('contracts') )
                ->getOptionLabelFromRecordUsing(fn(Customer $record) => $record->full_name)
                ->searchable(['full_name'])
                ->default(request()->has('customer_id') ? request()->get('customer_id') : null)
                ->required(),
           Forms\Components\TextInput::make('contract_amount')
    ->label('Contract Amount')
    ->numeric()
    ->required()
    ->default(0)
    ->afterStateHydrated(function ($set, callable $get) {
        $customer = \App\Models\Customer::find($get('customer_id'));
        if ($customer) {
            $set('contract_amount', $customer->contract_amount);
        }
    })
    ->afterStateUpdated(function ($state, callable $get) {
        $customer = \App\Models\Customer::find($get('customer_id'));
        if ($customer) {
            $customer->contract_amount = $state;
            $customer->save();
        }
    }),
  Forms\Components\Repeater::make('payments')
            ->label('Payments')
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Payment Date'),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->label('Amount'),
            ])
            ->default([])
            ->columnSpanFull(),
        ]);
}
public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            ViewEntry::make('invoice')
                ->columnSpanFull()
                ->viewData([
                    'record' => $infolist->record
                ])
                ->view('infolists.components.quote-invoice-view')
        ]);
}


public static function updateTotals(Get $get, $livewire): void
{
    // Retrieve the state path of the form. Most likely, it's `data` but could be something else.
    $statePath = $livewire->getFormStatePath();

    $products = data_get($livewire, $statePath . '.quoteProducts');
    if (collect($products)->isEmpty()) {
        return;
    }
    $selectedProducts = collect($products)->filter(fn($item) => !empty($item['product_id']) && !empty($item['quantity']));

    $prices = collect($products)->pluck('price', 'product_id');

    $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
        return $subtotal + ($prices[$product['product_id']] * $product['quantity']);
    }, 0);

    data_set($livewire, $statePath . '.subtotal', number_format($subtotal, 2, '.', ''));
    data_set($livewire, $statePath . '.total', number_format($subtotal + ($subtotal * (data_get($livewire, $statePath . '.taxes') / 100)), 2, '.', ''));
}


    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('customer.full_name')
                ->formatStateUsing(function ($record) {
                    return $record->customer->full_name;
                })
                ->searchable(['full_name'])
                ->sortable(),
                     Tables\Columns\TextColumn::make('customer.email')->label('Customer Email')
                ->searchable(['full_name'])
                ->sortable(),
            Tables\Columns\TextColumn::make('taxes')
                ->numeric()
                ->suffix('%')
                ->sortable(),
            Tables\Columns\TextColumn::make('subtotal')->label('Balance Due')
                    ->formatStateUsing(fn ($record) =>
                        number_format(($record->customer?->contract_amount ?? 0) - collect($record->payments)->sum('amount'), 2)
                    )
                ->sortable(),

            Tables\Columns\TextColumn::make('customer.contract_amount')->label('Contract Amount')
                ->numeric()
                ->money()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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
        ])

            ->recordUrl(function ($record) {
                return Pages\ViewQuote::getUrl([$record]);
            });
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
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'view' => Pages\ViewQuote::route('/{record}'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }
}
