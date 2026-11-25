<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmanahReport extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'planting_season_id',
        'farmer_id',
        'qr_slug',
        'jerami_tidak_dibakar',
        'pupuk_sesuai_dosis',
        'giliran_air_ditepati',
        'total_giliran_air',
        'bebas_ijon',
        'pohon_ditanam',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jerami_tidak_dibakar' => 'boolean',
            'pupuk_sesuai_dosis' => 'boolean',
            'giliran_air_ditepati' => 'integer',
            'total_giliran_air' => 'integer',
            'bebas_ijon' => 'boolean',
            'pohon_ditanam' => 'integer',
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
