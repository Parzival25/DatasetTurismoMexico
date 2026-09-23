<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regiones_gastronomicas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->string('imagen')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('platillos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_gastronomica_id')->constrained('regiones_gastronomicas')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('imagen');
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platillos');
        Schema::dropIfExists('regiones_gastronomicas');
    }
};
