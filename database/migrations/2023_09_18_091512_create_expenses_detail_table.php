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
        Schema::create('expenses_detail', function (Blueprint $table) {
            $table->foreignId('expense_id')->constrained('expenses', 'id')->onDelete('cascade');
            $table->foreignId('stock_id')->constrained('stocks', 'id')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'id')->onDelete('cascade');
            $table->string('product_name');
            $table->string('stock_name');
            $table->float('total_used', 8, 2);
            $table->string('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses_detail');
    }
};
