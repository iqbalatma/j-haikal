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
            $table->decimal("actual")->nullable();
            $table->decimal("prediction")->nullable();
            $table->decimal("mad")->nullable();
            $table->decimal("mse")->nullable();
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
