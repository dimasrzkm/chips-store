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
            $table->foreignId('konsinyor_id')->nullable()->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->string('name');
            $table->float('initial_price', 8, 2);
            $table->float('percentage_profit', 8, 2);
            $table->float('sale_price', 8, 2);
            $table->float('stock', 8, 2);
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
