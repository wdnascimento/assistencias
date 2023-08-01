<?php

namespace App\Http\Controllers\Api\Aluno;

use App\Events\AulasAtivasEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Aluno\DesistirSenhaRequest;
use App\Http\Requests\Api\Aluno\PegarSenhaRequest;
use App\Models\Atendimento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class AlunoController extends Controller
{
    public $atendimento;

    public function __construct(Atendimento $atendimentos) {
        $this->atendimento = $atendimentos;
    }

    public function pegarsenha(PegarSenhaRequest $request)
    {
        $dataForm  = $request->only('aula_id');
        $dataForm['user_id'] = Auth::User()->id;

        if($this->atendimento->solicitarSenha($dataForm)){
            return response()->json(true, 201);
        }else{
            return response()->json([
                'message'   => 'Erro ao Retirar Senha',
                'errors'    => 'Erro ao Retirar Senha'
            ], 422);
        }
    }

    public function desistirsenha(DesistirSenhaRequest $request)
    {
        $dataForm  = $request->only('aula_id');
        $dataForm['user_id'] = Auth::User()->id;

        if($this->atendimento->desistirSenha($dataForm)){
            return response()->json(true, 201);
        }else{
            return response()->json([
                'message'   => 'Erro ao Desistir Senha',
                'errors'    => 'Erro ao Desistir Senha'
            ], 422);
        }
    }
}
