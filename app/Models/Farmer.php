<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\IrrigationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farmer extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'village_id',
        'nama',
        'nomor_wa',
        'luas_lahan_ha',
        'blok_lahan',
        'tipe_irigasi',
        'foto_url',
    ];

    /**
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'luas_lahan_ha' => 'decimal:2',
            'tipe_irigasi' => IrrigationType::class,
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
