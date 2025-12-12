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
        if (!Schema::hasTable('KeyGenTokens')) {
            Schema::create('KeyGenTokens', function (Blueprint $table) {
                $table->string('token', 120)->primary();
                $table->string('app_id', 40);
                $table->engine = 'InnoDB';
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('KeyGenTokens');
    }
};
