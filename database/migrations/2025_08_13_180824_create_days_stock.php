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
        Schema::create('days_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('create_user_id');
            $table->integer('update_user_id')->nullable();

            $table->integer('product_id');
            $table->integer('weather_id');
            $table->integer('amount');
            $table->string('desc')->nullable();

            $table->index('id');
            $table->index('product_id');
            $table->index('weather_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days_stocks');
    }
};
