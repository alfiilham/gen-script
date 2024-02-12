<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourDataImport; // Create this import class
use App\Models\YourModel;

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
}
