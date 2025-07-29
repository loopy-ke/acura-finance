<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_repayments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique();
            $table->foreignId('credit_disbursement_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained();
            
            // Payment details
            $table->decimal('payment_amount', 15, 2);
            $table->decimal('principal_amount', 15, 2)->default(0);
            $table->decimal('interest_amount', 15, 2)->default(0);
            $table->decimal('fee_amount', 15, 2)->default(0);
            $table->decimal('penalty_amount', 15, 2)->default(0);
            $table->string('currency', 3)->default('KES');
            
            // Payment method
            $table->enum('payment_method', [
                'bank_transfer',
                'mobile_money',
                'cash',
                'check',
                'card',
                'offset',
                'adjustment'
            ]);
            
            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'reversed',
                'cancelled'
            ])->default('pending');
            
            // Payment source details
            $table->string('payment_reference')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('bank_reference')->nullable();
            $table->string('mobile_reference')->nullable();
            
            // Dates
            $table->date('payment_date');
            $table->datetime('processed_at')->nullable();
            $table->date('value_date')->nullable();
            
            // Users
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('processed_by')->nullable()->constrained('users');
            
            // Notes
            $table->text('payment_notes')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['credit_disbursement_id', 'payment_date']);
            $table->index(['customer_id', 'payment_date']);
            $table->index(['status', 'payment_date']);
            $table->index(['payment_method', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_repayments');
    }
};