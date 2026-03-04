<?php

use App\Livewire\Product\ProductManager;
use App\Livewire\Vendor\VendorManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/products', ProductManager::class)->name('product.index');
    Route::get('/vendors', VendorManager::class)->name('vendor.index');
});

require __DIR__.'/settings.php';
