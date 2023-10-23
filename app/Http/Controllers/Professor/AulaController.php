<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Atendimento;
use App\Models\Disciplina;
use App\Models\Professor;
use App\Models\Sala;
use Auth;

class AulaController extends Controller
{
    public $aula ;
    public $atendimento ;
    public $disciplina ;
    public $professor ;
    public $sala ;
    public $params ;


    public function __construct(Aula $aulas, Atendimento $atendimentos, Disciplina $disciplinas, Professor $professores, Sala $salas)
    {
        $this->aula = $aulas;
        $this->atendimento = $atendimentos;
        $this->disciplina = $disciplinas;
        $this->professor = $professores;
        $this->sala = $salas;

        $this->params['titulo']='Aula';
        $this->params['main_route']='professor.aula';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Aulas Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'professor/aula',
                    'titulo' => 'Aulas'
        ];

        $params = $this->params;
        $data = $this->aula
                        ->where('professor_id', Auth::user()->id)
                        ->with('atendidos')
                        ->with('naoAtendidos')
                        ->with('senhas')
                        ->with('desistentes')
                        ->orderBy('inicio','desc')
                        ->orderBy('status','desc')
                        ->paginate(20);
        return view('professor.aula.index',compact('params','data'));
    }

 }
