<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('origenes', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('carpeta_legado')->nullable();
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('color', 7)->default('#1f4d3a');
            $table->string('icono', 30)->default('punto');
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('subcategorias', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('atomos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('localizacion')->nullable();
            $table->text('como_llegar')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->boolean('activo')->default(true)->index();
            $table->foreignId('origen_id')->nullable()->constrained('origenes')->nullOnDelete();
            $table->unsignedInteger('numero_original')->nullable();
            $table->string('legado_activo', 10)->nullable();
            $table->text('busqueda')->nullable();
            $table->timestamps();
        });

        Schema::create('atomo_categoria', function (Blueprint $table) {
            $table->foreignId('atomo_id')->constrained('atomos')->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->primary(['atomo_id', 'categoria_id']);
        });

        Schema::create('atomo_subcategoria', function (Blueprint $table) {
            $table->foreignId('atomo_id')->constrained('atomos')->cascadeOnDelete();
            $table->foreignId('subcategoria_id')->constrained('subcategorias')->cascadeOnDelete();
            $table->primary(['atomo_id', 'subcategoria_id']);
        });

        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atomo_id')->constrained('atomos')->cascadeOnDelete();
            $table->text('descripcion');
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('localizacion')->nullable();
            $table->text('como_llegar')->nullable();
            $table->text('actividades')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->date('fecha')->nullable();
            $table->string('periodo')->nullable();
            $table->boolean('recurrente')->default(true);
            $table->boolean('activo')->default(true)->index();
            $table->text('busqueda')->nullable();
            $table->timestamps();
        });

        Schema::create('evento_subcategoria', function (Blueprint $table) {
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->foreignId('subcategoria_id')->constrained('subcategorias')->cascadeOnDelete();
            $table->primary(['evento_id', 'subcategoria_id']);
        });

        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->morphs('propietario');
            $table->string('ruta');
            $table->string('ruta_miniatura')->nullable();
            $table->string('mime', 50)->default('image/jpeg');
            $table->unsignedInteger('ancho')->nullable();
            $table->unsignedInteger('alto')->nullable();
            $table->unsignedInteger('bytes')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->string('credito')->nullable();
            $table->string('archivo_original')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos');
        Schema::dropIfExists('evento_subcategoria');
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('actividades');
        Schema::dropIfExists('atomo_subcategoria');
        Schema::dropIfExists('atomo_categoria');
        Schema::dropIfExists('atomos');
        Schema::dropIfExists('subcategorias');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('origenes');
    }
};
