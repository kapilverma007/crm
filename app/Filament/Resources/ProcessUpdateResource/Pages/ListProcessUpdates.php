<?php

namespace App\Filament\Resources\ProcessUpdateResource\Pages;

use App\Filament\Resources\ProcessUpdateResource;
use App\Models\Contract;
use App\Models\ProcessUpdate;
use Filament\Resources\Pages\ListRecords;

class ListProcessUpdates extends ListRecords
{
    protected static string $resource = ProcessUpdateResource::class;

    public function mount(): void
    {
        parent::mount();

        // Auto-create ProcessUpdate records for all contracts that don't have one yet
        $customerIdsWithProcess = ProcessUpdate::pluck('customer_id');
        $contractsWithoutProcess = Contract::whereNotIn('customer_id', $customerIdsWithProcess)->get();

        foreach ($contractsWithoutProcess as $contract) {
            ProcessUpdate::create([
                'customer_id' => $contract->customer_id,
            ]);
        }
    }
}
