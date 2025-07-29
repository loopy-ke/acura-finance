<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->foreignId('credit_disbursement_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained();
            
            // Case details
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', [
                'active',
                'resolved',
                'closed',
                'legal',
                'written_off',
                'suspended'
            ])->default('active');
            
            // Financial details
            $table->decimal('original_amount', 15, 2);
            $table->decimal('outstanding_amount', 15, 2);
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->decimal('fees_charged', 15, 2)->default(0);
            $table->decimal('penalties_charged', 15, 2)->default(0);
            $table->decimal('total_recoverable', 15, 2);
            
            // Collection details
            $table->integer('days_overdue');
            $table->date('overdue_since');
            $table->date('last_payment_date')->nullable();
            $table->date('next_action_date')->nullable();
            $table->integer('collection_attempts')->default(0);
            
            // Assignment
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->datetime('assigned_at')->nullable();
            $table->enum('collection_stage', [
                'early_stage',      // 1-30 days
                'middle_stage',     // 31-90 days
                'late_stage',       // 91-180 days
                'legal_stage',      // 180+ days
                'write_off_stage'   // Deemed uncollectible
            ])->default('early_stage');
            
            // Resolution
            $table->enum('resolution_type', [
                'full_payment',
                'partial_payment',
                'payment_plan',
                'settlement',
                'legal_action',
                'written_off'
            ])->nullable();
            $table->date('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users');
            
            // Users
            $table->foreignId('created_by')->constrained('users');
            
            // Notes
            $table->text('case_notes')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'priority']);
            $table->index(['assigned_to', 'status']);
            $table->index(['collection_stage', 'status']);
            $table->index(['next_action_date']);
            $table->index(['days_overdue']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_cases');
    }
};