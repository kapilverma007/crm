<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use App\Models\Quote;
use Illuminate\Support\Facades\Mail;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
class QuotePdfController extends Controller
{
      public function __invoke(Request $request, Quote $quote)
    {


$quote->load(['quoteProducts.product', 'customer.customerContractField']);

$contractAmount = $quote->customer->customerContractField?->total_contract_amount ?? 0;

$customer = new Buyer([
    'name' => $quote->customer->full_name,
    'contact' => $quote->customer->phone_number,
    'inv_no' => $quote->created_at->format('Y') . '/' . $quote->id,
    'invoice_date' => $quote->created_at->format('d/m/Y'),
    'contract_no' => $quote->customer->contracts->id ?? null, // update to 'contract' if it's singular
    'email' => $quote->customer->email,
    'contract_amount' => $contractAmount,
    'tax' => ($contractAmount * 15) / 100,
    'payments' => $quote->payments,
    'totalAmount' => collect($quote->payments)->sum('amount'),
    'dueAmount' => collect($quote->payments)->sum('due_amount'),
    'description' => $quote->description,
    'custom_fields' => [
        'email' => $quote->customer->email,
    ],
]);


        $items = [];

        // foreach ($quote->quoteProducts as $product) {
        //     $items[] = (new InvoiceItem())
        //         ->title($product->product->name)
        //         ->pricePerUnit($product->price)
        //         ->subTotalPrice($product->price * $product->quantity)
        //         ->quantity($product->quantity);
        // }



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

   if ($request->has('send')) {
    // Generate random filename without .pdf
    $randomName = 'invoice_' . $quote->id . '_' . \Illuminate\Support\Str::random(6);
    $relativePath = 'invoices/' . $randomName;

    // Save invoice to storage disk "public"
    $invoice->filename($relativePath)->save('public');

    // Final file path including extension
    $pdfPath = $relativePath . '.pdf';

    // Send invoice via email
    Mail::to($quote->customer->email)->send(new InvoiceMail($pdfPath, $quote));

    // ✅ Flash a message to the session
    session()->flash('email_sent_success', 'Invoice sent successfully.');

    // ✅ Redirect back to Filament page or wherever needed
    return redirect()->route('filament.admin.resources.quotes.index');
}

// If "preview" is requested, stream it
if ($request->has('preview')) {
    return $invoice->stream();
}

// Otherwise download the invoice
return $invoice->download();

    }
}
