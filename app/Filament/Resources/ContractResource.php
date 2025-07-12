<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractMail;


class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Select::make('customer_id')
                ->searchable()
                ->relationship('customer')
                ->getOptionLabelFromRecordUsing(fn(Customer $record) => $record->full_name)
                ->searchable(['full_name'])
                ->default(request()->has('customer_id') ? request()->get('customer_id') : null)
                ->required(),
                     Forms\Components\Section::make('Contract')
                     ->schema([
                        Forms\Components\FileUpload::make('file_path')->required(),
                          Forms\Components\Textarea::make('comments')
                     ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->sortable()
                      ->formatStateUsing(function ($record) {
                        return $record->customer->full_name;
                    })
                    ->searchable(['full_name'])->label('Customer Name'),
                       Tables\Columns\TextColumn::make('customer.email')->searchable()->label('Customer Email'),
                Tables\Columns\TextColumn::make('file_path')
                ->label('Contract')
                    ->formatStateUsing(fn() => "Download Contract")
                  ->url(fn($record) => Storage::url($record->file_path), true)
                     ->badge()
                    ->color(Color::Blue),
                Tables\Columns\TextColumn::make('comments')->searchable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\IconColumn::make('email_sent')
                //     ->boolean(),
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
                                Tables\Actions\Action::make('Send Email')
    ->label('Send Contract')
    ->icon('heroicon-o-paper-airplane')
    ->color('success')
    ->action(function ($record) {

       // Check if file exists
        if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
            Mail::to($record->customer->email)->send(new ContractMail($record));
            // $record->email_sent = true;
            // $record->save();
        }
    })->requiresConfirmation()
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
