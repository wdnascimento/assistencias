<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('disciplina_id')->unsigned();
            $table->bigInteger('professor_id')->unsigned();
            $table->bigInteger('sala_id')->unsigned();

            $table->datetime('inicio')->useCurrent();
            $table->datetime('fim')->nullable()->default(NULL);

            $table->boolean('status')->default(true);
            $table  ->foreign('disciplina_id')
                    ->references('id')->on('disciplinas')
                    ->onDelete('cascade');
            $table  ->foreign('professor_id')
                    ->references('id')->on('professors')
                    ->onDelete('cascade');
            $table  ->foreign('sala_id')
                    ->references('id')->on('salas')
                    ->onDelete('cascade');
            $table->string('created_by');
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
        Schema::dropIfExists('aulas');
    }
}
