<?php

namespace App\Http\Controllers\Api\Professor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\Aula\AulaInsertRequest;
use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    private $aula;

    public function __construct(Aula $aulas)
    {
        $this->aula = $aulas;
    }

    public function cadastraraula(AulaInsertRequest $request)
    {
        // "disciplina_id", "sala_id", "professor_id"

        $dataForm  = $request->all();
        if($this->aula->cadastrarAulaProfessor($dataForm)){
            return response()->json(true, 201);
        }else{
            return response()->json([
                'message'   => 'Erro ao Cadastrar Aula',
                'errors'    => 'Erro ao Cadastrar Aula'
            ], 422);
        }
    }
}
