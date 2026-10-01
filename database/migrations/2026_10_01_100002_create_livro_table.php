<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro', function (Blueprint $table) {
            $table->increments('idlivro');
            $table->string('titulo', 255);
            $table->string('isbn', 45)->nullable();
            $table->integer('anopublicacao')->nullable();
            $table->string('descricao', 255)->nullable();
            $table->integer('paginas')->nullable();
            $table->unsignedInteger('idautor');
            $table->unsignedInteger('idcategoria');

            $table->foreign('idautor')->references('idautor')->on('autor');
            $table->foreign('idcategoria')->references('idcategoria')->on('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro');
    }
};
