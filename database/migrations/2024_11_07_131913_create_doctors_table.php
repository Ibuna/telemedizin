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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('specialization_id');
            $table->timestamps();

            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};