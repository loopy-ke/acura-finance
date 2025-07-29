<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_case_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained();
            
            // Activity details
            $table->enum('activity_type', [
                'phone_call',
                'email',
                'sms',
                'letter',
                'visit',
                'legal_notice',
                'payment_plan',
                'settlement_offer',
                'field_visit',
                'court_action',
                'other'
            ]);
            
            $table->enum('outcome', [
                'contact_made',
                'no_contact',
                'promise_to_pay',
                'payment_received',
                'dispute_raised',
                'hardship_claimed',
                'refusal_to_pay',
                'contact_updated',
                'legal_action_initiated',
                'case_escalated',
                'other'
            ]);
            
            // Communication details
            $table->text('activity_notes');
            $table->datetime('activity_date');
            $table->datetime('follow_up_date')->nullable();
            $table->decimal('payment_promise_amount', 15, 2)->nullable();
            $table->date('payment_promise_date')->nullable();
            
            // Contact information
            $table->string('contact_method')->nullable(); // phone, email, address
            $table->string('contact_person')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            
            // Users
            $table->foreignId('performed_by')->constrained('users');
            
            // Attachments and metadata
            $table->json('attachments')->nullable(); // File references
            $table->json('metadata')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['collection_case_id', 'activity_date']);
            $table->index(['customer_id', 'activity_date']);
            $table->index(['activity_type', 'outcome']);
            $table->index(['performed_by', 'activity_date']);
            $table->index(['follow_up_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_activities');
    }
};