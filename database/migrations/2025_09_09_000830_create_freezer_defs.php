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
        Schema::create('freezer_defs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('create_user_id');
            $table->integer('update_user_id')->nullable();

            $table->string('name');

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freezer_defs');
    }
};
