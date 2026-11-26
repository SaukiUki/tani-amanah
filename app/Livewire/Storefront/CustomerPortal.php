<?php

declare(strict_types=1);

namespace App\Livewire\Storefront;

use App\Models\Subscription;
use App\Services\Finance\SubscriptionService;
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

    // Properti Opsi Tambahan Kemasan 1Kg, 3Kg, 5Kg
    public int $selectedRetailKg = 3; // default kemasan 3 kg

    public int $retailQuantity = 1;

    public string $retailPaymentMethod = 'qris';

    public bool $showRetailModal = false;

    public bool $retailSuccess = false;

    public ?Subscription $retailSubscription = null;

    public bool $isPaid = false;

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

    public function selectRetailKg(int $kg): void
    {
        if (in_array($kg, [1, 3, 5], true)) {
            $this->selectedRetailKg = $kg;
        }
    }

    public function incrementRetailQty(): void
    {
        if ($this->retailQuantity < 10) {
            $this->retailQuantity++;
        }
    }

    public function decrementRetailQty(): void
    {
        if ($this->retailQuantity > 1) {
            $this->retailQuantity--;
        }
    }

    public function getPackagingOptionsProperty(): array
    {
        return app(SubscriptionService::class)->getPackagingOptions();
    }

    public function getSelectedRetailPriceProperty(): int
    {
        $options = $this->packagingOptions;
        $unitPrice = $options[$this->selectedRetailKg]['price'] ?? (17_500 * $this->selectedRetailKg);

        return $unitPrice * $this->retailQuantity;
    }

    public function openRetailModal(): void
    {
        $this->retailSuccess = false;
        $this->isPaid = false;
        $this->showRetailModal = true;
    }

    public function closeRetailModal(): void
    {
        $this->showRetailModal = false;
    }

    public function orderRetailPack(SubscriptionService $subscriptionService): void
    {
        if (! $this->subscription) {
            return;
        }

        $options = $this->packagingOptions;
        $unitPrice = $options[$this->selectedRetailKg]['price'] ?? (17_500 * $this->selectedRetailKg);
        $totalKg = $this->selectedRetailKg * $this->retailQuantity;
        $totalAmount = (float) ($unitPrice * $this->retailQuantity);

        $order = $subscriptionService->createSubscription([
            'customer_name' => $this->subscription->customer_name,
            'customer_phone' => $this->subscription->customer_phone,
            'city' => $this->subscription->city,
            'delivery_address' => $this->subscription->delivery_address,
            'plan_type' => "retail_{$this->selectedRetailKg}kg",
            'payment_method' => $this->retailPaymentMethod,
            'rice_kg_per_month' => $totalKg,
            'duration_months' => 1,
            'total_amount' => $totalAmount,
            'village_id' => $this->subscription->village_id,
            'planting_season_id' => $this->subscription->planting_season_id,
        ]);

        $this->retailSubscription = $order;
        $this->retailSuccess = true;
        $this->showRetailModal = true;
    }

    public function simulateRetailPayment(SubscriptionService $subscriptionService)
    {
        if ($this->retailSubscription) {
            $this->retailSubscription = $subscriptionService->confirmPayment($this->retailSubscription);
            $this->isPaid = true;

            return $this->redirect(route('order.show', $this->retailSubscription->invoice_number), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.storefront.customer-portal');
    }
}
