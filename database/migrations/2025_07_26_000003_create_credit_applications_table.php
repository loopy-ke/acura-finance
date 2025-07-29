<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number', 50)->unique();
            
            // Relationships
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->foreignId('created_by')->constrained('users');
            
            // Application Details
            $table->decimal('requested_amount', 15, 2);
            $table->integer('requested_term_months')->default(12);
            $table->text('purpose')->nullable();
            $table->text('business_justification')->nullable();
            
            // Processing Information
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'denied', 'cancelled', 'expired'])->default('draft');
            $table->timestamp('submission_date')->nullable();
            $table->timestamp('review_started_at')->nullable();
            $table->timestamp('decision_date')->nullable();
            
            // Credit Assessment
            $table->integer('credit_score_at_application')->nullable();
            $table->enum('automated_decision', ['approve', 'deny', 'manual_review'])->nullable();
            $table->text('automated_decision_reason')->nullable();
            
            // External Partner Integration
            $table->string('external_application_id', 100)->nullable();
            $table->string('external_status', 50)->nullable();
            $table->json('external_response')->nullable();
            
            // Decision Information
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->integer('approved_term_months')->nullable();
            $table->decimal('approved_interest_rate', 5, 4)->nullable();
            $table->decimal('approved_fee_percentage', 5, 4)->nullable();
            
            // Workflow
            $table->string('review_level')->nullable();
            $table->boolean('requires_manual_approval')->default(false);
            $table->foreignId('submitted_by')->nullable()->constrained('users');
            $table->datetime('submitted_at')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->datetime('assigned_at')->nullable();
            $table->datetime('escalation_date')->nullable();
            $table->text('escalation_reason')->nullable();
            $table->datetime('escalated_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('approval_comments')->nullable();
            $table->text('approval_conditions')->nullable();
            $table->foreignId('denied_by')->nullable()->constrained('users');
            $table->text('denial_reason')->nullable();
            $table->text('denial_comments')->nullable();
            
            // Audit
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['application_number']);
            $table->index(['customer_id']);
            $table->index(['status']);
            $table->index(['submission_date']);
            $table->index(['decision_date']);
            $table->index(['external_application_id']);
            $table->index(['review_level', 'status']);
            $table->index(['assigned_to', 'status']);
            $table->index(['escalation_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_applications');
    }
};