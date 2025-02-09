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
        Schema::create('forecasting', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger("product_id");
            $table->string("period");
            $table->integer("actual")->nullable();
            $table->integer("actual_restock")->nullable();
            $table->integer("prediction")->nullable();
            $table->integer("safety_stock")->nullable();
            $table->integer("purchasing_plan")->nullable();
            $table->decimal("mad", 14,2)->nullable();
            $table->decimal("mse", 14,2)->nullable();
            $table->decimal("mape")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecasting');
    }
};
