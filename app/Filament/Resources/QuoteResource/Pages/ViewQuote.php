<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use URL;
use Filament\Notifications\Notification;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;
    protected function getHeaderActions(): array
{
    return [
        Action::make('Edit Invoice')
            ->icon('heroicon-m-pencil-square')
            ->url(EditQuote::getUrl([$this->record])),
        Action::make('Download Invoice')
            ->icon('heroicon-s-document-check')
            ->url(URL::signedRoute('quotes.pdf', [$this->record->id]), true),
        Action::make('Send Invoice')
            ->icon('heroicon-s-document-check')
            ->url(URL::signedRoute('quotes.pdf', [$this->record->id,'send'=>'true']), false),


    ];
}
}
