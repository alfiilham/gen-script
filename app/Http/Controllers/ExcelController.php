<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourDataImport;
use App\Imports\NewDataImport;
use App\Models\YourModel;
use Illuminate\Support\Facades\Response;


class ExcelController extends Controller
{
    public function showForm()
    {
        return view('upload_form');
    }

    public function newShowForm()
    {
        return view('new_upload_form');
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
        $OldimportedData = $import->getAllData();
        $data = array_filter($OldimportedData, function($item) {
            return !empty(array_filter($item, function($value) {
                return $value !== null;
            }));
        });
        $importedData = array_values($data);
        dd($importedData);
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
    public function downloadNew()
    {
        // Path to the sample Excel file
        $filePath = public_path('sample_excel_new.xlsx');

        // Check if the file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Return the file as a download response
        return Response::download($filePath, 'sample_excel_new.xlsx');
    }
    public function newupload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $pw = $request->pw;
        $file = $request->file('file');

        // Import data from Excel
        $import = new NewDataImport();
        Excel::import($import, $file);

        // Retrieve the imported data
        $importedData = $import->getAllData();
        dd($importedData);
        return view('new_upload_form', compact('importedData','pw'))->with('success', 'Excel file uploaded and data retrieved successfully.');
    }
}
