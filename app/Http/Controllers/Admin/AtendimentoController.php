<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Aula;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AtendimentoController extends Controller
{
    public function __construct(Atendimento $atendimentos, Aula $aulas, Sala $salas, User $alunos)
    {
        $this->atendimento = $atendimentos;
        $this->aula = $aulas;
        $this->sala = $salas;
        $this->aluno = $alunos;

        // Default values
        $this->params['titulo']='Disciplina';
        $this->params['main_route']='admin.disciplina';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'admin/atendimento',
                    'titulo' => 'Atendimento'
        ];

        $params = $this->params;
        $data = DB::table('aulas')
                    ->join('salas', 'salas.id', '=', 'aulas.sala_id')
                    ->leftJoin('atendimentos', 'atendimentos.aula_id', '=', 'aulas.id')
                    ->join('users', 'users.id' , 'atendimentos.user_id')
                    ->select('*')
                    ->where('aulas.status','1')
                    ->orderBy('salas.id')
                    ->get();
        return view('admin.atendimento.index',compact('params','data'));
    }
}
