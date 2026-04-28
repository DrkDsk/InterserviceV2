<?php

use App\Http\Controllers\RepairController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('repairs', [RepairController::class, 'store']);
