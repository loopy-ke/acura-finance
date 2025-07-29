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
        Schema::create('credit_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['short_term', 'mid_term', 'long_term']);
            $table->text('description')->nullable();
            
            // Amount limits
            $table->decimal('min_amount', 15, 2);
            $table->decimal('max_amount', 15, 2);
            
            // Term limits (in months)
            $table->integer('min_term_months');
            $table->integer('max_term_months');
            $table->integer('default_term_months');
            
            // Rates and fees
            $table->decimal('interest_rate', 8, 4); // Annual rate as decimal (e.g., 0.12 for 12%)
            $table->decimal('processing_fee_percentage', 8, 4)->default(0);
            $table->decimal('early_payment_discount', 8, 4)->default(0);
            
            // Credit score requirements
            $table->integer('min_credit_score')->nullable();
            $table->integer('max_credit_score')->nullable();
            
            // Requirements
            $table->boolean('collateral_required')->default(false);
            $table->boolean('guarantor_required')->default(false);
            
            // Status and ordering
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(100);
            
            // Flexible criteria and features
            $table->json('eligibility_criteria')->nullable();
            $table->json('features')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['category', 'is_active']);
            $table->index(['min_amount', 'max_amount']);
            $table->index(['min_term_months', 'max_term_months']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_products');
    }
};