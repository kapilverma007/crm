<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SecureDownloadController extends Controller
{
    public function contract(string $path)
    {
        $filePath = 'contracts/' . $path;

        if (!Storage::disk('local')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('local')->download($filePath);
    }

    public function document(string $path)
    {
        $filePath = 'documents/' . $path;

        if (!Storage::disk('local')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('local')->download($filePath);
    }
}
