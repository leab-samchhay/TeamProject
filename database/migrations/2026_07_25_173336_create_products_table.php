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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ProName', 200);
            $table->string('ProNameKh', 200)->nullable();
            $table->string('Barcode', 100)->unique()->nullable();
            $table->integer('Qty_Onhand')->nullable();
            $table->integer('Qty_Alert')->nullable();
            $table->decimal('price',18,6);
            $table->string('Remark', 200)->nullable();
            $table->string('Photo')->nullable();
            $table->date('ReleaseDate')->nullable();
            $table->date('ExpiredDate')->nullable();
            $table->boolean('Status')->default(true);

            $table->foreignId('CategoryID')->constrained('categories', 'id')->onDelete('cascade');
            $table->foreignId('SupplierID')->constrained('suppliers', 'id')->onDelete('cascade');
            $table->foreignId('UnitypeID')->constrained('unitypes', 'id')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
