<?php

namespace App\Http\Controllers\Professor;

use App\Events\AulasAtivasEvent;
use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Atendimento;
use App\Models\Disciplina;
use App\Models\Professor;
use App\Models\Sala;
use Auth;
use App\Http\Requests\Professor\Aula\AulaInsertRequest;

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
        $data = $this->aula->orderBy('inicio','desc')->orderBy('status','desc')->paginate(10);

        return view('professor.aula.index',compact('params','data'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Aula';
        $this->params['arvore']=[
           [
               'url' => 'professor/aula',
               'titulo' => 'Aula'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;

       $preload['disciplinas'] = $this->disciplina->orderBy('titulo')->get()->pluck('titulo','id');
       $preload['professores'] = $this->professor->where('id',Auth::User()->id)->orderBy('name')->get()->pluck('name','id');
       $preload['salas'] = $this->sala->orderBy('titulo')->get()->pluck('titulo','id');

       return view('professor.aula.create',compact('params','preload'));
    }

    public function store(AulaInsertRequest $request)
    {
        $dataForm  = $request->all();
        if($this->aula->cadastrarAulaProfessor($dataForm)){
            if($this->atendimento->setAtendido()){
                return redirect()->route('professor.atendimento.index');
            }
        }
        return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);

    }

}
