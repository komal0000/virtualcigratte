<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CigaratteController;
use App\Http\Controllers\FrontController;
use App\Http\Middleware\AutoLogin;
use Illuminate\Support\Facades\Route;

Route::get('',[FrontController::class,'index'])->name('index')->middleware(AutoLogin::class);
Route::middleware(['auth'])->group(function () {
    Route::get('count',[FrontController::class,'count'])->name('count');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('index');
    Route::prefix('cigaratte')->name('cigaratte.')->group(function () {
        Route::get('', [CigaratteController::class, 'index'])->name('index');
        Route::match(['GET', 'POST'], '/add', [CigaratteController::class, 'add'])->name('add');
        Route::match(['GET', 'POST'], '/edit/{id}', [CigaratteController::class, 'edit'])->name('edit');
        Route::match(['GET', 'POST'], '/del/{id}', [CigaratteController::class, 'del'])->name('del');
    });
    Route::prefix('cigaratteCollection')->name('cigaratteCollection.')->group(function () {
        Route::get('', [CigaratteController::class, 'Cindex'])->name('index');
        Route::match(['GET', 'POST'], '/add', [CigaratteController::class, 'Cadd'])->name('add');
        Route::match(['GET', 'POST'], '/edit/{id}', [CigaratteController::class, 'Cedit'])->name('edit');
        Route::match(['GET', 'POST'], '/del/{id}', [CigaratteController::class, 'Cdel'])->name('del');
    });
});
