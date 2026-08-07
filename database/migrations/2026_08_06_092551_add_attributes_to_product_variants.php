<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if table exists before trying to modify it
        if (Schema::hasTable('product__variants')) {
            Schema::table('product__variants', function (Blueprint $table) {
                // Stores the attribute combination for the variant,
                // e.g. {"Color": "Red", "Size": "S"}. Generic so it also
                // supports attributes added via "Add Attribute".
                if (!Schema::hasColumn('product__variants', 'attributes')) {
                    $table->json('attributes')->nullable()->after('qr_code');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product__variants')) {
            Schema::table('product__variants', function (Blueprint $table) {
                if (Schema::hasColumn('product__variants', 'attributes')) {
                    $table->dropColumn('attributes');
                }
            });
        }
    }
};
