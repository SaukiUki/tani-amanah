<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama_desa',
        'kecamatan',
        'kabupaten',
        'total_luas_ha',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_luas_ha' => 'decimal:2',
        ];
    }

    /**
     * @return HasMany<PlantingSeason, $this>
     */
    public function plantingSeasons(): HasMany
    {
        return $this->hasMany(PlantingSeason::class);
    }

    /**
     * @return HasMany<Farmer, $this>
     */
    public function farmers(): HasMany
    {
        return $this->hasMany(Farmer::class);
    }
}
