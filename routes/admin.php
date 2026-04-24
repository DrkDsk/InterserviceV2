<?php


use App\Http\Controllers\ReceptionController;

Route::get('reception', [ReceptionController::class, 'index']);
