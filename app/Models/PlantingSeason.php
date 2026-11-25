<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantingSeason extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'village_id',
        'kode_musim',
        'tanggal_syukuran_panen',
        'status_aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_syukuran_panen' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Village, $this>
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return HasMany<SalamContract, $this>
     */
    public function salamContracts(): HasMany
    {
        return $this->hasMany(SalamContract::class);
    }

    /**
     * @return HasMany<FarmExpense, $this>
     */
    public function farmExpenses(): HasMany
    {
        return $this->hasMany(FarmExpense::class);
    }

    /**
     * @return HasMany<HarvestRecord, $this>
     */
    public function harvestRecords(): HasMany
    {
        return $this->hasMany(HarvestRecord::class);
    }

    /**
     * @return HasMany<AmanahReport, $this>
     */
    public function amanahReports(): HasMany
    {
        return $this->hasMany(AmanahReport::class);
    }
}
