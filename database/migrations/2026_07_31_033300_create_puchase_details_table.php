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
        Schema::create('puchase_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('cost')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('discound')->nullable();
            
            $table->foreignId('puchaseID')
                ->constrained('puchases')
                ->cascadeOnDelete();

            $table->foreignId('productID')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puchase_details');
    }
};
