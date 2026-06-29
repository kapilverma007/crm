<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcessUpdateResource\Pages;
use App\Models\ProcessUpdate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use App\Models\CustomerContractField;
use Illuminate\Database\Eloquent\Builder;

class ProcessUpdateResource extends Resource
{
    protected static ?string $model = ProcessUpdate::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'Process Updates';

    protected static ?string $modelLabel = 'Process Update';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->isAdmin();

        return $form
            ->schema([
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'full_name')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Stage 1 - Registration')
                    ->schema([
                        Forms\Components\Toggle::make('stage1_registration')
                            ->label('Registration')
                            ->disabled(!$isAdmin),
                        Forms\Components\Toggle::make('stage1_payment')
                            ->label('Payment')
                            ->disabled(!$isAdmin),
                        Forms\Components\Repeater::make('stage1_entries')
                            ->label('Payment Entries')
                            ->schema([
                                Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                            ])
                            ->columns(3)
                            ->disabled(!$isAdmin)
                            ->defaultItems(0)
                            ->addActionLabel('Add More')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Stage 2 - JOL (Job Offer Letter)')
                    ->schema([
                        Forms\Components\Toggle::make('stage2_jol')
                            ->label('JOL')
                            ->disabled(!$isAdmin),
                        Forms\Components\Toggle::make('stage2_payment')
                            ->label('Payment')
                            ->disabled(!$isAdmin),
                        Forms\Components\Repeater::make('stage2_entries')
                            ->label('Payment Entries')
                            ->schema([
                                Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                            ])
                            ->columns(3)
                            ->disabled(!$isAdmin)
                            ->defaultItems(0)
                            ->addActionLabel('Add More')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Stage 3 - WP (Work Permit)')
                    ->schema([
                        Forms\Components\Toggle::make('stage3_wp')
                            ->label('Work Permit')
                            ->disabled(!$isAdmin),
                        Forms\Components\Toggle::make('stage3_payment')
                            ->label('Payment')
                            ->disabled(!$isAdmin),
                        Forms\Components\Repeater::make('stage3_entries')
                            ->label('Payment Entries')
                            ->schema([
                                Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                            ])
                            ->columns(3)
                            ->disabled(!$isAdmin)
                            ->defaultItems(0)
                            ->addActionLabel('Add More')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Stage 4 - Appointment')
                    ->schema([
                        Forms\Components\Toggle::make('stage4_appointment')
                            ->label('Appointment')
                            ->disabled(!$isAdmin),
                        Forms\Components\Toggle::make('stage4_payment')
                            ->label('Payment')
                            ->disabled(!$isAdmin),
                        Forms\Components\Repeater::make('stage4_entries')
                            ->label('Payment Entries')
                            ->schema([
                                Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                            ])
                            ->columns(3)
                            ->disabled(!$isAdmin)
                            ->defaultItems(0)
                            ->addActionLabel('Add More')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Stage 5 - Visa')
                    ->schema([
                        Forms\Components\Toggle::make('stage5_visa')
                            ->label('Visa')
                            ->disabled(!$isAdmin),
                        Forms\Components\Toggle::make('stage5_payment')
                            ->label('Payment')
                            ->disabled(!$isAdmin),
                        Forms\Components\Repeater::make('stage5_entries')
                            ->label('Payment Entries')
                            ->schema([
                                Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                            ])
                            ->columns(3)
                            ->disabled(!$isAdmin)
                            ->defaultItems(0)
                            ->addActionLabel('Add More')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isAdmin = auth()->user()->isAdmin();

        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->with(['customer.employee', 'customer.contracts', 'customer.customerContractField']);
                if (!auth()->user()->isAdmin()) {
                    $query->whereHas('customer', function ($q) {
                        $q->where('employee_id', auth()->id());
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.phone_number')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.contracts.contract_number')
                    ->label('Contract No')
                    ->formatStateUsing(fn ($state) => $state ? 'FC' . $state : '-'),
                Tables\Columns\TextColumn::make('customer.contracts.created_at')
                    ->label('Contract Date')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.employee.name')
                    ->label('Employee')
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('stage1_registration')
                    ->label('S1 Reg')
                    ->disabled(!$isAdmin),
                Tables\Columns\ToggleColumn::make('stage1_payment')
                    ->label('S1 Pay')
                    ->disabled(!$isAdmin),

                Tables\Columns\ToggleColumn::make('stage2_jol')
                    ->label('S2 JOL')
                    ->disabled(!$isAdmin),
                Tables\Columns\ToggleColumn::make('stage2_payment')
                    ->label('S2 Pay')
                    ->disabled(!$isAdmin),

                Tables\Columns\ToggleColumn::make('stage3_wp')
                    ->label('S3 WP')
                    ->disabled(!$isAdmin),
                Tables\Columns\ToggleColumn::make('stage3_payment')
                    ->label('S3 Pay')
                    ->disabled(!$isAdmin),

                Tables\Columns\ToggleColumn::make('stage4_appointment')
                    ->label('S4 Apt')
                    ->disabled(!$isAdmin),
                Tables\Columns\ToggleColumn::make('stage4_payment')
                    ->label('S4 Pay')
                    ->disabled(!$isAdmin),

                Tables\Columns\ToggleColumn::make('stage5_visa')
                    ->label('S5 Visa')
                    ->disabled(!$isAdmin),
                Tables\Columns\ToggleColumn::make('stage5_payment')
                    ->label('S5 Pay')
                    ->disabled(!$isAdmin),

                Tables\Columns\TextColumn::make('total_contract_amount')
                    ->label('Total Contract')
                    ->getStateUsing(fn (ProcessUpdate $record) => number_format((float) ($record->customer?->customerContractField?->total_contract_amount ?? 0), 2)),

                Tables\Columns\TextColumn::make('total_paid_amount')
                    ->label('Total Paid')
                    ->getStateUsing(function (ProcessUpdate $record) {
                        $total = 0;
                        foreach (['stage1_entries', 'stage2_entries', 'stage3_entries', 'stage4_entries', 'stage5_entries'] as $field) {
                            foreach ($record->$field ?? [] as $entry) {
                                $total += (float) ($entry['amount'] ?? 0);
                            }
                        }
                        return number_format($total, 2);
                    }),

                Tables\Columns\TextColumn::make('balance_amount')
                    ->label('Balance')
                    ->getStateUsing(function (ProcessUpdate $record) {
                        $contract = (float) ($record->customer?->customerContractField?->total_contract_amount ?? 0);
                        $paid = 0;
                        foreach (['stage1_entries', 'stage2_entries', 'stage3_entries', 'stage4_entries', 'stage5_entries'] as $field) {
                            foreach ($record->$field ?? [] as $entry) {
                                $paid += (float) ($entry['amount'] ?? 0);
                            }
                        }
                        return number_format($contract - $paid, 2);
                    })
                    ->color(fn (ProcessUpdate $record): string => (
                        ((float) ($record->customer?->customerContractField?->total_contract_amount ?? 0)) -
                        collect(['stage1_entries','stage2_entries','stage3_entries','stage4_entries','stage5_entries'])
                            ->flatMap(fn ($f) => $record->$f ?? [])
                            ->sum(fn ($e) => (float) ($e['amount'] ?? 0))
                    ) > 0 ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('update_stages')
                    ->label('Update')
                    ->icon('heroicon-m-pencil-square')
                    ->visible($isAdmin)
                    ->fillForm(fn (ProcessUpdate $record): array => array_merge(
                        $record->toArray(),
                        ['total_contract_amount' => $record->customer?->customerContractField?->total_contract_amount]
                    ))
                    ->form([
                        Forms\Components\Section::make('Contract Amount')
                            ->schema([
                                Forms\Components\TextInput::make('total_contract_amount')
                                    ->label('Total Contract Amount')
                                    ->numeric()
                                    ->prefix('SAR')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Section::make('Stage 1 - Registration')
                            ->schema([
                                Forms\Components\Toggle::make('stage1_registration')->label('Registration'),
                                Forms\Components\Toggle::make('stage1_payment')->label('Payment'),
                                Forms\Components\Repeater::make('stage1_entries')
                                    ->label('Payment Entries')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                        Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                        Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->addActionLabel('Add More')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Section::make('Stage 2 - JOL')
                            ->schema([
                                Forms\Components\Toggle::make('stage2_jol')->label('JOL'),
                                Forms\Components\Toggle::make('stage2_payment')->label('Payment'),
                                Forms\Components\Repeater::make('stage2_entries')
                                    ->label('Payment Entries')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                        Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                        Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->addActionLabel('Add More')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Section::make('Stage 3 - Work Permit')
                            ->schema([
                                Forms\Components\Toggle::make('stage3_wp')->label('Work Permit'),
                                Forms\Components\Toggle::make('stage3_payment')->label('Payment'),
                                Forms\Components\Repeater::make('stage3_entries')
                                    ->label('Payment Entries')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                        Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                        Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->addActionLabel('Add More')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Section::make('Stage 4 - Appointment')
                            ->schema([
                                Forms\Components\Toggle::make('stage4_appointment')->label('Appointment'),
                                Forms\Components\Toggle::make('stage4_payment')->label('Payment'),
                                Forms\Components\Repeater::make('stage4_entries')
                                    ->label('Payment Entries')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                        Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                        Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->addActionLabel('Add More')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Section::make('Stage 5 - Visa')
                            ->schema([
                                Forms\Components\Toggle::make('stage5_visa')->label('Visa'),
                                Forms\Components\Toggle::make('stage5_payment')->label('Payment'),
                                Forms\Components\Repeater::make('stage5_entries')
                                    ->label('Payment Entries')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date')->label('Date')->required(),
                                        Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->required(),
                                        Forms\Components\Select::make('payment_mode')->label('Payment Mode')->options(['BT' => 'BT', 'Ryd Cash' => 'Ryd Cash', 'Jedcash' => 'Jedcash'])->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->addActionLabel('Add More')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->action(function (ProcessUpdate $record, array $data) {
                        if (isset($data['total_contract_amount'])) {
                            CustomerContractField::updateOrCreate(
                                ['customer_id' => $record->customer_id],
                                ['total_contract_amount' => $data['total_contract_amount']]
                            );
                        }
                        unset($data['total_contract_amount']);
                        $record->update($data);
                        Notification::make()
                            ->title('Process updated successfully')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('reset')
                    ->label('Reset')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('danger')
                    ->visible($isAdmin)
                    ->requiresConfirmation()
                    ->modalHeading('Reset all stages?')
                    ->modalDescription('This will reset all stages to unchecked and clear all dates.')
                    ->action(function (ProcessUpdate $record) {
                        $record->update([
                            'stage1_registration' => false,
                            'stage1_payment' => false,
                            'stage1_date' => null,
                            'stage1_entries' => null,
                            'stage2_jol' => false,
                            'stage2_payment' => false,
                            'stage2_date' => null,
                            'stage2_entries' => null,
                            'stage3_wp' => false,
                            'stage3_payment' => false,
                            'stage3_date' => null,
                            'stage3_entries' => null,
                            'stage4_appointment' => false,
                            'stage4_payment' => false,
                            'stage4_date' => null,
                            'stage4_entries' => null,
                            'stage5_visa' => false,
                            'stage5_payment' => false,
                            'stage5_date' => null,
                            'stage5_entries' => null,
                        ]);

                        Notification::make()
                            ->title('All stages have been reset')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcessUpdates::route('/'),
            'view' => Pages\ViewProcessUpdate::route('/{record}'),
        ];
    }
}
