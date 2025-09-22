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
        Schema::create('custom_order_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('create_user_id');
            $table->integer('update_user_id')->nullable();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('amount');

            $table->index('id');
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_order_products');
    }
};
