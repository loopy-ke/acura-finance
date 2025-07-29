<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_application_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users');
            $table->foreignId('assigned_by')->constrained('users');
            $table->datetime('assigned_at');
            $table->datetime('unassigned_at')->nullable();
            $table->foreignId('unassigned_by')->nullable()->constrained('users');
            $table->text('assignment_notes')->nullable();
            $table->timestamps();

            $table->index(['credit_application_id', 'assigned_at']);
            $table->index(['assigned_to', 'assigned_at']);
            $table->index(['assigned_by', 'assigned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_application_assignments');
    }
};