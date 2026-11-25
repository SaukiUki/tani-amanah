<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HarvestRecord extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'planting_season_id',
        'farmer_id',
        'berat_gabah_kg',
        'harga_per_kg',
        'zakat_kg',
        'zakat_disalurkan',
        'leuit_kg',
        'pendapatan_bersih',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'berat_gabah_kg' => 'decimal:2',
            'harga_per_kg' => 'decimal:2',
            'zakat_kg' => 'decimal:2',
            'leuit_kg' => 'decimal:2',
            'pendapatan_bersih' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<PlantingSeason, $this>
     */
    public function plantingSeason(): BelongsTo
    {
        return $this->belongsTo(PlantingSeason::class);
    }

    /**
     * @return BelongsTo<Farmer, $this>
     */
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }
}
