<?php

namespace App\Http\Controllers\Aluno;

use App\Events\PegarSenhaEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Aluno\DesistirSenhaRequest;
use App\Http\Requests\Aluno\PegarSenhaRequest;
use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Atendimento;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Event;

class HomeController extends Controller
{


    public function __construct(Aula $aulas, Atendimento $atendimentos)
    {
        $this->aula = $aulas;
        $this->atendimento = $atendimentos;
        $this->params['main_route']= 'aluno' ;
    }
    public function index()
    {
        $data[1] = $this->aula->where('status',1)->where('sala_id',1)->with('atendimento')->with('hasAtendimentos')->get();
        $data[2] = $this->aula->where('status',1)->where('sala_id',2)->with('atendimento')->with('hasAtendimentos')->get();

        return view('aluno.home',compact('data'));
    }

    public function pegarsenha(PegarSenhaRequest $request)
    {
        $dataForm  = $request->all();
        $dataForm['user_id'] = Auth::User()->id;

        if($this->atendimento->solicitarSenha($dataForm)){

            $data = $this->aula->select('sala_id')->where('id',$dataForm['aula_id'])->first();
            // broadcast(new PegarSenhaEvent ($data->sala_id))->toOthers();
            Event::dispatch(new PegarSenhaEvent ($data->sala_id));

            return redirect()->route($this->params['main_route'].'.home');
        }else{
            return redirect()->route($this->params['main_route'].'.home')->withErrors(['Falha ao solicitar Senha']);
        }
    }

    public function desistirsenha(DesistirSenhaRequest $request)
    {
        $dataForm  = $request->all();
        $dataForm['user_id'] = Auth::User()->id;

        // data ['aula_id' , 'user_id']

        $data = $this->atendimento  ->where('aula_id',$dataForm['aula_id'])
                ->where('status',0)
                ->where('user_id',Auth::user()->id)
                ->first();

        if($this->atendimento->desistirSenha($data->id)){

            // Get SALA
            $data = $this->aula->select('sala_id')->where('id',$dataForm['aula_id'])->first();

            Event::dispatch(new PegarSenhaEvent ($data->sala_id));
            // broadcast()->toOthers();

            return redirect()->route($this->params['main_route'].'.home');
        }else{
            return redirect()->route($this->params['main_route'].'.home')->withErrors(['Falha ao solicitar Senha']);
        }
    }
}
