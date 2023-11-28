<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disciplina;
use App\Http\Requests\Admin\Disciplina\DisciplinaRequest ;
use App\Http\Requests\Admin\Disciplina\DisciplinaUpdateRequest;
use App\Models\GrupoDisciplina;

class DisciplinaController extends Controller
{

    private $params, $disciplina, $grupo_disciplina;
    public function __construct(Disciplina $disciplinas, GrupoDisciplina $grupo_disciplinas)
    {
        $this->disciplina = $disciplinas;
        $this->grupo_disciplina = $grupo_disciplinas;

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
        $preload['grupo_disciplinas'] = $this->grupo_disciplina->orderBy('titulo')->pluck('titulo','id');

        return view('admin.disciplina.create',compact('params','preload'));
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
       $preload['grupo_disciplinas'] = $this->grupo_disciplina->orderBy('titulo')->pluck('titulo','id');
       return view('admin.disciplina.show',compact('params','data','preload'));
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
       $preload['grupo_disciplinas'] = $this->grupo_disciplina->orderBy('titulo')->pluck('titulo','id');

       return view('admin.disciplina.create',compact('params', 'data','preload'));
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
