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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Guarda qué operario hizo el movimiento
            $table->enum('type', ['in', 'out', 'adjustment']); // Entrada, Salida, o Ajuste (sobrante/faltante en conteo)
            $table->integer('quantity'); // Cuántos artículos entraron o salieron
            $table->string('reference_note')->nullable(); // Razón (ej: "Llegada proveedor", "Merma")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
