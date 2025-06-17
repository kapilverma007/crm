<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{

    public function generate($userId)
    {
        $user = Customer::findOrFail($userId);
        $templatePath = storage_path('app/template/contract.docx');
        // dd($templatePath);
        $outputDocxPath = storage_path("app/contracts/contract_user_{$user->full_name}_{$user->id}.docx");
        $outputPdfPath = $outputDocxPath; // Assuming you want to save the PDF with the same name
        // $outputPdfPath = storage_path("app/contracts/contract_user_{$user->id}.pdf");

        // Ensure output directory exists
        Storage::makeDirectory('contracts');

        // Fill Word template
        $template = new TemplateProcessor($templatePath);
        $template->setValue('full_name', $user->full_name);
        $template->setValue('email', $user->email);
        $template->setValue('city', $user->city);
        $template->setValue('phone_number', $user->phone_number);
        // Debugging line to check available variables
        // $template->setValue('date', now()->format('d M Y'));

        $template->saveAs($outputDocxPath);

        // Convert to PDF using LibreOffice
        //   exec("libreoffice --headless --convert-to pdf --outdir " . dirname($outputPdfPath) . " " . $outputDocxPath);

        // Return file for download
        return response()->download($outputPdfPath)->deleteFileAfterSend();
    }
}
