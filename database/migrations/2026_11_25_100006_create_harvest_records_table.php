<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('harvest_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_season_id')->constrained('planting_seasons')->cascadeOnDelete();
            $table->foreignId('farmer_id')->constrained('farmers')->cascadeOnDelete();
            $table->decimal('berat_gabah_kg', 10, 2);
            $table->decimal('harga_per_kg', 10, 2);
            $table->decimal('zakat_kg', 10, 2);
            $table->string('zakat_disalurkan');
            $table->decimal('leuit_kg', 10, 2)->default(0);
            $table->decimal('pendapatan_bersih', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_records');
    }
};
