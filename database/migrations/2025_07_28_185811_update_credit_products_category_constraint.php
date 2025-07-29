<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the old constraint if it exists
        DB::statement('ALTER TABLE credit_products DROP CONSTRAINT IF EXISTS credit_products_category_check');
        
        // Add new constraint with proper category values
        DB::statement("ALTER TABLE credit_products ADD CONSTRAINT credit_products_category_check CHECK (category IN ('Short Term', 'Mid Term', 'Long Term'))");
    }

    public function down(): void
    {
        // Drop the new constraint
        DB::statement('ALTER TABLE credit_products DROP CONSTRAINT IF EXISTS credit_products_category_check');
        
        // Add back the old constraint
        DB::statement("ALTER TABLE credit_products ADD CONSTRAINT credit_products_category_check CHECK (category IN ('short-term', 'mid-term', 'long-term'))");
    }
};