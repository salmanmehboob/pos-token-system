<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::get('/', function () {
    return redirect()->route('login');
});

// Laravel UI auth routes (login, register, password reset)
Auth::routes();

// Dashboard/Home after login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Protected routes (only accessible when logged in)
Route::middleware('auth')->group(function () {


 // ✅  Categories Routes (Standardized)
 Route::prefix('product-categories')->name('product.categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');  // List all categories
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show'); // Show a specific category
        Route::post('/', [CategoryController::class, 'store'])->name('store'); // Store a new category
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update'); // Update a category
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy'); // Delete a category
    });

    // ✅ Products Routes (Standardized + Restore)
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index'); // List all items
        Route::post('/', [ProductController::class, 'store'])->name('store'); // Store new item
        Route::get('/create', [ProductController::class, 'create'])->name('create'); // Create form
        Route::get('/{item}', [ProductController::class, 'show'])->name('show'); // Show a specific item
        Route::get('/{item}/edit', [ProductController::class, 'edit'])->name('edit'); // Edit form
        Route::put('/{product}', [ProductController::class, 'update'])->name('update'); // Update item
        Route::delete('/{item}', [ProductController::class, 'destroy'])->name('destroy'); // Delete item
        Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore'); // Restore soft-deleted item
    });
//    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');



});
