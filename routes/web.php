<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('admin_panel')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homeAdmin');

    Route::resource('cars', App\Http\Controllers\Admin\CarsController::class);
    Route::put('/cars/{car}', [App\Http\Controllers\Admin\CarsController::class, 'update'])->name('cars.update');
    Route::get('/admin', [App\Http\Controllers\Admin\CarsController::class, 'index'])->name('admin.dashboard');
});

