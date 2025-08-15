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
        Schema::create('end_of_days', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('create_user_id');
            $table->integer('update_user_id')->nullable();

            $table->integer('product_id');
            $table->integer('current');
            $table->integer('amount');
            $table->integer('day_stock_id');
            $table->integer('weather_code');
            $table->decimal('temperature', 4, 1)->nullable();;

            $table->index('id');
            $table->index('product_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('end_of_days');
    }
};
