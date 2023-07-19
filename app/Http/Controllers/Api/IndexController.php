<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Atendimento;
use App\Models\Aula;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __construct(Atendimento $atendimentos, Aula $aulas, Sala $salas, User $alunos)
    {
        $this->atendimento = $atendimentos;
        $this->aula = $aulas;
        $this->sala = $salas;
        $this->aluno = $alunos;
    }

    public function atendimentos($sala_id){

        /*
            SELECT * FROM atendimentos at
                INNER JOIN aulas au
                ON au.id = at.aula_id
                WHERE au.sala_id = 2
                AND au.status = 1
                AND au.status IN (0,1)
                ORDER BY at.ordem, at.status desc
        */


        $data = DB::table('aulas','au')
                ->join('professors as pr', 'pr.id' , 'au.professor_id')
                ->join('disciplinas as di', 'di.id' , 'au.disciplina_id')
                ->leftJoin('atendimentos as at', function ($join) {
                        $join->on('at.aula_id', '=', 'au.id')
                        ->whereIn('at.status',[0,1]);
                        })
                ->leftJoin('users as us', 'us.id' , 'at.user_id')
                ->select('au.id as aula_id', 'at.id as atendimento_id', 'au.status as status_aula', 'au.sala_id as sala_id' , 'at.status as status', DB::raw("SUBSTRING_INDEX(pr.name, ' ', 1) as professor"),  DB::raw("SUBSTRING_INDEX(us.name, ' ', 1) as nome"), 'us.name as nome_completo',  'us.numero as numero', 'us.cabine as cabine', 'di.titulo as titulo_disciplina')
                ->where('au.sala_id',$sala_id)
                ->where('au.status',1)
                ->orderBy('at.ordem')
                ->orderBy('at.status', 'desc')
                ->paginate(5);


        return $data;
    }
}
