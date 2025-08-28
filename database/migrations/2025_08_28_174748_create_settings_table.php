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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('create_user_id');
            $table->integer('update_user_id')->nullable();

            $table->integer('firm_id');
            $table->string('company_title');
            $table->string('company_address');
            $table->string('company_phone');

            $table->index('id');
            $table->index('firm_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
