<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairLogController;
use App\Http\Controllers\RepairPDFGeneratorController;
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
        Route::put('/{repair}', [RepairController::class, 'update'])->name('update');
        Route::delete('/{repair}', [RepairController::class, 'destroy'])->name('destroy');
        Route::get('/{repair}/settings', [RepairController::class, 'settings'])->name('settings');
        Route::delete('/{repair}/logs', [RepairController::class, 'destroyLogs'])->name('logs.clear');

        Route::prefix('/{repair}')->name('pdf.')->group(function () {
            Route::get('/pdf', [RepairPDFGeneratorController::class, 'generate'])->name('generate');
        });

        Route::prefix('logs')->name('logs.')->group(function () {
            Route::post('/{repair}', [RepairLogController::class, 'store'])->name('store');
            Route::get('/{repair}', [RepairLogController::class, 'logs'])->name('index');
            Route::delete('/{repairLog}', [RepairLogController::class, 'destroy'])->name('destroy');
            Route::put('/{repairLog}', [RepairLogController::class, 'update'])->name('update');
        });
    });

    Route::get('/tables', static function () {
        return Inertia::render('Tables');
    })->name('tables');

    Route::get('/forms', static function () {
        return Inertia::render('Forms');
    })->name('forms');

    Route::get('/charts', static function () {
        return Inertia::render('Charts');
    })->name('charts');

    Route::get('/components', static function () {
        return Inertia::render('Components');
    })->name('components');

    Route::get('/settings', static function () {
        return Inertia::render('Settings');
    })->name('settings');

    Route::get('reception', [ReceptionController::class, 'index']);
});
