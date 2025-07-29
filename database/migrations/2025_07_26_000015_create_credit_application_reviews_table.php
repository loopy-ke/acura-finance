<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_application_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained()->onDelete('cascade');
            $table->string('review_level'); // junior, senior, manager, director
            $table->enum('status', ['pending', 'approved', 'denied', 'escalated'])->default('pending');
            $table->foreignId('submitted_by')->constrained('users');
            $table->datetime('submitted_at');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->datetime('reviewed_at')->nullable();
            $table->text('review_comments')->nullable();
            $table->json('review_data')->nullable(); // Additional review information
            $table->timestamps();

            $table->index(['credit_application_id', 'status']);
            $table->index(['reviewed_by', 'status']);
            $table->index(['review_level', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_application_reviews');
    }
};