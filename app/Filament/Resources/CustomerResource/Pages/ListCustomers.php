<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Customer;
use App\Models\PipelineStage;
use Filament\Resources\Components\Tab;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
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

        $tabs['my'] = Tab::make('Total Customers')
            ->badge(Customer::where('employee_id', auth()->id())->count())
            ->modifyQueryUsing(function ($query) {
                return $query->where('employee_id', auth()->id());
            });
    }

    return $tabs;
}
}
