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
        Schema::create('puchase_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('MethodID')->constrained('payment_methods', 'id')->onDelete('cascade');
            $table->foreignId('PuchaseID')->constrained('puchases', 'id')->onDelete('cascade');
            $table->decimal('TotalPayment', 18, 6);
            $table->date('PuchaseDate');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puchase_payments');
    }
};
