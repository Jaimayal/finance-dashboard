<?php

use App\Models\Institution;
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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Institution::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('annual_rate', 10, 2);
            /*
            Define como se determina cual tasa aplica:
            - amount (monto): Rangos de monto, ej: Cuenta Open+ de 40,001 a $1,000,000
            - term (plazo): Rangos de plazo, ej: Inversion a 91 dias
            - none
            */
            $table->string('type');

            // Rango de monto, aplicado cuanto type es amount
            $table->decimal('min_amount', 15, 2)->nullable();
            $table->decimal('max_amount', 15, 2)->nullable();

            // Cantidad de dias de la rate
            $table->integer('days')->nullable();

            // Orden para asignacion automatica de tasas
            $table->integer('sort_order')->nullable();

            /*
            Ej: Solo aplica hasta $40,000 MXN. Gat Nominal 13.88%
            */
            $table->text('description')->nullable();

            $table->string('frecuency')->nullable(); // Daily, monthly, simple

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
