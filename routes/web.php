<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CigaretteController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontController::class,'index'])->name('index');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('index');
    Route::prefix('cigarette')->name('cigarette.')->group(function () {
        Route::get('', [CigaretteController::class, 'index'])->name('index');
        Route::match(['GET', 'POST'], '/add', [CigaretteController::class, 'add'])->name('add');
        Route::match(['GET', 'POST'], '/edit/{id}', [CigaretteController::class, 'edit'])->name('edit');
        Route::match(['GET', 'POST'], '/del/{id}', [CigaretteController::class, 'del'])->name('del');
    });
});
