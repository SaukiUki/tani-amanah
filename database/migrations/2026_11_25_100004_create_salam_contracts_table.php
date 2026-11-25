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
        Schema::create('salam_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_season_id')->constrained('planting_seasons')->cascadeOnDelete();
            $table->foreignId('farmer_id')->constrained('farmers')->cascadeOnDelete();
            $table->decimal('modal_di_muka', 12, 2);
            $table->decimal('gabah_dijanjikan_kg', 10, 2);
            $table->decimal('gabah_diserahkan_kg', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salam_contracts');
    }
};
