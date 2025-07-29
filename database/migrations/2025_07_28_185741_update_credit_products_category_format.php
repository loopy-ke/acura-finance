<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing slug-based categories to proper display names
        DB::table('credit_products')
            ->where('category', 'short-term')
            ->update(['category' => 'Short Term']);
            
        DB::table('credit_products')
            ->where('category', 'mid-term')
            ->update(['category' => 'Mid Term']);
            
        DB::table('credit_products')  
            ->where('category', 'long-term')
            ->update(['category' => 'Long Term']);
    }

    public function down(): void
    {
        // Revert to slug format
        DB::table('credit_products')
            ->where('category', 'Short Term')
            ->update(['category' => 'short-term']);
            
        DB::table('credit_products')
            ->where('category', 'Mid Term')
            ->update(['category' => 'mid-term']);
            
        DB::table('credit_products')
            ->where('category', 'Long Term')
            ->update(['category' => 'long-term']);
    }
};