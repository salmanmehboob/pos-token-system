<?php

use App\Http\Controllers\EmployeeController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Laravel UI auth routes (login, register, password reset)
Auth::routes();

// Dashboard/Home after login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Protected routes (only accessible when logged in)
Route::middleware('auth')->group(function () {


    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');






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
        Route::get('/{product}', [ProductController::class, 'show'])->name('show'); // Show a specific item
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit'); // Edit form
        Route::put('/{product}', [ProductController::class, 'update'])->name('update'); // Update item
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy'); // Delete item
        Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore'); // Restore soft-deleted item
    });

    // ✅ Inventories Routes (Standardized + Restore)
    Route::prefix('inventories')->name('inventories.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index'); // List all items
        Route::post('/', [InventoryController::class, 'store'])->name('store'); // Store new item
        Route::get('/create', [InventoryController::class, 'create'])->name('create'); // Create form
        Route::get('/{inventory}', [InventoryController::class, 'show'])->name('show'); // Show a specific item
        Route::get('/{inventory}/edit', [InventoryController::class, 'edit'])->name('edit'); // Edit form
        Route::put('/{inventory}', [InventoryController::class, 'update'])->name('update'); // Update item
        Route::delete('/{inventory}', [InventoryController::class, 'destroy'])->name('destroy'); // Delete item
        Route::post('/{id}/restore', [InventoryController::class, 'restore'])->name('restore'); // Restore soft-deleted item
    });

    //        route for selecting products by category
    Route::get('/products-by-category', [InventoryController::class, 'getProductsByCategory'])->name('products.byCategory');

    Route::get('/histories', [HistoryController::class, 'index'])->name('histories.index');


    Route::prefix('sales')->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('sales.pos');
    });




    // Cart Routes
    Route::prefix('carts')->name('carts.')->group(function () {
        Route::get('/cart', [PosController::class, 'getCart'])->name('get');


//        Route::get('/', [PosController::class, 'getCart'])->name('index'); // AJAX cart load
        Route::post('/', [PosController::class, 'store'])->name('store');
        Route::put('/{id}', [PosController::class, 'update'])->name('update');
        Route::delete('/{id}', [PosController::class, 'destroy'])->name('destroy');
        Route::get('/cart-meta', [PosController::class, 'cartMeta'])->name('meta');

        // Separate route for discount
        Route::post('/apply-discount', [PosController::class, 'applyDiscount'])->name('apply-discount');
    });


    // route for orders
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderController::class, 'orderHistory'])->name('orders');



    // route for print invoice
    Route::get('invoice/{id}/print',[InvoiceController::class, 'printInvoice'])->name('invoice');


    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index'); // List all employees (DataTable)
        Route::post('/', [EmployeeController::class, 'store'])->name('store'); // Store new employee
        Route::get('/create', [EmployeeController::class, 'create'])->name('create'); // Optional: Create form view
        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show'); // Optional: Show a single employee
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit'); // Optional: Edit form view
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update'); // Update employee
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy'); // Delete employee
        Route::post('/{id}/restore', [EmployeeController::class, 'restore'])->name('restore'); // Restore soft-deleted employee
    });



    // ========== routes for settings ============

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'store'])->name('store');
        Route::put('/{setting}', [SettingController::class, 'update'])->name('update');
        Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('destroy');
    });

});
