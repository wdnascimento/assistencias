<?php

namespace App\Http\Controllers\Admin;

use App\Events\AulasAtivasEvent;
use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Atendimento;
use App\Models\Disciplina;
use App\Models\Professor;
use App\Models\Sala;
use Auth;
use App\Http\Requests\Admin\Aula\AulaInsertRequest;
use App\Http\Requests\Admin\Aula\AulaAtivarRequest;
use Illuminate\Support\Facades\Event;

class AulaController extends Controller
{
    public function __construct(Aula $aulas, Atendimento $atendimentos, Disciplina $disciplinas, Professor $professores, Sala $salas)
    {
        $this->aula = $aulas;
        $this->atendimento = $atendimentos;
        $this->disciplina = $disciplinas;
        $this->professor = $professores;
        $this->sala = $salas;

        // Default values
        $this->params['titulo']='Aula';
        $this->params['main_route']='admin.aula';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Aulas Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/aula',
                    'titulo' => 'Aulas'
        ];

        $params = $this->params;
        $data = $this->aula ->with('sala')
                            ->with('professor')
                            ->with('disciplina')
                            ->orderBy('status','desc')
                            ->orderBy('inicio','desc')
                            ->paginate(30);
      //  dd($data);
        return view('admin.aula.index',compact('params','data'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Aula';
        $this->params['arvore']=[
           [
               'url' => 'admin/aula',
               'titulo' => 'Aula'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;

       $preload['disciplinas'] = $this->disciplina->orderBy('titulo')->get()->pluck('titulo','id');
       $preload['professores'] = $this->professor->orderBy('name')->get()->pluck('name','id');
       $preload['salas'] = $this->sala->orderBy('titulo')->get()->pluck('titulo','id');

       return view('admin.aula.create',compact('params','preload'));
    }

    public function store(AulaInsertRequest $request)
    {
        $dataForm  = $request->all();

        $dataForm['created_by'] = Auth::user()->email;

        $insert = $this->aula->create($dataForm);
        if($insert){
            if($this->atendimento->setAtendido()){
                Event::dispatch(new AulasAtivasEvent(1));
                return redirect()->route($this->params['main_route'].'.index');
            }
        }
        Event::dispatch(new AulasAtivasEvent(1));
        return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);

    }



    public function ativar(AulaAtivarRequest  $request,  $id)
    {
        $dataForm  = $request->all();

        $data = $this->aula->find($id);

        $dataForm['status']  = 1;

        if($data->update($dataForm)){
            Event::dispatch(new AulasAtivasEvent());
            return redirect()->route($this->params['main_route'].'.index');

        }else{
            Event::dispatch(new AulasAtivasEvent());
            return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao editar.']);
        }

    }

    public function desativar($id)
    {
        $data = $this->aula->find($id);

        $dataForm['status']  = 0;

        if($data->update($dataForm)){
            Event::dispatch(new AulasAtivasEvent());
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            Event::dispatch(new AulasAtivasEvent());
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }
}
