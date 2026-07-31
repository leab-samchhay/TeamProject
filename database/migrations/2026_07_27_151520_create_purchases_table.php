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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('billno');
            $table->date('purchaseDate');

            $table->foreignId('supplierId')
                ->constrained('suppliers')
                ->cascadeOnDelete();

            $table->foreignId('userId')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('totalAmount', 18, 6);
            $table->decimal('discount', 18, 6);
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
        Schema::dropIfExists('purchases');
    }
};
