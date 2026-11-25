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
        Schema::create('farm_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_season_id')->constrained('planting_seasons')->cascadeOnDelete();
            $table->foreignId('farmer_id')->constrained('farmers')->cascadeOnDelete();
            $table->string('jenis_biaya');
            $table->decimal('jumlah_unit', 8, 2)->default(1);
            $table->decimal('nominal_rp', 12, 2);
            $table->string('dicatat_via')->default('WhatsApp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_expenses');
    }
};
