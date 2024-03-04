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
        Schema::create('car_properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->Integer('typeApp');
            $table->string('name');
            $table->string('value');
            $table->timestamps();

            $table->foreignUuid('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_properties');
    }
};
