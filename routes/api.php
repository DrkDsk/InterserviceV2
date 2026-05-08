<?php

use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairPDFGeneratorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('repairs', [RepairController::class, 'store']);

Route::prefix('repairs')->group(function () {
    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::post('/{repair}', [RepairPDFGeneratorController::class, 'generate'])->name('generate');
    });
});
