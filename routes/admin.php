<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairLogController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('repair')->name('repairs.')->group(function () {
        Route::get('/', [RepairController::class, 'index'])->name('index');
        Route::get('/create', [RepairController::class, 'create'])->name('create');
        Route::post('/', [RepairController::class, 'store'])->name('store');
        Route::get('/{repair}', [RepairController::class, 'edit'])->name('edit');

        Route::prefix('logs')->name('logs.')->group(function () {
            Route::get('/{repair}', [RepairLogController::class, 'logs'])->name('index');
            Route::put('/{repair}', [RepairLogController::class, 'update'])->name('update');
        });
    });

    Route::get('/tables', function () {
        return Inertia::render('Tables');
    })->name('tables');

    Route::get('/forms', function () {
        return Inertia::render('Forms');
    })->name('forms');

    Route::get('/charts', function () {
        return Inertia::render('Charts');
    })->name('charts');

    Route::get('/components', function () {
        return Inertia::render('Components');
    })->name('components');

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    })->name('settings');

    Route::get('reception', [ReceptionController::class, 'index']);
});
