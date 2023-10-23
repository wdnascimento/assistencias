<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atendimento;

class AtendimentoController extends Controller
{
    public function painel($sala_id){
        $atendimento = new Atendimento();
        return $atendimento->painelAtendimentoSala($sala_id);
    }
}
