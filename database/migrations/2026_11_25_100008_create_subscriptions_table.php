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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
            $table->foreignId('planting_season_id')->nullable()->constrained('planting_seasons')->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('city');
            $table->text('delivery_address');
            $table->string('plan_type'); // 'monthly' | 'quarterly'
            $table->unsignedInteger('rice_kg_per_month')->default(10);
            $table->unsignedInteger('duration_months')->default(3); // 1 or 3
            $table->decimal('total_amount', 12, 2);
            $table->decimal('salam_allocation_amount', 12, 2)->default(0.00); // Rp 13.800/kg * total kg (for quarterly)
            $table->string('payment_method')->default('qris'); // 'qris' | 'va'
            $table->string('payment_status')->default('pending'); // 'pending' | 'paid' | 'cancelled'
            $table->timestamp('paid_at')->nullable();

            // Backward-compatibility columns for legacy references
            $table->string('nama_pelanggan')->nullable();
            $table->string('no_wa')->nullable();
            $table->text('alamat')->nullable();
            $table->string('paket')->nullable();
            $table->decimal('total_bayar', 12, 2)->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->date('tanggal_mulai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
