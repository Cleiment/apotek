<?php

use Barryvdh\Snappy\Facades\SnappyPdf;

use App\Models\Product;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('obat', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('obat');

Route::view('obat/export', 'livewire.product.export');

Route::get('obat/delete/{id}', function (string $id) {
    $product = Product::find($id);
    $product->delete();

    return redirect('/obat');
});

Route::view('obat/{id}', 'edit-product')
    ->middleware(['auth', 'verified'])
    ->name('edit-product');

Route::view('transaction', 'transaction')
    ->middleware(['auth', 'verified'])
    ->name('transaction');

Route::view('transaction/export', 'livewire.transaction.export');

Route::view('transaction/{id}', 'edit-transaction')
    ->middleware(['auth', 'verified'])
    ->name('edit-transaction');

Route::get('transaction/delete/{id}', function (string $id) {
    $transaction = ProductTransaction::find($id);
    $transaction->delete();

    return redirect('/transaction');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
