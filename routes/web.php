<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\TicketCategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('/', HomeController::class)->name('home');

    Route::resource('tickets', TicketController::class)->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
    ]);

    Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        Route::resource('areas', AreaController::class)->only(['index', 'store', 'edit', 'update']);
        Route::resource('categories', TicketCategoryController::class)->only(['index', 'store', 'edit', 'update']);
    });
});
