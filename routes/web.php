<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\QuotePdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     return redirect()->route('filament.admin.auth.login');
});
Route::middleware('signed')
    ->get('quotes/{quote}/pdf', QuotePdfController::class)
    ->name('quotes.pdf');


    Route::get('/contracts/generate/{userId}', [ContractController::class, 'generate'])
    ->name('contracts.generate');
