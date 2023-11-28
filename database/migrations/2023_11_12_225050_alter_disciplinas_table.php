<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disciplinas', function (Blueprint $table) {
            $table->unsignedBigInteger('grupo_disciplina_id')->after('id');
            // 2. Create foreign key constraints
            $table  ->foreign('grupo_disciplina_id')
                    ->references('id')
                    ->on('grupo_disciplinas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['grupo_disciplina_id']);
        // 2. Drop the column
        $table->dropColumn('grupo_disciplina_id');
    }
}
