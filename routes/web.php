<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Middleware\Admin;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'welcome']);

/*
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';


Route::middleware(['auth', Admin::class])->group(function()
{
    Route::get('/admin/dashboard', function()
    {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

});

Route::middleware(['auth', Admin::class])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('products/{code}', [ProductController::class, 'showByCode']);
    // Removed explicit PUT route to avoid conflict with resource route
    // Route::put('products/{code}', [ProductController::class, 'updateByCode']);
});

Route::get('/products/{code}', [ProductController::class, 'showByCode'])->name('products.show');

Route::post('/products/{code}/like', [ProductController::class, 'like'])->name('products.like');
