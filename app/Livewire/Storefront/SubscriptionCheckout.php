<?php

declare(strict_types=1);

namespace App\Livewire\Storefront;

use App\Enums\SubscriptionPlan;
use App\Models\Subscription;
use App\Services\Finance\SubscriptionService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SubscriptionCheckout extends Component
{
    public string $selectedPlan = 'quarterly'; // Opsi default: 3 bulan di muka (Akad Salam)

    public bool $showModal = false;

    // Form attributes
    public string $customer_name = '';

    public string $customer_phone = '';

    public string $city = 'Serang';

    public string $delivery_address = '';

    public string $payment_method = 'qris'; // 'qris' | 'va'

    // Legacy fields for backward compatibility with existing tests
    public string $nama_pelanggan = '';

    public string $no_wa = '';

    public string $alamat = '';

    public bool $isSuccess = false;

    public bool $isPaid = false;

    public ?Subscription $submittedSubscription = null;

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'customer_name' => 'required|string|min:3|max:100',
            'customer_phone' => [
                'required',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,11}$/',
            ],
            'city' => 'required|string|in:Serang,Cilegon,Tangerang,Jakarta',
            'delivery_address' => 'required|string|min:10|max:500',
            'payment_method' => 'required|string|in:qris,va',
        ];
    }

    /**
     * @var array<string, string>
     */
    protected array $messages = [
        'customer_name.required' => 'Nama lengkap wajib diisi.',
        'customer_name.min' => 'Nama minimal 3 karakter.',
        'customer_phone.required' => 'Nomor WhatsApp aktif wajib diisi.',
        'customer_phone.regex' => 'Format nomor WhatsApp tidak valid (contoh: 081234567890).',
        'city.required' => 'Wilayah pengiriman wajib dipilih.',
        'city.in' => 'Pilihan wilayah pengiriman saat ini: Serang, Cilegon, Tangerang, atau Jakarta.',
        'delivery_address.required' => 'Alamat pengiriman beras wajib diisi lengkap.',
        'delivery_address.min' => 'Alamat pengiriman minimal 10 karakter.',
        'payment_method.required' => 'Metode pembayaran wajib dipilih.',
    ];

    public function selectPlan(string $plan): void
    {
        if (in_array($plan, ['monthly', 'quarterly', 'retail_1kg', 'retail_3kg', 'retail_5kg'], true)) {
            $this->selectedPlan = $plan;
        }
    }

    public function openCheckout(): void
    {
        $this->isSuccess = false;
        $this->isPaid = false;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function getPackagingOptionsProperty(): array
    {
        return app(SubscriptionService::class)->getPackagingOptions();
    }

    public function getSelectedPriceProperty(): int
    {
        $options = $this->packagingOptions;

        return match ($this->selectedPlan) {
            'quarterly' => SubscriptionService::QUARTERLY_PRICE,
            'monthly' => SubscriptionService::MONTHLY_PRICE,
            'retail_1kg' => $options[1]['price'] ?? 17_500,
            'retail_3kg' => $options[3]['price'] ?? 52_500,
            'retail_5kg' => $options[5]['price'] ?? 87_500,
            default => SubscriptionService::QUARTERLY_PRICE,
        };
    }

    public function getSelectedPlanNameProperty(): string
    {
        return match ($this->selectedPlan) {
            'quarterly' => 'Paket Musiman (3 Bulan di Muka - 10 kg/bulan)',
            'monthly' => 'Paket Bulanan (1 Bulan - 10 kg/bulan)',
            'retail_1kg' => 'Beras Amanah Kemasan 1 Kg (Eceran / Tambahan)',
            'retail_3kg' => 'Beras Amanah Kemasan 3 Kg (Eceran / Tambahan)',
            'retail_5kg' => 'Beras Amanah Kemasan 5 Kg (Eceran / Tambahan)',
            default => 'Paket Musiman (3 Bulan di Muka)',
        };
    }

    public function getSelectedKgProperty(): int
    {
        return match ($this->selectedPlan) {
            'quarterly' => 30,
            'monthly' => 10,
            'retail_1kg' => 1,
            'retail_3kg' => 3,
            'retail_5kg' => 5,
            default => 10,
        };
    }

    public function getSalamAllocationProperty(): float
    {
        return app(SubscriptionService::class)->calculateSalamAllocation($this->selectedPlan, 10);
    }

    public function checkout(SubscriptionService $subscriptionService): void
    {
        // Sync legacy properties if filled
        if (empty($this->customer_name) && ! empty($this->nama_pelanggan)) {
            $this->customer_name = $this->nama_pelanggan;
        }
        if (empty($this->customer_phone) && ! empty($this->no_wa)) {
            $this->customer_phone = $this->no_wa;
        }
        if (empty($this->delivery_address) && ! empty($this->alamat)) {
            $this->delivery_address = $this->alamat;
        }

        // Sync reverse
        $this->nama_pelanggan = $this->customer_name;
        $this->no_wa = $this->customer_phone;
        $this->alamat = $this->delivery_address;

        $this->validate();

        $kg = $this->selectedKg;

        $subscription = $subscriptionService->createSubscription([
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'city' => $this->city,
            'delivery_address' => $this->delivery_address,
            'plan_type' => $this->selectedPlan,
            'payment_method' => $this->payment_method,
            'rice_kg_per_month' => $kg,
        ]);

        $this->submittedSubscription = $subscription;
        $this->showModal = true;
        $this->isSuccess = true;
        $this->isPaid = false;
    }

    /**
     * Tombol simulasi pembayaran berhasil untuk keperluan pengujian alur.
     */
    public function simulatePaymentSuccess(SubscriptionService $subscriptionService)
    {
        if ($this->submittedSubscription) {
            $this->submittedSubscription = $subscriptionService->confirmPayment($this->submittedSubscription);
            $this->isPaid = true;

            return $this->redirect(route('order.show', $this->submittedSubscription->invoice_number), navigate: true);
        }
    }

    public function resetForm(): void
    {
        $this->reset([
            'customer_name',
            'customer_phone',
            'delivery_address',
            'nama_pelanggan',
            'no_wa',
            'alamat',
            'isSuccess',
            'isPaid',
            'submittedSubscription',
        ]);

        $this->city = 'Serang';
        $this->payment_method = 'qris';
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.storefront.subscription-checkout');
    }
}
