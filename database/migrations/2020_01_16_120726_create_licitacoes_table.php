<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('numero');
            $table->text('objeto');
            $table->integer('qtd_itens');
            $table->integer('situacao');
            $table->string('modalidade');
            $table->string('local');
            $table->string('cidade');
            $table->dateTime('data_abertura');
            $table->string('contato');
            $table->string('valor_estimado');
            $table->string('impugnacoes');
            $table->string('nome_vendedor');
            $table->integer('modalidade_id')->unsigned();
            $table->foreign('modalidade_id')->references('id')->on('modalidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licitacaos');
    }
}
