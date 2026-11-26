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
     * Ambil tarif dasar beras per kg langsung dari database.
     * Mengambil dari subscription aktif terakhir atau histori transaksi di database.
     */
    public function getBasePricePerKgFromDatabase(): int
    {
        try {
            $latest = Subscription::query()
                ->where('rice_kg_per_month', '>', 0)
                ->where('duration_months', '>', 0)
                ->where('total_amount', '>', 0)
                ->latest('id')
                ->first();

            if ($latest && $latest->rice_kg_per_month > 0 && $latest->duration_months > 0) {
                $totalKg = (float) ($latest->rice_kg_per_month * $latest->duration_months);
                if ($totalKg > 0) {
                    return (int) round(((float) $latest->total_amount) / $totalKg);
                }
            }
        } catch (\Throwable) {
            // Fallback aman jika database belum termigrasi atau koneksi unready
        }

        return (int) (self::MONTHLY_PRICE / self::DEFAULT_RICE_KG_PER_MONTH); // fallback default Rp 17.500/kg
    }

    /**
     * Opsi kemasan eceran/tambahan (1kg, 3kg, 5kg) dengan harga menyesuaikan dari database.
     *
     * @return array<int, array{kg: int, name: string, label: string, desc: string, price: int, tag: string}>
     */
    public function getPackagingOptions(): array
    {
        $pricePerKg = $this->getBasePricePerKgFromDatabase();

        return [
            1 => [
                'kg' => 1,
                'name' => 'Kemasan 1 Kg',
                'label' => 'Kemasan Harian (1 kg)',
                'desc' => 'Porsi darurat saat beras langganan habis mendadak atau uji coba rasa pulen.',
                'price' => 1 * $pricePerKg,
                'tag' => 'Praktis Harian',
            ],
            3 => [
                'kg' => 3,
                'name' => 'Kemasan 3 Kg',
                'label' => 'Kemasan Praktis (3 kg)',
                'desc' => 'Pas untuk tambahan konsumsi keluarga selama 1 minggu sebelum jadwal kirim rutin.',
                'price' => 3 * $pricePerKg,
                'tag' => 'Paling Populer',
            ],
            5 => [
                'kg' => 5,
                'name' => 'Kemasan 5 Kg',
                'label' => 'Kemasan Hemat (5 kg)',
                'desc' => 'Kemasan karung mini vakum kedap udara, aman disimpan sebagai stok dapur.',
                'price' => 5 * $pricePerKg,
                'tag' => 'Pilihan Hemat',
            ],
        ];
    }

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
        $isRetail = str_starts_with($planType, 'retail_');

        $basePricePerKg = $this->getBasePricePerKgFromDatabase();

        if ($isRetail) {
            $kg = match ($planType) {
                'retail_1kg', SubscriptionPlan::Retail1Kg->value => 1,
                'retail_3kg', SubscriptionPlan::Retail3Kg->value => 3,
                'retail_5kg', SubscriptionPlan::Retail5Kg->value => 5,
                default => 1,
            };
            $durationMonths = 1;
            $quantity = (int) ($data['quantity'] ?? 1);
            $riceKg = (int) ($data['rice_kg_per_month'] ?? ($kg * $quantity));
            $totalAmount = (float) ($data['total_amount'] ?? ($riceKg * $basePricePerKg));
            $salamAllocation = 0.0;
            $canonicalPlan = $planType;
        } elseif ($isQuarterly) {
            $durationMonths = 3;
            $riceKg = (int) ($data['rice_kg_per_month'] ?? self::DEFAULT_RICE_KG_PER_MONTH);
            $totalAmount = (float) ($data['total_amount'] ?? self::QUARTERLY_PRICE);
            $salamAllocation = $this->calculateSalamAllocation($planType, $riceKg);
            $canonicalPlan = 'quarterly';
        } else {
            $durationMonths = 1;
            $riceKg = (int) ($data['rice_kg_per_month'] ?? self::DEFAULT_RICE_KG_PER_MONTH);
            $totalAmount = (float) ($data['total_amount'] ?? self::MONTHLY_PRICE);
            $salamAllocation = 0.0;
            $canonicalPlan = 'monthly';
        }

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
            'plan_type' => $canonicalPlan,
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
            'paket' => $canonicalPlan,
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
