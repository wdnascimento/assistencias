<?php

namespace Database\Seeders;

use App\Models\Professor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id, name, email, password, remember_token, created_at, updated_at, deleted_at

        $table = new Professor();
        $table->create(["name" => "ANDREIA CHRISTINA IGNACIO", "email" => "AIgnacio@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "AURELIO ANTONIO LEAL", "email" => "aaleal@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "CEZAR LUIZ DE CARVALHO", "email" => "cezarc@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "CLAUDIA REGINA TEIXEIRA ROCHA", "email" => "claudiar@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "CLAUDIO DAVI DOS SANTOS", "email" => "claudio.santos@colegiopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "CLEITON JOACIR CARON", "email" => "cleitonc@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "CRISTIANE LYZNIK", "email" => "cristiane.lyznik@colegiopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "ELISON WALCIMAR MOLETTA", "email" => "Elisonw@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "ELIZABETH FRANCIS BENEVIDES", "email" => "ebenevides@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "GUSTAVO PIRATELLO DE CASTRO", "email" => "gpiratello@gmail.com", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "JOSE GILBERTO SAMPAIO RIBEIRO", "email" => "joser@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "LETICIA MARINA KOLB", "email" => "lmkolb@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "LIANE GRASSMANN USINGER", "email" => "lianeg@cursopositivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "ROBERTO ROCHA", "email" => "rrocha@positivo.com.br", "password" => Hash::make("positivo@2024")]);
        $table->create(["name" => "SUZELEI APARECIDA CARVALHO ROSALES", "email" => "suzelei.rosales@colegiopositivo.com.br", "password" => Hash::make("positivo@2024")]);
    }
}
