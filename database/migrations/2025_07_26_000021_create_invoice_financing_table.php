<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_financing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_disbursement_id')->constrained()->onDelete('cascade');
            $table->foreignId('invoice_id')->constrained();
            
            // Financing details
            $table->decimal('invoice_amount', 15, 2);
            $table->decimal('financed_amount', 15, 2);
            $table->decimal('advance_rate', 5, 4); // Percentage of invoice financed
            $table->decimal('discount_rate', 8, 6); // Discount/fee rate
            $table->decimal('discount_amount', 15, 2);
            
            // Dates
            $table->date('invoice_date');
            $table->date('invoice_due_date');
            $table->date('financing_date');
            $table->date('collection_due_date');
            
            // Status
            $table->enum('status', [
                'financed',
                'collected',
                'overdue',
                'defaulted',
                'written_off'
            ])->default('financed');
            
            // Collection tracking
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->datetime('collected_at')->nullable();
            $table->integer('days_to_collect')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['invoice_id']);
            $table->index(['status', 'collection_due_date']);
            $table->index(['financing_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_financing');
    }
};