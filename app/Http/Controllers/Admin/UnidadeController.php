<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Unidade\UnidadeRequest;
use App\Models\Unidade;

class UnidadeController extends Controller
{
    public function __construct(Unidade $unidades)
    {
        $this->unidade = $unidades;

        // Default values
        $this->params['titulo']='Unidade';
        $this->params['main_route']='admin.unidade';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Unidades Cadastradas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/unidade',
                    'titulo' => 'Unidade'
        ];

        $params = $this->params;
        $data = $this->unidade->all();

        return view('admin.unidade.index',compact('params','data'));
    }

    public function create()
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Cadastrar Unidade';
         $this->params['arvore']=[
            [
                'url' => 'admin/unidade',
                'titulo' => 'Unidade'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]];
        $params = $this->params;
        return view('admin.unidade.create',compact('params'));
    }

    public function store(UnidadeRequest $request)
    {
        $dataForm  = $request->all();

        $insert = $this->unidade->create($dataForm);
        if($insert){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function edit($id)
    {
        $this->params['subtitulo']='Editar Unidade';
        $this->params['arvore']=[
           [
               'url' => 'admin/unidade',
               'titulo' => 'Unidade'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->unidade->find($id);
       return view('admin.unidade.create',compact('params', 'data'));
    }

    public function update(UnidadeRequest $request, $id)
    {
        $data = $this->unidade->find($id);
        $dataForm = $request->all();
        $dataForm['status'] = isset($dataForm['status']) ? 1 : 0;

        if($data->update($dataForm)){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }
}
