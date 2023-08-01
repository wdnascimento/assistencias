<?php

namespace App\Http\Controllers\Api\Professor;

use App\Events\AulasAtivasEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\Atendimento\ChamarAtendimentoRequest;
use App\Models\Atendimento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class AtendimentoController extends Controller
{
    private $atendimento;
    public function __construct(Atendimento $atendimentos)
    {
        $this->atendimento = $atendimentos;
    }

    public function chamar(ChamarAtendimentoRequest  $request)
    {

        $dataForm  = $request->only('aula_id');

        $response = $this->atendimento->chamarProximo($dataForm);
        if($response['result']){
            return response()->json($response, 201);
        }else{
            return response()->json([
                'message'   => 'Erro ao Chamar Próximo',
                'errors'    => 'Erro ao Chamar Próximo'
            ], 422);
        }
    }

    public function pausar(ChamarAtendimentoRequest  $request)
    {
        $dataForm  = $request->only('aula_id');

        if($this->atendimento->pausarAtendimento($dataForm)){
            return response()->json(true, 201);
        }else{
            return response()->json([
                'message'   => 'Erro ao Pausar Atendimento',
                'errors'    => 'Erro ao Pausar Atendimento'
            ], 422);
        }


    }

    public function finalizar(ChamarAtendimentoRequest  $request)
    {

        $dataForm  = $request->only('aula_id');

        if($this->atendimento->finalizarAtendimento($dataForm)){
            return response()->json(true, 201);
        }else{
            return response()->json([
                'message'   => 'Erro ao Finalizar Atendimento',
                'errors'    => 'Erro ao Finalizar Atendimento'
            ], 422);
        }
    }

    public function getAluno($id){
        $aluno = new User();
        return $aluno->find($id);
    }

}
