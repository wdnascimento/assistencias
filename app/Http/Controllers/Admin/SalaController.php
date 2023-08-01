<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sala;
use App\Http\Requests\Admin\Sala\SalaRequest;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;

class SalaController extends Controller
{
    public function __construct(Sala $salas, Turma $turmas)
    {
        $this->sala     = $salas;
        $this->turma    = $turmas;

        // Default values
        $this->params['titulo']='Sala';
        $this->params['main_route']='admin.sala';

    }


    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Salas Cadastradas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/sala',
                    'titulo' => 'Sala'
        ];

        $params = $this->params;
        $data = $this->sala->select('salas.*','turmas.titulo as desc_turma', 'unidades.titulo as desc_unidade')
                           ->join('turmas','turmas.id','salas.turma_id')
                           ->join('unidades','unidades.id','turmas.unidade_id')
                           ->orderBy('unidades.id')
                           ->paginate(20);

        return view('admin.sala.index',compact('params','data'));
    }

    public function create()
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Cadastrar Sala';
         $this->params['arvore']=[
            [
                'url' => 'admin/sala',
                'titulo' => 'Sala'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]];
        $params = $this->params;
        $preload['turma_id'] = $this->getTurmas();
        return view('admin.sala.create',compact('params','preload'));
    }

    public function store(SalaRequest $request)
    {
        $dataForm  = $request->all();

        $insert = $this->sala->create($dataForm);
        if($insert){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function show($id)
    {
        $this->params['subtitulo']='Deletar Sala';
        $this->params['arvore']=[
           [
               'url' => 'admin/sala',
               'titulo' => 'Sala'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->sala->find($id);
       $preload['turma_id'] = $this->getTurmas();
       return view('admin.sala.show',compact('params','data','preload'));
    }

    public function edit($id)
    {
        $this->params['subtitulo']='Editar Sala';
        $this->params['arvore']=[
           [
               'url' => 'admin/sala',
               'titulo' => 'Sala'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
               ]];
        $params = $this->params;
        $data = $this->sala->find($id);

        $preload['turma_id'] = $this->getTurmas();

        return view('admin.sala.create',compact('params', 'data','preload'));
    }

    public function update(SalaRequest $request, $id)
    {
        $data= $request->all();

        if($this->sala->find($id)->update($data)){

            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->sala->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }

    public function getTurmas(){
        return $this->turma
                                ->select(DB::raw("CONCAT(unidades.titulo,' - ', turmas.titulo) as titulo"),'turmas.id as id')
                                ->join('unidades','unidades.id','turmas.unidade_id')
                                ->orderBy('unidades.id')
                                ->orderBy('turmas.titulo')
                                ->get()
                                ->pluck('titulo','id');
    }
}
