<?php

declare(strict_types=1);

use App\Http\Controllers\WhatsAppWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('webhooks')->group(function (): void {
    Route::get('/whatsapp', [WhatsAppWebhookController::class, 'verify'])->name('whatsapp.webhook.verify');
    Route::post('/whatsapp', [WhatsAppWebhookController::class, 'handle'])->name('whatsapp.webhook.handle');
});
