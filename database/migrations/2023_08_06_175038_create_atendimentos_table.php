<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ordem');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('aula_id');
            $table->integer('status')->default(0);
            $table->datetime('hora_solicitacao')->nullable();
            $table->datetime('hora_atendimento')->nullable();
            $table->datetime('hora_termino')->nullable();

            $table  ->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table  ->foreign('aula_id')
                    ->references('id')->on('aulas')
                    ->onDelete('cascade');
            $table  ->unique(['ordem','user_id','aula_id','status'] );
            $table->softDeletes();
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
        Schema::dropIfExists('atendimentos');
    }
}
