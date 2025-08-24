<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
      protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

    if ($user->role_id == 2) {
        $data['employee_id'] = $user->id;
    }
    return $data;
    }
}
