<?php

namespace App\Http\Controllers\Api\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Aula;

class AulaController extends Controller
{
    public function ativas()
    {
        return Aula::ativas();
    }
}
