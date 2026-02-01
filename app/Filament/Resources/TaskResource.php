<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Customer;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DateTimePicker;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
          ->schema([
        Forms\Components\Select::make('customer_id')
            ->searchable()
            ->relationship('customer')
            ->getOptionLabelFromRecordUsing(fn(Customer $record) => $record->full_name )
            ->searchable(['full_name'])
            ->required(),
        Forms\Components\Select::make('user_id')
            ->preload()
            ->searchable()
            ->relationship('employee', 'name')
           ->hidden(fn () => !auth()->user()->isAdmin()),

        Forms\Components\RichEditor::make('description')
            ->required()
            ->maxLength(65535)
            ->columnSpanFull(),
        // Forms\Components\DateTimePicker::make('due_date'),
        DateTimePicker::make('due_date')
    ->label('Due Date & Time')
    ->required()
    ->seconds(false) // Set to true if you want seconds as well
    ->displayFormat('d M Y h:i A'), // For user-friendly display
   
        Forms\Components\Toggle::make('is_completed')
            ->required(),
    ]);
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
              Tables\Columns\TextColumn::make('customer.phone_number')
            ->formatStateUsing(function ($record) {
                return $record->customer->phone_number;
            })
            ->searchable(['phone_number'])
            ->sortable(),
             Tables\Columns\TextColumn::make('customer.email')
            ->formatStateUsing(function ($record) {
                return $record->customer->email;
            })
            ->searchable(['email'])
            ->sortable(),
        Tables\Columns\TextColumn::make('employee.name')
            ->label('Employee')
            ->searchable()
            ->sortable(),
        Tables\Columns\TextColumn::make('description')
            ->html()
            ->wrap(),
        Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->label('Creation Date'),
        Tables\Columns\TextColumn::make('due_date')
             ->dateTime('d M Y h:i A')
            ->sortable(),
        Tables\Columns\IconColumn::make('is_completed')
            ->boolean(),
     
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
        Tables\Actions\Action::make('Complete')
            ->hidden(fn(Task $record) => $record->is_completed)
            ->icon('heroicon-m-check-badge')
            ->modalHeading('Mark task as completed?')
            ->modalDescription('Are you sure you want to mark this task as completed?')
            ->action(function (Task $record) {
                $record->is_completed = true;
                $record->save();

                Notification::make()
                    ->title('Task marked as completed')
                    ->success()
                    ->send();
            })
    ])
    ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
        ]),
    ])
->defaultSort(function ($query) {
    return $query
        ->orderByRaw("
            CASE 
                WHEN due_date IS NULL THEN 4
                WHEN due_date >= CURDATE() AND MONTH(due_date) = MONTH(CURDATE()) AND YEAR(due_date) = YEAR(CURDATE()) THEN 1
                WHEN due_date > CURDATE() THEN 2
                ELSE 3
            END
        ")
        ->orderBy('due_date', 'asc') // earliest first within each group
        ->orderBy('id', 'desc');
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
