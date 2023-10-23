<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atendimento;
use App\Models\Aula;
use App\Models\Sala;
use App\Models\Turma;
use App\Models\Unidade;

class AtendimentoController extends Controller
{
    public function __construct(Atendimento $atendimentos, Aula $aulas, Sala $salas, Unidade $unidades, Turma $turmas)
    {
        $this->atendimento = $atendimentos;
        $this->aula = $aulas;
        $this->unidade = $unidades;
        $this->sala = $salas;
        $this->turma = $turmas;

        // Default values
        $this->params['titulo']='Atendimentos';
        $this->params['main_route']='admin.atendimento';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'admin/atendimento',
                    'titulo' => 'Unidade'
        ];

        $params = $this->params;
        $data['unidades'] =  $this->unidade->all();

        return view('admin.atendimento.unidade',compact('params','data'));
    }

    public function unidade($unidade_id)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Unidade';
        $this->params['arvore'][0] = [
                    'url' => 'admin/atendimento',
                    'titulo' => 'Unidade'
        ];
        $unidade =  $this->unidade->find($unidade_id);

        $this->params['arvore'][1] = [
                    'url' => 'admin/atendimento/unidade/'.$unidade_id,
                    'titulo' => $unidade['titulo']
        ];

        $params = $this->params;
        $data['turmas'] =  $this->turma->where('unidade_id',$unidade_id)->orderBy('titulo')->get();
        $data['unidade_id']= $unidade_id;
        return view('admin.atendimento.turma',compact('params','data'));
    }

    public function turma($unidade_id, $turma_id)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'admin/atendimento',
                    'titulo' => 'Unidade'
        ];
        // Get Unidade
        $unidade =  $this->unidade->find($unidade_id);
        $this->params['arvore'][1] = [
            'url' => 'admin/atendimento/unidade/'.$unidade_id,
            'titulo' => $unidade['titulo']
        ];

        // Get Turma
        $turma =  $this->turma->find($turma_id);
        $this->params['arvore'][2] = [
                    'url' => 'admin/atendimento/unidade/'.$unidade_id.'/turma/'.$turma_id,
                    'titulo' => $turma['titulo']
        ];

        $params = $this->params;
        $data['salas'] =  $this->sala->where('turma_id',$turma_id)->orderBy('titulo')->get();
        $data['unidade_id']= $unidade_id;
        $data['turma_id']= $turma_id;

        return view('admin.atendimento.sala',compact('params','data'));
    }

    public function salas($unidade_id, $turma_id, $sala_id)
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
}
