<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertsTableCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            INSERT INTO `tabela_codes` (`pai`,`item`,`valor`,`descricao`,`created_at`,`updated_at`) VALUES (1,1,'2023','2023',NOW(),NOW());
            INSERT INTO `tabela_codes` (`pai`,`item`,`valor`,`descricao`,`created_at`,`updated_at`) VALUES (1,2,'2024','2024',NOW(),NOW());
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("TRUNCATE tabela_codes");
    }
}
