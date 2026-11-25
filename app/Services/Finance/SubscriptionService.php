<?php

declare(strict_types=1);

namespace App\Services\Finance;

use App\Enums\SubscriptionPlan;
use App\Models\PlantingSeason;
use App\Models\Subscription;
use App\Models\Village;
use Illuminate\Support\Str;

class SubscriptionService
{
    /**
     * Rate alokasi modal tanam salam: Rp 13.800 per kg beras.
     */
    public const SALAM_RATE_PER_KG = 13_800;

    public const MONTHLY_PRICE = 175_000;

    public const QUARTERLY_PRICE = 525_000;

    public const DEFAULT_RICE_KG_PER_MONTH = 10;

    /**
     * Hitung otomatis alokasi modal tanam salam (khusus paket 3 bulan di muka).
     */
    public function calculateSalamAllocation(string $planType, int $riceKgPerMonth = self::DEFAULT_RICE_KG_PER_MONTH): float
    {
        $isQuarterly = $planType === 'quarterly' || $planType === SubscriptionPlan::Quarterly->value;

        if (! $isQuarterly) {
            return 0.0;
        }

        $totalKg = $riceKgPerMonth * 3;

        return (float) ($totalKg * self::SALAM_RATE_PER_KG);
    }

    /**
     * Buat langganan baru dengan status pending.
     *
     * @param array<string, mixed> $data
     */
    public function createSubscription(array $data): Subscription
    {
        $planType = (string) ($data['plan_type'] ?? $data['paket'] ?? 'quarterly');
        $isQuarterly = $planType === 'quarterly' || $planType === SubscriptionPlan::Quarterly->value;

        $durationMonths = $isQuarterly ? 3 : 1;
        $riceKg = (int) ($data['rice_kg_per_month'] ?? self::DEFAULT_RICE_KG_PER_MONTH);
        $totalAmount = (float) ($isQuarterly ? self::QUARTERLY_PRICE : self::MONTHLY_PRICE);

        // Perhitungan otomatis alokasi modal tanam salam (khusus paket 3 bulan di muka)
        $salamAllocation = $this->calculateSalamAllocation($planType, $riceKg);

        $customerName = (string) ($data['customer_name'] ?? $data['nama_pelanggan'] ?? '');
        $customerPhone = (string) ($data['customer_phone'] ?? $data['no_wa'] ?? '');
        $city = (string) ($data['city'] ?? 'Serang');
        $deliveryAddress = (string) ($data['delivery_address'] ?? $data['alamat'] ?? '');
        $paymentMethod = (string) ($data['payment_method'] ?? 'qris');

        $villageId = $data['village_id'] ?? Village::query()->where('nama_desa', 'Desa Panosogan')->value('id') ?? Village::query()->value('id');
        $seasonId = $data['planting_season_id'] ?? PlantingSeason::query()->where('status_aktif', true)->value('id') ?? PlantingSeason::query()->value('id');

        $invoiceNumber = $this->generateInvoiceNumber();

        return Subscription::create([
            'invoice_number' => $invoiceNumber,
            'village_id' => $villageId,
            'planting_season_id' => $seasonId,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'city' => $city,
            'delivery_address' => $deliveryAddress,
            'plan_type' => $isQuarterly ? 'quarterly' : 'monthly',
            'rice_kg_per_month' => $riceKg,
            'duration_months' => $durationMonths,
            'total_amount' => $totalAmount,
            'salam_allocation_amount' => $salamAllocation,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'paid_at' => null,

            // Legacy mirror fields
            'nama_pelanggan' => $customerName,
            'no_wa' => $customerPhone,
            'alamat' => $deliveryAddress,
            'paket' => $isQuarterly ? 'quarterly' : 'monthly',
            'total_bayar' => $totalAmount,
            'status_pembayaran' => 'menunggu_pembayaran',
            'tanggal_mulai' => now()->toDateString(),
        ]);
    }

    /**
     * Konfirmasi pembayaran: ubah status menjadi paid dan catat waktu paid_at.
     */
    public function confirmPayment(Subscription $subscription): Subscription
    {
        $subscription->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'status_pembayaran' => 'lunas',
        ]);

        return $subscription->fresh();
    }

    /**
     * Generate nomor invoice unik (contoh: AMANAH-20270101-ABCD).
     */
    public function generateInvoiceNumber(): string
    {
        $datePrefix = now()->format('Ymd');

        do {
            $randomSuffix = strtoupper(Str::random(4));
            $invoiceNumber = "AMANAH-{$datePrefix}-{$randomSuffix}";
        } while (Subscription::query()->where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }
}
