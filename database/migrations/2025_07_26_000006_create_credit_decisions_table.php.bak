<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained('credit_applications')->onDelete('cascade');
            
            // Decision Details
            $table->enum('decision', ['approved', 'denied', 'conditional', 'deferred']);
            $table->enum('decision_maker', ['automated', 'manual', 'external']);
            $table->timestamp('decision_date')->useCurrent();
            $table->foreignId('decided_by')->nullable()->constrained('users');
            
            // Approved Terms (if approved)
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->integer('approved_term_months')->nullable();
            $table->decimal('interest_rate', 5, 4)->nullable();
            $table->decimal('fee_percentage', 5, 4)->nullable();
            $table->text('conditions')->nullable();
            
            // Denial Information (if denied)
            $table->string('denial_reason_code', 20)->nullable();
            $table->text('denial_reason_text')->nullable();
            
            // Scoring Information
            $table->integer('credit_score')->nullable();
            $table->enum('risk_rating', ['low', 'medium', 'high', 'very_high'])->nullable();
            $table->json('scoring_factors')->nullable();
            
            // External Decision Data
            $table->string('external_reference', 100)->nullable();
            $table->json('external_decision_data')->nullable();
            
            // Documentation
            $table->string('decision_document_path', 500)->nullable();
            $table->string('terms_document_path', 500)->nullable();
            
            $table->timestamps();
            
            $table->index(['credit_application_id']);
            $table->index(['decision']);
            $table->index(['decision_date']);
            $table->index(['decided_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_decisions');
    }
};