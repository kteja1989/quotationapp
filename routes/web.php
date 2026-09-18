<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Livewire\Customers\CustomerList;
use App\Livewire\Customers\CustomerForm;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductForm;


//Route::view('/test-counter', \App\Livewire\TestCounter::class);
Route::get('/test-counter', \App\Livewire\TestCounter::class);


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

// Customers
    Route::get('/customers', CustomerList::class)->name('customers');
    Route::get('/customers/create', CustomerForm::class)->name('customers.create');
    Route::get('/customers/{customer}/edit', CustomerForm::class)->name('customers.edit');

// Products
    Route::get('/products', ProductList::class)->name('products');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{product}/edit', ProductForm::class)->name('products.edit');


    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
