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
            $table->unsignedBigInteger("supplier_id")->nullable();
            $table->string("period");
            $table->integer("actual")->nullable()->comment("This is data of actual sales");
            $table->integer("actual_restock")->nullable()->comment("This is data of actual restock that will increase data in table product");
            $table->integer("prediction")->nullable();
            $table->integer("safety_stock")->nullable();
            $table->integer("purchasing_plan")->nullable()->comment("this is final data that will be use as reference to restock");
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
