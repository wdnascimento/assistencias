<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use Illuminate\Database\Seeder;

class DisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new Disciplina();
        $table->create(["titulo" => "QUÍMICA"]);
        $table->create(["titulo" => "MATEMÁTICA"]);
        $table->create(["titulo" => "PORTUGUÊS"]);
        $table->create(["titulo" => "HISTÓRIA"]);
        $table->create(["titulo" => "GEOGRAFIA"]);
        $table->create(["titulo" => "REDAÇÃO"]);

    }
}
