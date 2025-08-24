<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListContracts extends ListRecords
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

     protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        $user = Auth::user();
        // If the user is not an admin (role_id != 1), only show their contracts
        if ($user->role_id == 2) {
                   $customerIds = \App\Models\Customer::where('employee_id', $user->id)->pluck('id');

            // Return only contracts related to those customers
            return parent::getTableQuery()->whereIn('customer_id', $customerIds)->orderByDesc('id');
        }

        return $query->orderByDesc('id');
    }
}
