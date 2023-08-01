<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Aula;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Professor\Atendimento\ChamarAtendimentoRequest;
use App\Models\Disciplina;
use App\Models\Turma;
use App\Models\Unidade;

class AtendimentoController extends Controller
{
    private $atendimento;
    private $sala;
    private $turma;
    private $params;
    private $unidade;
    private $disciplina;

    public function __construct(Atendimento $atendimentos, Aula $aulas, Sala $salas, Unidade $unidades, Turma $turmas, Disciplina $disciplinas)
    {
        $this->atendimento = $atendimentos;
        $this->unidade = $unidades;
        $this->sala = $salas;
        $this->turma = $turmas;
        $this->disciplina = $disciplinas;

        // Default values
        $this->params['titulo']='Atendimento';
        $this->params['main_route']='professor.atendimento';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'professor/atendimento',
                    'titulo' => 'Unidade'
        ];

        $params = $this->params;
        $data['unidades'] =  $this->unidade->all();

        return view('professor.atendimento.unidade',compact('params','data'));
    }

    public function unidade($unidade_id)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Unidade';
        $this->params['arvore'][0] = [
                    'url' => 'professor/atendimento',
                    'titulo' => 'Unidade'
        ];
        $unidade =  $this->unidade->find($unidade_id);

        $this->params['arvore'][1] = [
                    'url' => 'professor/atendimento/unidade/'.$unidade_id,
                    'titulo' => $unidade['titulo']
        ];

        $params = $this->params;
        $data['turmas'] =  $this->turma->where('unidade_id',$unidade_id)->get();
        $data['unidade_id']= $unidade_id;
        return view('professor.atendimento.turma',compact('params','data'));
    }

    public function turma($unidade_id, $turma_id)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'professor/atendimento',
                    'titulo' => 'Unidade'
        ];
        // Get Unidade
        $unidade =  $this->unidade->find($unidade_id);
        $this->params['arvore'][1] = [
            'url' => 'professor/atendimento/unidade/'.$unidade_id,
            'titulo' => $unidade['titulo']
        ];

        // Get Turma
        $turma =  $this->turma->find($turma_id);
        $this->params['arvore'][2] = [
                    'url' => 'professor/atendimento/unidade/'.$unidade_id.'/turma/'.$turma_id,
                    'titulo' => $turma['titulo']
        ];

        $params = $this->params;
        $data['salas'] =  $this->sala->where('turma_id',$turma_id)->get();
        $data['unidade_id']= $unidade_id;
        $data['turma_id']= $turma_id;

        return view('professor.atendimento.sala',compact('params','data'));
    }

    public function sala($unidade_id, $turma_id, $sala_id)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'professor/atendimento',
                    'titulo' => 'Atendimento'
        ];

        // Get Unidade
        $unidade =  $this->unidade->find($unidade_id);
        $this->params['arvore'][1] = [
            'url' => 'professor/atendimento/unidade/'.$unidade_id,
            'titulo' => $unidade['titulo']
        ];

        // Get Turma
        $turma =  $this->turma->find($turma_id);
        $this->params['arvore'][2] = [
                    'url' => 'professor/atendimento/unidade/'.$unidade_id.'/turma/'.$turma_id,
                    'titulo' => $turma['titulo']
        ];

        // Get Sala
        $sala =  $this->sala->find($sala_id);
        $this->params['arvore'][3] = [
                    'url' => 'professor/atendimento/unidade/'.$unidade_id.'/turma/'.$turma_id.'/sala/'.$sala_id,
                    'titulo' => $sala['titulo']
        ];

        $params = $this->params;
        $data['sala'] =  $this->sala->find($sala_id);
        $preload['disciplinas'] = $this->disciplina->select('id','titulo')->orderBy('titulo')->pluck('titulo','id');
        $data['sala'] =  $this->sala->find($sala_id);
        $data['unidade_id']= $unidade_id;
        $data['turma_id']= $turma_id;
        $data['sala_id']= $sala_id;

        return view('professor.atendimento.index',compact('params','data','preload'));
    }

    public function chamar(ChamarAtendimentoRequest  $request)
    {

         // PARAMS DEFAULT
         $this->params['subtitulo']='Atendimentos';
         $this->params['arvore'][0] = [
                     'url' => 'admin/atendimento',
                     'titulo' => 'Atendimento'
         ];

        $params = $this->params;

       $dataForm  = $request->all();

        if($this->atendimento->chamarProximo($dataForm['aula_id'])){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.chamar')->withErrors(['Falha ao editar.']);
        }


    }

    public function pausar(ChamarAtendimentoRequest  $request)
    {

         // PARAMS DEFAULT
         $this->params['subtitulo']='Atendimentos';
         $this->params['arvore'][0] = [
                     'url' => 'admin/atendimento',
                     'titulo' => 'Atendimento'
         ];

        $params = $this->params;

        $dataForm  = $request->all();

        if($this->atendimento->pausarAtendimento($dataForm['aula_id'])){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao pausar.']);
        }


    }

    public function finalizar(ChamarAtendimentoRequest  $request)
    {

         // PARAMS DEFAULT
         $this->params['subtitulo']='Atendimentos';
         $this->params['arvore'][0] = [
                     'url' => 'admin/atendimento',
                     'titulo' => 'Atendimento'
         ];

        $params = $this->params;

        $dataForm  = $request->all();

        if($this->atendimento->finalizarAtendimento($dataForm['aula_id'])){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao finalizar atendimento.']);
        }


    }



}
