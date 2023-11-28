<?php

namespace App\Http\Controllers\Api\Aluno;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Aluno\DesistirSenhaRequest;
use App\Http\Requests\Api\Aluno\PegarSenhaRequest;
use App\Models\Atendimento;
use Illuminate\Support\Facades\Auth;

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

        $error = $this->atendimento->solicitarSenha($dataForm);
        if($error['result']){
            return response()->json($error, 201);
        }else{
            return response()->json($error, 208);
        }
    }

    public function desistirsenha(DesistirSenhaRequest $request)
    {
        $dataForm  = $request->only('aula_id');
        $dataForm['user_id'] = Auth::User()->id;

        $error = $this->atendimento->desistirSenha($dataForm);
        if($error['result']){
            return response()->json($error, 201);
        }else{
            return response()->json($error, 208);
        }
    }
}
