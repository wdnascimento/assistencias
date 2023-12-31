<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Turma\TurmaRequest;
use App\Models\Turma;
use App\Models\Unidade;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function __construct(Turma $turmas , Unidade $unidades)
    {
        $this->turma = $turmas;
        $this->unidade = $unidades;

        // Default values
        $this->params['titulo']='Turma';
        $this->params['main_route']='admin.turma';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Turmas Cadastradas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/turma',
                    'titulo' => 'Turma'
        ];

        $params = $this->params;
        $data = $this->turma->all();

        return view('admin.turma.index',compact('params','data'));
    }

    public function create()
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Cadastrar Turma';
         $this->params['arvore']=[
            [
                'url' => 'admin/turma',
                'titulo' => 'Turma'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]];
        $params = $this->params;
        $preload['unidades'] = $this->unidade->orderBy('titulo')->get()->pluck('titulo','id');
        return view('admin.turma.create',compact('params','preload'));
    }

    public function store(TurmaRequest $request)
    {
        $dataForm  = $request->all();
        $dataForm['status'] = isset($dataForm['status']) ? 1 : 0;

        $insert = $this->turma->create($dataForm);
        if($insert){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function edit($id)
    {
        $this->params['subtitulo']='Editar Turma';
        $this->params['arvore']=[
           [
               'url' => 'admin/turma',
               'titulo' => 'Turma'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->turma->find($id);
       $preload['unidades'] = $this->unidade->orderBy('titulo')->get()->pluck('titulo','id');
       return view('admin.turma.create',compact('params', 'data','preload'));
    }

    public function update(TurmaRequest $request, $id)
    {
        $data = $this->turma->find($id);
        $dataForm = $request->all();
        $dataForm['status'] = isset($dataForm['status']) ? 1 : 0;

        if($data->update($dataForm)){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }
}
