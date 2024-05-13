<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/upload-form', [ExcelController::class, 'showForm']);
Route::get('/new-upload-form', [ExcelController::class, 'newshowForm']);
Route::post('/upload', [ExcelController::class, 'upload'])->name('upload');
Route::post('/new-upload', [ExcelController::class, 'newupload'])->name('newupload');
Route::get('/script-postqueue', function () {
    return view('script_postqueue');
});
Route::get('/download-sample-excel', [ExcelController::class, 'download'])->name('download.sample.excel');
Route::get('/download-new-sample-excel', [ExcelController::class, 'downloadNew'])->name('download.new.sample.excel');