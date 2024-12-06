<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CigaratteController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QrControlller;
use App\Http\Middleware\AdminLogin;
use App\Http\Middleware\AutoLogin;
use Illuminate\Support\Facades\Route;

Route::get('',[FrontController::class,'index'])->name('index')->middleware(AutoLogin::class);
Route::middleware(['auth'])->group(function () {
    Route::get('count',[FrontController::class,'count'])->name('count');
    Route::get('info',[FrontController::class,'info'])->name('info');
});

Route::match(['GET','POST'],'/login',[LoginController::class,'login'])->name('login');
Route::prefix('admin')->name('admin.')->middleware('auth')->middleware('adminlogin')->group(function () {
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
        Route::match(['GET', 'POST'], '/edi/{id}', [CigaratteController::class, 'Cedit'])->name('edit');
        Route::match(['GET'], 'winner/{win_id}', [CigaratteController::class, 'winner'])->name('winner');
    });
    Route::prefix('qrimage')->name('qrimage.')->group(function(){
        route::match(['GET','POST'],'index',[QrControlller::class,'index'])->name('index');
    });
});
