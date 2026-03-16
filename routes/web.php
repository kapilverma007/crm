<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\QuotePdfController;
use App\Http\Controllers\SecureDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     return redirect()->route('filament.admin.auth.login');
});
Route::middleware('signed')
    ->get('quotes/{quote}/pdf', QuotePdfController::class)
    ->name('quotes.pdf');


    Route::get('/contracts/generate/{userId}', [ContractController::class, 'generate'])
    ->name('contracts.generate');

Route::middleware('auth')->group(function () {
    Route::get('/download/contract/{path}', [SecureDownloadController::class, 'contract'])
        ->where('path', '.*')
        ->name('download.contract');
    Route::get('/download/document/{path}', [SecureDownloadController::class, 'document'])
        ->where('path', '.*')
        ->name('download.document');
});
