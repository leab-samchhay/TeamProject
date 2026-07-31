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
        Schema::create('puchases', function (Blueprint $table) {
            $table->id();
            $table->string('buillno');
            $table->date('puchaseDate');

            $table->foreignId('supplierId')
                ->constrained('suppliers')
                ->cascadeOnDelete();

            $table->foreignId('userId')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('totalAmount', 18, 6);
            $table->decimal('discound', 18, 6);
            $table->boolean('status')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puchases');
    }
};
