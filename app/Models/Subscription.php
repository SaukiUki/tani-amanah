<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'invoice_number',
        'village_id',
        'planting_season_id',
        'customer_name',
        'customer_phone',
        'city',
        'delivery_address',
        'plan_type',
        'rice_kg_per_month',
        'duration_months',
        'total_amount',
        'salam_allocation_amount',
        'payment_method',
        'payment_status',
        'paid_at',

        // Legacy columns
        'nama_pelanggan',
        'no_wa',
        'alamat',
        'paket',
        'total_bayar',
        'status_pembayaran',
        'tanggal_mulai',
    ];

    /**
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'salam_allocation_amount' => 'decimal:2',
            'total_bayar' => 'decimal:2',
            'rice_kg_per_month' => 'integer',
            'duration_months' => 'integer',
            'paid_at' => 'datetime',
            'tanggal_mulai' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Subscription $sub): void {
            // Synchronize canonical fields to legacy fields
            $sub->nama_pelanggan = $sub->customer_name ?? $sub->nama_pelanggan;
            $sub->no_wa = $sub->customer_phone ?? $sub->no_wa;
            $sub->alamat = $sub->delivery_address ?? $sub->alamat;
            $sub->paket = $sub->plan_type ?? $sub->paket;
            $sub->total_bayar = $sub->total_amount ?? $sub->total_bayar;
            
            if ($sub->payment_status === 'paid') {
                $sub->status_pembayaran = 'lunas';
            } elseif ($sub->payment_status === 'cancelled') {
                $sub->status_pembayaran = 'batal';
            } else {
                $sub->status_pembayaran = $sub->status_pembayaran ?? 'menunggu_pembayaran';
            }
            
            $sub->tanggal_mulai = $sub->tanggal_mulai ?? now()->toDateString();

            // Synchronize legacy fields to canonical if canonical not provided
            if (empty($sub->customer_name) && !empty($sub->nama_pelanggan)) {
                $sub->customer_name = $sub->nama_pelanggan;
            }
            if (empty($sub->customer_phone) && !empty($sub->no_wa)) {
                $sub->customer_phone = $sub->no_wa;
            }
            if (empty($sub->city)) {
                $sub->city = 'Serang';
            }
            if (empty($sub->delivery_address) && !empty($sub->alamat)) {
                $sub->delivery_address = $sub->alamat;
            }
            if (empty($sub->plan_type) && !empty($sub->paket)) {
                $sub->plan_type = is_object($sub->paket) ? $sub->paket->value : (string) $sub->paket;
            }
            if (empty($sub->total_amount) && !empty($sub->total_bayar)) {
                $sub->total_amount = $sub->total_bayar;
            }
            if (empty($sub->payment_status) && !empty($sub->status_pembayaran)) {
                $sub->payment_status = $sub->status_pembayaran === 'lunas' ? 'paid' : ($sub->status_pembayaran === 'batal' ? 'cancelled' : 'pending');
            }
            if (empty($sub->invoice_number)) {
                $sub->invoice_number = 'AMANAH-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            }
        });
    }

    /**
     * @return BelongsTo<Village, $this>
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return BelongsTo<PlantingSeason, $this>
     */
    public function plantingSeason(): BelongsTo
    {
        return $this->belongsTo(PlantingSeason::class);
    }
}
