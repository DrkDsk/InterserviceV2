<?php

use Illuminate\Support\Facades\Route;

Route::domain(config('app.subdomain') . '.' . config('app.domain'))->group(function () {
    require __DIR__ . '/admin.php';
});
