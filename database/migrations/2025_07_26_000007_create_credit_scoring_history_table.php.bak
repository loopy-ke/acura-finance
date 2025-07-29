<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_scoring_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('credit_application_id')->nullable()->constrained('credit_applications');
            
            // Score Information
            $table->integer('credit_score');
            $table->string('score_version', 10);
            
            // Score Breakdown
            $table->integer('payment_history_score');
            $table->integer('current_balance_score');
            $table->integer('credit_utilization_score');
            $table->integer('business_relationship_score');
            $table->integer('financial_stability_score');
            
            // Supporting Data
            $table->integer('total_invoices_count')->default(0);
            $table->integer('paid_on_time_count')->default(0);
            $table->decimal('average_days_to_pay', 5, 2)->default(0.00);
            $table->decimal('current_outstanding_balance', 15, 2)->default(0.00);
            $table->integer('longest_relationship_months')->default(0);
            
            // Metadata
            $table->json('scoring_factors')->nullable();
            $table->json('external_data_sources')->nullable();
            
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['customer_id']);
            $table->index(['credit_score']);
            $table->index(['created_at']);
            $table->index(['credit_application_id']);
            $table->index(['customer_id', 'created_at'], 'idx_scoring_customer_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_scoring_history');
    }
};