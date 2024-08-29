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
        //
        Schema::table('reports', function (Blueprint $table) {
            $table->decimal('total_sales', 15, 2)->default(0)->change();
            $table->decimal('total_cost', 15, 2)->default(0)->change();
            $table->decimal('total_tax', 15, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('reports', function (Blueprint $table) {
            // Opcional: Revertir los cambios si es necesario
            $table->decimal('total_sales', 15, 2)->nullable(false)->change();
            $table->decimal('total_cost', 15, 2)->nullable(false)->change();
            $table->decimal('total_tax', 15, 2)->nullable(false)->change();
        });
    }
};
