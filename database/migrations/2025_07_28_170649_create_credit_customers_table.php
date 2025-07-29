<?php

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
        Schema::create('credit_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            
            // Credit-specific fields
            $table->boolean('financing_enabled')->default(false);
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->integer('credit_score')->nullable();
            $table->timestamp('credit_score_updated_at')->nullable();
            $table->decimal('total_financed_amount', 15, 2)->default(0.00);
            $table->decimal('credit_utilization', 5, 2)->default(0.00);
            $table->timestamp('last_credit_check_at')->nullable();
            
            // Additional credit metadata
            $table->json('credit_metadata')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->unique('customer_id');
            $table->index(['financing_enabled']);
            $table->index(['credit_score']);
            $table->index(['financing_enabled', 'credit_limit', 'credit_utilization'], 'idx_credit_customers_composite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_customers');
    }
};
