<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pigeons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('ring_number')->nullable();
            $table->string('color_description')->nullable();
            $table->string('status')->nullable();
            $table->enum('sex', [
                'cock',
                'hen'
            ])->default('cock');
            $table->longText('notes');
            $table->date('date_hatched')->nullable();
            $table->unsignedBigInteger('dam_id')->nullable();
            $table->unsignedBigInteger('sire_id')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->string('img_url')->nullable();

            $table->index(['dam_id', 'sire_id', 'owner_id']);

            $table->foreign('dam_id')->references('id')
                ->on('pigeons')->onDelete('cascade');
            $table->foreign('sire_id')->references('id')
                ->on('pigeons')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')
                ->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pigeons');
    }
};
