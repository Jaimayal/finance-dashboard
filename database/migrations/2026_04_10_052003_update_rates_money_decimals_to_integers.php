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
        Schema::table('rates', function (Blueprint $table) {
            $table->unsignedInteger('min_amount')->nullable()->change();
            $table->unsignedInteger('max_amount')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->decimal('min_amount', 15, 2)->nullable()->change();
            $table->decimal('max_amount', 15, 2)->nullable()->change();
        });
    }
};
