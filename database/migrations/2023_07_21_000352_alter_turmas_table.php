<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->unsignedBigInteger('unidade_id')->after('id');
            // 2. Create foreign key constraints
            $table  ->foreign('unidade_id')
                    ->references('id')
                    ->on('unidades')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('turmas', function (Blueprint $table) {
            // 1. Drop foreign key constraints
            $table->dropForeign(['unidade_id']);

            // 2. Drop the column
            $table->dropColumn('unidade_id');
        });

    }
}
