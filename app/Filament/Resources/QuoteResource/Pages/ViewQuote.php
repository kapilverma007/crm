<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use App\Mail\InvoiceMail;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use URL;
use Filament\Notifications\Notification;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use Illuminate\Support\Facades\Mail;

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
        // Action::make('Send Invoice')
        //     ->icon('heroicon-s-document-check')
        //     ->url(URL::signedRoute('quotes.pdf', [$this->record->id,'send'=>'true']), false),
        Action::make('Send Invoice')
    ->icon('heroicon-s-document-check')
    ->label('Send Invoice')
    ->action(function ($record) {
        // Generate PDF and send email
        try {

            // Optional: trigger sending logic here manually if needed
            $signedUrl = URL::signedRoute('quotes.pdf', [$record->id, 'send' => 'true']);
            $quote=$record;
                    $contractAmount = $quote->customer->customerContractField?->total_contract_amount ?? 0;

                    $customer = new Buyer([
                        'name' => $quote->customer->full_name,
                        'contact' => $quote->customer->phone_number,
                        'inv_no' => $quote->created_at->format('Y') . '/' . $quote->id,
                        'invoice_date' => $quote->created_at->format('d/m/Y'),
                        'contract_no' => $quote->customer->contracts->id ?? null, // Adjust if this should be 'contract'
                        'email' => $quote->customer->email,
                        'contract_amount' => $contractAmount,
                        'tax' => ($contractAmount * 15) / 100,
                        'payments' => $quote->payments,
                        'totalAmount' => collect($quote->payments)->sum('amount'),
                        'description' => $quote->description,
                        'custom_fields' => [
                            'email' => $quote->customer->email,
                        ],
                    ]);

            $items = [];
            $items[] = (new InvoiceItem())
                ->title('title')
                ->pricePerUnit(2000)
                ->subTotalPrice(1)
                ->quantity(1);
        $invoice = Invoice::make()
        ->template('invoice')
            ->sequence($quote->id)
            ->buyer($customer)
            ->taxRate($quote->taxes)
            ->totalAmount($quote->total)
            ->addItems($items)

            ->logo(public_path('vendor/invoices/logo.png'));


    // Generate random filename without .pdf
    $randomName = 'invoice_' . $quote->id . '_' . \Illuminate\Support\Str::random(6);
    $relativePath = 'invoices/' . $randomName;

    // Save invoice to storage disk "public"
    $invoice->filename($relativePath)->save('public');

    // Final file path including extension
    $pdfPath = $relativePath . '.pdf';

    // Send invoice via email
    Mail::to($quote->customer->email)->send(new InvoiceMail($pdfPath, $quote));
            Notification::make()
                ->title('Invoice sent successfully.')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Failed to send invoice.')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    })
    ->color('success')


    ];
}
}
