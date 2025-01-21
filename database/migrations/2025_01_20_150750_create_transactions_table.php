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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->unsignedBigInteger("product_id")->nullable();
            $table->unsignedBigInteger("supplier_id")->nullable();
            $table->string("type")->nullable();
            $table->integer("quantity")->nullable();
            $table->integer("stock_before")->nullable();
            $table->integer("stock_after")->nullable();
            $table->unsignedBigInteger("created_by_id")->nullable();
            $table->dateTime("transaction_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
