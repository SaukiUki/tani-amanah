<?php

declare(strict_types=1);

namespace App\Livewire\Storefront;

use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CustomerPortal extends Component
{
    public string $query = '';

    public ?string $invoice_number = null;

    public ?Subscription $subscription = null;

    /**
     * @var \Illuminate\Database\Eloquent\Collection<int, Subscription>|array<int, mixed>
     */
    public $subscriptions = [];

    public bool $hasSearched = false;

    public ?string $errorMessage = null;

    public function mount(?string $invoice_number = null): void
    {
        if ($invoice_number) {
            $this->invoice_number = $invoice_number;
            $this->subscription = Subscription::query()
                ->with(['village', 'plantingSeason'])
                ->where('invoice_number', $invoice_number)
                ->first();

            $this->hasSearched = true;

            if (! $this->subscription) {
                $this->errorMessage = "Pesanan dengan nomor invoice {$invoice_number} tidak ditemukan.";
            }
        }
    }

    public function checkOrder()
    {
        $this->errorMessage = null;
        $this->hasSearched = true;
        $clean = trim($this->query);

        if (empty($clean)) {
            $this->errorMessage = 'Silakan masukkan nomor invoice atau nomor WhatsApp Anda.';
            $this->subscription = null;
            $this->subscriptions = [];

            return;
        }

        // 1. Cek exact match invoice_number
        $byInvoice = Subscription::query()
            ->with(['village', 'plantingSeason'])
            ->where('invoice_number', $clean)
            ->first();

        if ($byInvoice) {
            return $this->redirect(route('order.show', $byInvoice->invoice_number), navigate: true);
        }

        // 2. Cek match no_wa / customer_phone
        $phoneQuery = ltrim($clean, '+');
        $byPhone = Subscription::query()
            ->with(['village', 'plantingSeason'])
            ->where(function ($q) use ($phoneQuery, $clean) {
                $q->where('customer_phone', 'like', "%{$phoneQuery}%")
                    ->orWhere('no_wa', 'like', "%{$phoneQuery}%")
                    ->orWhere('customer_name', 'like', "%{$clean}%")
                    ->orWhere('nama_pelanggan', 'like', "%{$clean}%");
            })
            ->latest('id')
            ->get();

        if ($byPhone->count() === 1) {
            return $this->redirect(route('order.show', $byPhone->first()->invoice_number), navigate: true);
        }

        if ($byPhone->count() > 1) {
            $this->subscriptions = $byPhone;
            $this->subscription = null;

            return;
        }

        $this->subscription = null;
        $this->subscriptions = [];
        $this->errorMessage = 'Pesanan tidak ditemukan. Mohon periksa kembali nomor invoice (contoh: AMANAH-...) atau nomor WhatsApp Anda.';
    }

    public function render()
    {
        return view('livewire.storefront.customer-portal');
    }
}
