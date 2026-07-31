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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('InvoiceID')->constrained('invoices', 'id')->onDelete('cascade');
            $table->foreignId('ProductID')->constrained('products', 'id')->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->decimal('price',18,6)->nullable();
            $table->decimal('cost',18,6)->nullable();
            $table->decimal('totalPay',18,6)->nullable();
            $table->integer('discount')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
