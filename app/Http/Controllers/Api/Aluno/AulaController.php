<?php

namespace App\Http\Controllers\Api\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Aula;

class AulaController extends Controller
{
    public function ativas($aula_id)
    {
        $aula = new Aula();
        return $aula->ativas($aula_id);
    }

    public function aulasala($id)
    {
        $aula = new Aula();
        return $aula->aulasala($id);
    }
}
