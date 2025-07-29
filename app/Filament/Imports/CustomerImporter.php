<?php

namespace App\Filament\Imports;

use App\Models\Customer;
use App\Models\LeadSource;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Container\Attributes\Log;

class CustomerImporter extends Importer
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('full_name')
            ->rules(['max:255']),
            ImportColumn::make('email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('phone_number')
                ->rules(['max:255']),
            ImportColumn::make('city')
                ->rules(['max:255']),
            ImportColumn::make('platform')
            ->requiredMapping()
            ->fillRecordUsing(function ($record, string $state): void {
                // $state === the cell value from the CSV
                $state=strtoupper($state);
                $record->lead_source_id = LeadSource::query()
                    ->where('name', $state)
                    ->value('id');   // returns null if not found
            }),
        ];
    }



    public function resolveRecord(): ?Customer
    {
        // return Customer::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Customer();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your customer import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

protected function afterFill(): void
{
    if (empty($this->record->full_name)) {
        $row = $this->originalData;

        $firstName = $row['First name'] ?? $row['firstname'] ?? '';
        $lastName  = $row['Last name']  ?? $row['lastname']  ?? '';

        $this->record->full_name = trim("{$firstName} {$lastName}");
    }
}

}
