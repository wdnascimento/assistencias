<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrupoDisciplina;
use App\Http\Requests\Admin\GrupoDisciplina\GrupoDisciplinaRequest ;
use App\Http\Requests\Admin\GrupoDisciplina\GrupoDisciplinaUpdateRequest;

class GrupoDisciplinaController extends Controller
{

    public function __construct(GrupoDisciplina $grupo_disciplinas)
    {
        $this->grupo_disciplina = $grupo_disciplinas;

        // Default values
        $this->params['titulo']='Grupo de Disciplina';
        $this->params['main_route']='admin.grupo_disciplina';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Grupo de Disciplinas Cadastradas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/disciplina',
                    'titulo' => 'Grupo de Disciplina'
        ];

        $params = $this->params;
        $data = $this->grupo_disciplina->orderBy('titulo')->get();

        return view('admin.grupo_disciplina.index',compact('params','data'));
    }

    public function create()
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Cadastrar Grupo de Disciplina';
         $this->params['arvore']=[
            [
                'url' => 'admin/disciplina',
                'titulo' => 'Grupo Disciplina'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]];
        $params = $this->params;
        return view('admin.grupo_disciplina.create',compact('params'));
    }

    public function store(GrupoDisciplinaRequest $request)
    {
        $dataForm  = $request->all();

        $insert = $this->grupo_disciplina->create($dataForm);
        if($insert){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function show($id)
    {
        $this->params['subtitulo']='Deletar Grupo de Disciplina';
        $this->params['arvore']=[
           [
               'url' => 'admin/disciplina',
               'titulo' => 'Grupo de Disciplina'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->grupo_disciplina->find($id);
       return view('admin.grupo_disciplina.show',compact('params','data'));
    }

    public function edit($id)
    {
        $this->params['subtitulo']='Editar Grupo de Disciplina';
        $this->params['arvore']=[
           [
               'url' => 'admin/disciplina',
               'titulo' => 'Grupo de Disciplina'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->grupo_disciplina->find($id);
       return view('admin.grupo_disciplina.create',compact('params', 'data'));
    }

    public function update(GrupoDisciplinaUpdateRequest $request, $id)
    {
        $data = $this->grupo_disciplina->find($id);

        if($data->update($request->all())){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->grupo_disciplina->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
