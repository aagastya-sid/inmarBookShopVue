<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'user',
], function () {
    Route::resource('books', BookController::class)
        ->middleware('auth')
        ->only(['index']);

    Route::resource('cart', CartController::class)
        ->middleware('auth')
        ->only(['index', 'store', 'destroy']);

    Route::resource('orders', OrderController::class)
        ->middleware('auth')
        ->only(['index', 'store']);

});

//Route::delete('/cart/{cart}', [CartController::class, 'destroy'])
//    ->middleware('auth')
//    ->name('cart.destroy');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::resource('books', BookController::class)
        ->only(['index', 'create', 'update', 'edit', 'store']);
    Route::resource('orders', OrderController::class)
        ->only(['index', 'update']);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
