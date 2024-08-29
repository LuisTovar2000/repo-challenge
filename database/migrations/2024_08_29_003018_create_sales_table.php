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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que realiza la compra
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Producto comprado
            $table->integer('quantity'); // Cantidad de productos comprados
            $table->string('currency'); // Moneda utilizada
            $table->decimal('total_price', 10, 2); // Precio total

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
