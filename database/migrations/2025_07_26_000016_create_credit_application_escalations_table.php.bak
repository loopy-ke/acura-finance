<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_application_escalations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained()->onDelete('cascade');
            $table->string('from_level');
            $table->string('to_level');
            $table->text('escalation_reason')->nullable();
            $table->foreignId('escalated_by')->constrained('users');
            $table->datetime('escalated_at');
            $table->json('escalation_data')->nullable();
            $table->timestamps();

            $table->index(['credit_application_id', 'escalated_at']);
            $table->index(['escalated_by', 'escalated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_application_escalations');
    }
};