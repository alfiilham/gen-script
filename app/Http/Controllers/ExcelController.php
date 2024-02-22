<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourDataImport; // Create this import class
use App\Models\YourModel;
use Illuminate\Support\Facades\Response;


class ExcelController extends Controller
{
    public function showForm()
    {
        return view('upload_form');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $pw = $request->pw;
        $file = $request->file('file');

        // Import data from Excel
        $import = new YourDataImport();
        Excel::import($import, $file);

        // Retrieve the imported data
        $importedData = $import->getAllData();
        return view('upload_form', compact('importedData','pw'))->with('success', 'Excel file uploaded and data retrieved successfully.');
    }
    public function download()
    {
        // Path to the sample Excel file
        $filePath = public_path('sample_excel.xlsx');

        // Check if the file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Return the file as a download response
        return Response::download($filePath, 'sample_excel.xlsx');
    }
}
