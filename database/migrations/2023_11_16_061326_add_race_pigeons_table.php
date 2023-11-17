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
        Schema::create('race_pigeons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('race_id');
            $table->unsignedBigInteger('pigeon_id');
            $table->string('speed')->nullable();
            $table->string('start_date_time')->nullable();
            $table->string('end_date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_pigeons');
    }
};
