<?php

namespace App\Http\Controllers\Admin;

use App\Events\SalasAtivasEvent;
use App\Http\Controllers\Controller;
use App\Models\Sala;
use App\Http\Requests\Admin\Sala\SalaRequest;
use App\Models\Turma;
use Exception;
use Illuminate\Support\Facades\Event;

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
        $data = $this->sala->all();

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
        $preload['turma_id'] = $this->turma->orderBy('titulo')->get()->pluck('titulo','id');
        return view('admin.sala.create',compact('params','preload'));
    }

    public function store(SalaRequest $request)
    {
        $dataForm  = $request->all();

        $dataForm['turma_id'] =1;
        $insert = $this->sala->create($dataForm);
        if($insert){
            try{
                Event::dispatch(new SalasAtivasEvent(1));

            }catch(Exception $e){
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Erro ao Registrar Evento.']);
            }

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
       $preload['turma_id'] = $this->turma->orderBy('titulo')->get()->pluck('titulo','id');
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

        $preload['turma_id'] = $this->turma->orderBy('titulo')->get()->pluck('titulo','id');
       return view('admin.sala.create',compact('params', 'data','preload'));
    }

    public function update(SalaRequest $request, $id)
    {
        $data= $request->all();
        $data['dataForm'] =1;

        if($this->sala->find($id)->update($data)){
            try{
                Event::dispatch(new SalasAtivasEvent(1));

            }catch(Exception $e){
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Erro ao Registrar Evento.']);
            }
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->sala->find($id);

        if($data->delete()){
            try{
                Event::dispatch(new SalasAtivasEvent(1));

            }catch(Exception $e){
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Erro ao Registrar Evento.']);
            }
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
