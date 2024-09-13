<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/generate-files', [FileController::class, 'generateFiles']);



Route::get('/zip-test', function () {
    // $zip = new ZipArchive();
    return class_exists('ZipArchive') ? 'ZipArchive is enabled' : 'ZipArchive is not enabled';
});

