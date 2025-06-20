<?php

use App\Models\Distribution;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlockchainController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ProductionStageController;

// Route::get('/', function () {
//     return view('beranda');
// })->middleware('auth');;
Route::get('/', [IndexController::class, 'index'])->name('login')->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::put('/user/reset/{id}', [UserController::class, 'reset'])->name('user.reset');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware(['auth', 'role:produsen'])->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');


    Route::get('/product/{product}/stage/create', [ProductionStageController::class, 'create'])->name('stage.create');
    Route::post('/product/{product}/stage', [ProductionStageController::class, 'store'])->name('stage.store');
    Route::put('/product/{product}/distribution', [ProductionStageController::class, 'distribution'])->name('stage.distribution');
});

Route::get('/history', [HistoryController::class, 'index'])->name('product.history');
Route::get('/blockchain', [BlockchainController::class, 'index'])->name('blockchain.history');

Route::middleware(['auth', 'role:distributor'])->group(function () {
    Route::get('/distribution', [DistributionController::class, 'index'])->name('distribution.index');
    Route::get('/distribution/product/{product}', [DistributionController::class, 'show'])->name('distribution.show');
    Route::get('/distribution/product/{product}/create', [DistributionController::class, 'create'])->name('distribution.create');
    Route::post('/distribution/product/{product}/store', [DistributionController::class, 'store'])->name('distribution.store');
});

Route::middleware(['auth', 'role:produsen,konsumen'])->group(function () {
    Route::get('/product/{product}', [ProductionStageController::class, 'index'])->name('stage.index');
});
Route::get('/product/detail/{id}', [IndexController::class, 'detail'])->name('product.detail');
