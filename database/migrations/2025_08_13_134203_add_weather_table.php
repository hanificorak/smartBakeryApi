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
         Schema::create('weather_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('code_start');
            $table->integer('code_end')->nullable();
            $table->string('description');
            $table->timestamps();
        });

         DB::table('weather_codes')->insert([
            ['code_start' => 0, 'code_end' => 0, 'description' => 'Açık (Clear)'],
            ['code_start' => 1, 'code_end' => 1, 'description' => 'Az bulutlu'],
            ['code_start' => 2, 'code_end' => 2, 'description' => 'Bulutlu'],
            ['code_start' => 3, 'code_end' => 3, 'description' => 'Parçalı bulutlu'],
            ['code_start' => 45, 'code_end' => 45, 'description' => 'Sis'],
            ['code_start' => 48, 'code_end' => 48, 'description' => 'Çiy'],
            ['code_start' => 51, 'code_end' => 57, 'description' => 'Hafif yağmur'],
            ['code_start' => 61, 'code_end' => 67, 'description' => 'Yağmur'],
            ['code_start' => 71, 'code_end' => 77, 'description' => 'Kar'],
            ['code_start' => 80, 'code_end' => 82, 'description' => 'Sağanak'],
            ['code_start' => 95, 'code_end' => 99, 'description' => 'Fırtına'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
