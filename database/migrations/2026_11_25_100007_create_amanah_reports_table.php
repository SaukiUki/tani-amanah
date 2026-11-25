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
        Schema::create('amanah_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_season_id')->constrained('planting_seasons')->cascadeOnDelete();
            $table->foreignId('farmer_id')->constrained('farmers')->cascadeOnDelete();
            $table->string('qr_slug')->unique();
            $table->boolean('jerami_tidak_dibakar')->default(true);
            $table->boolean('pupuk_sesuai_dosis')->default(true);
            $table->integer('giliran_air_ditepati')->default(0);
            $table->integer('total_giliran_air')->default(0);
            $table->boolean('bebas_ijon')->default(true);
            $table->integer('pohon_ditanam')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amanah_reports');
    }
};
