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
        Schema::table('days_stocks', function (Blueprint $table) {
            $table->integer('firm_id')->nullable();
            $table->index('firm_id');
        });
        Schema::table('end_of_days', function (Blueprint $table) {
            $table->integer('firm_id')->nullable();
            $table->index('firm_id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('firm_id')->nullable();
            $table->index('firm_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
