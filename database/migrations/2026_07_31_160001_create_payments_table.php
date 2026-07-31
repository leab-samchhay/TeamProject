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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('MethodID')->constrained('payment_methods', 'id')->onDelete('cascade');
            $table->foreignId('InvoiceID')->constrained('invoices', 'id')->onDelete('cascade');
            $table->decimal('TotalPayment', 18, 6);
            $table->date('PaymentDate');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
