<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

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

Route::get('test', function () {
    return "subdomain: " . config('app.subdomain') . " domain: " . config('app.domain');
});

Route::domain(config('app.subdomain') . '.' . config('app.domain'))->group(function () {
    require __DIR__ . '/admin.php';
});
