<?php

declare(strict_types=1);

use App\Http\Controllers\RaporController;
use App\Http\Controllers\RaporDesaController;
use App\Livewire\Storefront\CustomerPortal;
use App\Livewire\Storefront\SubscriptionCheckout;
use Illuminate\Support\Facades\Route;

Route::get('/', SubscriptionCheckout::class)->name('storefront.index');
Route::get('/langganan', SubscriptionCheckout::class)->name('storefront.langganan');
Route::get('/cek-pesanan', CustomerPortal::class)->name('order.check');
Route::get('/pesanan/{invoice_number}', CustomerPortal::class)->name('order.show');

Route::get('/rapor/{qr_slug}', [RaporController::class, 'show'])->name('rapor.show');
Route::get('/admin/rapor-desa/preview', [RaporDesaController::class, 'preview'])->name('admin.rapor-desa.preview');
