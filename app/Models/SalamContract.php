<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SalamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalamContract extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'planting_season_id',
        'farmer_id',
        'modal_di_muka',
        'gabah_dijanjikan_kg',
        'gabah_diserahkan_kg',
        'status',
    ];

    /**
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'modal_di_muka' => 'decimal:2',
            'gabah_dijanjikan_kg' => 'decimal:2',
            'gabah_diserahkan_kg' => 'decimal:2',
            'status' => SalamStatus::class,
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
