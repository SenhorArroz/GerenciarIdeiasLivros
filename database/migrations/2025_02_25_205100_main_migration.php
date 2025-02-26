<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug');
            $table->text('sinopse');
            $table->timestamps();
        });
        Schema::create('capas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->timestamps();
        });

        Schema::create('personagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->string('nome');
            $table->integer('idade')->nullable();
            $table->text('descricao');
            $table->string('imagem')->nullable();
            $table->timestamps();
        });

        Schema::create('locais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->string('nome');
            $table->text('descricao');
            $table->string('imagem')->nullable()->default('localizacao.png');
            $table->timestamps();
        });

        Schema::create('capitulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->integer('numero');
            $table->string('nome');
            $table->text('descricao');
            $table->timestamps();
        });

        Schema::create('ideias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->timestamps();
        });

        Schema::create('anotacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->timestamps();
        });

        Schema::create('ilustracoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->string('imagem');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ilustracoes');
        Schema::dropIfExists('anotacoes');
        Schema::dropIfExists('ideias');
        Schema::dropIfExists('capitulos');
        Schema::dropIfExists('locais');
        Schema::dropIfExists('personagens');
        Schema::dropIfExists('livros');
    }
};
