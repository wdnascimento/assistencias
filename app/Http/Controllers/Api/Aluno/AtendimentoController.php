<?php

namespace App\Http\Controllers\Api\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Atendimento;

class AtendimentoController extends Controller
{
    public function filaaula($aula_id){
        $atendimento = new Atendimento();
        return $atendimento->filaAula($aula_id);
    }
}
