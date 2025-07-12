<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
class QuotePdfController extends Controller
{
      public function __invoke(Request $request, Quote $quote)
    {
        $quote->load(['quoteProducts.product', 'customer']);

        $customer = new Buyer([
            'name' => $quote->customer->full_name,
            'contact'=>$quote->customer->phone_number,
            'inv_no'=>$quote->created_at->format('Y').'/'.$quote->id,
            'invoice_date'=>$quote->created_at->format('d/m/Y'),
            'contract_no'=>$quote->customer->contracts->id,
            'email'=>$quote->customer->email,
            'contract_amount'=>$quote->customer->contract_amount,
            'tax'=>($quote->customer->contract_amount*15)/100,
            'payments'=>$quote->payments,
            'totalAmount' => collect($quote->payments)->sum('amount'),
            'custom_fields' => [
                'email' => $quote->customer->email

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


             foreach ($quote->payments as $payment) {
            $items[] = (new InvoiceItem())
                ->title('title')
                ->pricePerUnit(2000)
                ->subTotalPrice(1)
                ->quantity(1);
        }

        $invoice = Invoice::make()
        ->template('invoice')

            ->sequence($quote->id)
            ->buyer($customer)
            ->taxRate($quote->taxes)
            ->totalAmount($quote->total)
            ->addItems($items)

            ->logo(public_path('vendor/invoices/logo.png'));


   return $request->has('preview') ? $invoice->stream() : $invoice->download();
    }
}
