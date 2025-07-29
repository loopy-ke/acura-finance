<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_disbursements', function (Blueprint $table) {
            $table->id();
            $table->string('disbursement_number')->unique();
            $table->foreignId('credit_application_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained();
            
            // Disbursement details
            $table->decimal('disbursement_amount', 15, 2);
            $table->decimal('fee_amount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2); // Amount after fees
            $table->string('currency', 3)->default('KES');
            
            // Terms
            $table->integer('term_months');
            $table->decimal('interest_rate', 8, 6); // Annual interest rate
            $table->decimal('fee_percentage', 8, 6);
            $table->date('due_date');
            $table->date('maturity_date');
            
            // Status and workflow
            $table->enum('status', [
                'pending',
                'processing', 
                'disbursed',
                'failed',
                'cancelled',
                'partially_repaid',
                'fully_repaid',
                'overdue',
                'written_off'
            ])->default('pending');
            
            // Disbursement method
            $table->enum('disbursement_method', [
                'bank_transfer',
                'mobile_money',
                'check',
                'cash',
                'invoice_financing'
            ])->default('bank_transfer');
            
            // Bank/Payment details
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('transaction_id')->nullable();
            
            // Repayment tracking
            $table->decimal('total_repaid', 15, 2)->default(0);
            $table->decimal('principal_repaid', 15, 2)->default(0);
            $table->decimal('interest_repaid', 15, 2)->default(0);
            $table->decimal('fees_repaid', 15, 2)->default(0);
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            
            // Calculated amounts
            $table->decimal('total_interest', 15, 2)->default(0);
            $table->decimal('total_amount_due', 15, 2)->default(0);
            
            // Dates
            $table->datetime('disbursed_at')->nullable();
            $table->datetime('first_payment_due')->nullable();
            $table->datetime('last_payment_date')->nullable();
            $table->integer('days_overdue')->default(0);
            
            // Users
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('disbursed_by')->nullable()->constrained('users');
            
            // Notes and conditions
            $table->text('disbursement_notes')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->json('metadata')->nullable(); // Additional data like invoice references
            
            $table->timestamps();

            // Indexes
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'due_date']);
            $table->index(['disbursed_at']);
            $table->index(['days_overdue']);
            $table->index(['disbursement_method', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_disbursements');
    }
};