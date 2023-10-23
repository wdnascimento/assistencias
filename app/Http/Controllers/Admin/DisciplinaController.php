<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disciplina;
use App\Http\Requests\Admin\Disciplina\DisciplinaRequest ;
use App\Http\Requests\Admin\Disciplina\DisciplinaUpdateRequest;

class DisciplinaController extends Controller
{

    public function __construct(Disciplina $disciplinas)
    {
        $this->disciplina = $disciplinas;

        // Default values
        $this->params['titulo']='Disciplina';
        $this->params['main_route']='admin.disciplina';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Disciplinas Cadastradas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/disciplina',
                    'titulo' => 'Disciplina'
        ];

        $params = $this->params;
        $data = $this->disciplina->orderBy('titulo')->get();

        return view('admin.disciplina.index',compact('params','data'));
    }

    public function create()
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Cadastrar Disciplina';
         $this->params['arvore']=[
            [
                'url' => 'admin/disciplina',
                'titulo' => 'Disciplina'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]];
        $params = $this->params;
        return view('admin.disciplina.create',compact('params'));
    }

    public function store(DisciplinaRequest $request)
    {
        $dataForm  = $request->all();

        $insert = $this->disciplina->create($dataForm);
        if($insert){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function show($id)
    {
        $this->params['subtitulo']='Deletar Disciplina';
        $this->params['arvore']=[
           [
               'url' => 'admin/disciplina',
               'titulo' => 'Disciplina'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->disciplina->find($id);
       return view('admin.disciplina.show',compact('params','data'));
    }

    public function edit($id)
    {
        $this->params['subtitulo']='Editar Disciplina';
        $this->params['arvore']=[
           [
               'url' => 'admin/disciplina',
               'titulo' => 'Disciplina'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->disciplina->find($id);
       return view('admin.disciplina.create',compact('params', 'data'));
    }

    public function update(DisciplinaUpdateRequest $request, $id)
    {
        $data = $this->disciplina->find($id);

        if($data->update($request->all())){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->disciplina->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
