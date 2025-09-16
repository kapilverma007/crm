<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Customer;
use App\Models\PipelineStage;
use App\Models\User;
use Filament\Resources\Components\Tab;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

                Actions\Action::make('Assign Lead')
                    ->hidden(!auth()->user()->isAdmin())
                    ->icon('heroicon-m-pencil-square')
                    ->form([
                        Forms\Components\Select::make('employee_id')
                            ->label('Choose Employee')
                            ->options(User::where('role_id',2)->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->multiple()
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                        ->label('Number of Lead Assign')
                                ->integer()
                                ->required()
                    ])
             ->action(function (array $data) {
    $employeeIds = (array) $data['employee_id']; // Ensure it's an array
    $quantity = (int) $data['quantity'];

    if ($quantity > 0 && count($employeeIds) > 0) {
        // Fetch unassigned customers
        $unassignedCustomers = Customer::whereNull('employee_id')->limit($quantity)->get();

        if(  $unassignedCustomers->isNotEmpty() ){
    // Round-robin distribute if multiple employees selected
        $i = 0;
        foreach ($unassignedCustomers as $customer) {
            $employeeId = $employeeIds[$i % count($employeeIds)];
            $customer->employee_id = $employeeId;
            $customer->save();

            $i++;
        }

        Notification::make()
            ->title('Leads Assigned Successfully')
            ->success()
            ->send();
        }else{
             Notification::make()
            ->title('All Leads are assigned already !!')
            ->danger()
            ->send();
        }


    } else {
        Notification::make()
            ->title('No customers available or invalid input')
            ->danger()
            ->send();
    }
}),

        ];
    }
    public function getTabs(): array
{
    $tabs = [];

    // Check if user is admin
    if (auth()->user()->isAdmin()) {
        // Admin sees all tabs

        // 'All Customers' tab
        $tabs['all'] = Tab::make('All Customers')
            ->badge(Customer::count());

        // All pipeline stages
        $pipelineStages = PipelineStage::orderBy('position')->withCount('customers')->get();

        foreach ($pipelineStages as $pipelineStage) {
            $tabs[str($pipelineStage->name)->slug()->toString()] = Tab::make($pipelineStage->name)
                ->badge($pipelineStage->customers_count)
                ->modifyQueryUsing(function ($query) use ($pipelineStage) {
                    return $query->where('pipeline_stage_id', $pipelineStage->id);
                });
        }

        // Archived tab
        $tabs['archived'] = Tab::make('Archived')
            ->badge(Customer::onlyTrashed()->count())
            ->modifyQueryUsing(function ($query) {
                return $query->onlyTrashed();
            });

    } else {
        // Non-admin sees only their own customers

        // $tabs['my'] = Tab::make('Total Customers')
        //     ->badge(Customer::where('employee_id', auth()->id())->count())
        //     ->modifyQueryUsing(function ($query) {
        //         return $query->where('employee_id', auth()->id());
        //     });

      $userId = auth()->id();

    // 'All Customers' tab (for this employee only)
    $tabs['all'] = Tab::make('All Customers')
        ->badge(Customer::where('employee_id', $userId)->count())
        ->modifyQueryUsing(function ($query) use ($userId) {
            return $query->where('employee_id', $userId);
        });

    // Pipeline stages with customers count only for this employee
    $pipelineStages = PipelineStage::orderBy('position')->get();

    foreach ($pipelineStages as $pipelineStage) {
        $count = Customer::where('pipeline_stage_id', $pipelineStage->id)
            ->where('employee_id', $userId)
            ->count();

        $tabs[str($pipelineStage->name)->slug()->toString()] = Tab::make($pipelineStage->name)
            ->badge($count)
            ->modifyQueryUsing(function ($query) use ($pipelineStage, $userId) {
                return $query->where('pipeline_stage_id', $pipelineStage->id)
                             ->where('employee_id', $userId);
            });
    }

    // Archived tab (only employee's archived customers)
    $archivedCount = Customer::onlyTrashed()
        ->where('employee_id', $userId)
        ->count();

    $tabs['archived'] = Tab::make('Archived')
        ->badge($archivedCount)
        ->modifyQueryUsing(function ($query) use ($userId) {
            return $query->onlyTrashed()->where('employee_id', $userId);
        });
    }

    return $tabs;
}
}
