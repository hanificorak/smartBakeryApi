<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `freezers` DROP COLUMN `name`, ADD COLUMN `fr_id` int NOT NULL AFTER `desc`;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
