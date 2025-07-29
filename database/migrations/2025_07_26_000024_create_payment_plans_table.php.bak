<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_number')->unique();
            $table->foreignId('collection_case_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('credit_disbursement_id')->constrained()->onDelete('cascade');
            
            // Plan details
            $table->enum('status', [
                'proposed',
                'accepted',
                'active',
                'completed',
                'defaulted',
                'cancelled'
            ])->default('proposed');
            
            // Financial details
            $table->decimal('total_amount', 15, 2);
            $table->decimal('down_payment', 15, 2)->default(0);
            $table->decimal('installment_amount', 15, 2);
            $table->integer('number_of_installments');
            $table->enum('frequency', ['weekly', 'biweekly', 'monthly'])->default('monthly');
            
            // Dates
            $table->date('start_date');
            $table->date('end_date');
            $table->date('next_payment_date');
            
            // Progress tracking
            $table->integer('installments_paid')->default(0);
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->decimal('outstanding_balance', 15, 2);
            $table->integer('missed_payments')->default(0);
            $table->date('last_payment_date')->nullable();
            
            // Users
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->datetime('approved_at')->nullable();
            
            // Terms and notes
            $table->text('terms_and_conditions')->nullable();
            $table->text('plan_notes')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['customer_id', 'status']);
            $table->index(['collection_case_id', 'status']);
            $table->index(['status', 'next_payment_date']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};